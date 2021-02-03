<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Notif;
use App\User;
use Illuminate\Http\Request;

use App\Product;
use App\Transaction;
use App\Promo;
use App\DetailTransaction;

use Carbon\Carbon;

use Auth;
use Session;

class TransactionController extends Controller
{
    // function for showing transaction list page
    public function transactionList() {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $transactions = Transaction::with('detailTransactions')
            ->where('user_id',\Illuminate\Support\Facades\Auth::user()['id'])
            ->where('active',1)
            ->get();

        return view('transaction_history', compact('transactions','chat','notif'));
    }

    // function for checking promo code before checking out
    public function checkPromoCode($code) {
        $promo = Promo::whereRaw("UPPER(code) = '" . strtoupper($code) . "'")
                    ->Where('start_date', '<=', Carbon::now())
                    ->Where('end_date', '>=', Carbon::now())->first();
                    
        return $promo;
    }

    // function for saving cart into database
    public function insertTransaction(Request $request) {
        $cart = Session::get('cart_session');

        $user = Auth::user();

        $promo_code = $request->code;

        if ($promo_code != null) {
            $promo = $this->checkPromoCode($promo_code);

            if ($promo != null) {
                if($promo->type == 'nom'){
                    $total_amount = $cart['total_amount'] - $promo->promo_discount;
                }else{
                    $total_amount = $cart['total_amount'] - (($cart['total_amount']*$promo->promo_discount)/100);
                }

            } else {
                $errors['code'] = ['Promo code does not exists!'];
                return view('cart', compact('cart'))->withErrors($errors);
            }
        } else {
            $promo = null;
            $total_amount = $cart['total_amount'];
        }

        if($cart['user'] == 0){
            $fee = $total_amount *0.1;
        }else{
            $fee = 0;
        }

        $transaction = new Transaction([
            'promo_id' => $promo['id'],
            'transaction_date' => Carbon::now(),
            'total_amount_before_discount' => $cart['total_amount'],
            'total_amount_after_discount' => $total_amount,
            'total_amount_plus_fee' => $total_amount + $fee,
            'active' => 0
        ]);

        $transaction->user()->associate($user);
        $transaction->save();

        foreach ($cart['products'] as $item) {
            $detail_transaction = new DetailTransaction([
                'product_id' => $item->id,
                'quantity' => $item->quantity
            ]);

            $detail_transaction->transaction()->associate($transaction);
            $detail_transaction->save();

            $users = User::join('products','products.user_id','=','users.id')
                ->select('users.id as ids')
                ->where('products.id',$item->id)
                ->first();

            $notif = new Notif([
                'seller_id' => $users->ids,
                'buyer_id' => Auth::user()['id'],
                'product_id' =>$item->id,
                'active' => Auth::user()['id'],
                'date' => Carbon::now(),
                'struktur' => 1
            ]);
            $notif->transaction()->associate($transaction);
            $notif->save();

            $product = Product::findOrFail($item->id);
        }

        Session::forget('cart_session');

        return redirect('/transactionList');
    }
}
