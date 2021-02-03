<?php

namespace App\Http\Controllers;

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
        $transactions = Transaction::with('detailTransactions')->get();

        return view('transaction_history', compact('transactions'));
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
                $total_amount = $cart['total_amount'] - ($cart['total_amount']*$promo->promo_discount)/100;
            } else {
                $errors['code'] = ['Promo code does not exists!'];
                return view('cart', compact('cart'))->withErrors($errors);
            }
        } else {
            $promo = null;
            $total_amount = $cart['total_amount'];
        }

        $transaction = new Transaction([
            'promo_id' => $promo['id'],
            'transaction_date' => Carbon::now(),
            'total_amount_before_discount' => $cart['total_amount'],
            'total_amount_after_discount' => $total_amount
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

            $product = Product::findOrFail($item->id);
        }

        Session::forget('cart_session');

        return redirect('/transactionList');
    }
}
