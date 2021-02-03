<?php

namespace App\Http\Controllers;

use App\Chat;
use App\DetailTransaction;
use App\Notif;
use App\Product;
use App\Ulasan;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotifController extends Controller
{
    public function list_notif(){
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $user = User::all();
        $notiff = Notif::join('products as p','p.id','notifs.product_id')
            ->join('transactions as t','t.id','=','notifs.transaction_id')
            ->select('notifs.*','p.name','t.total_amount_plus_fee','p.image')
            ->where('seller_id',Auth::user()['id'])
            ->orWhere('buyer_id',Auth::user()['id'])
            ->orWhere('notifs.active',Auth::user()['id'])
            ->orderBy('notifs.date','desc')
            ->paginate(8);
        $quantity = DetailTransaction::all();

        return view('notif',compact('chat','notif','notiff','user','quantity'));
    }

    public function finish_trans($id,$ids){
        DB::table('notifs')
            ->where('id',$id)
            ->update(['active' => $ids,'struktur' => 4]);

        $not = Notif::where('id',$id)->first();
        DB::table('transactions')
            ->where('id',$not->transaction_id)
            ->update(['active' => 1]);

        return redirect('/notif');
    }

    public function add_ulasan(Request $request ,$id){
        $data = new Ulasan([
            'user_id' => Auth::user()['id'],
            'product_id' => $id,
            'ulasan' => $request->name,
            'rating' => $request->rate,
            'date' => Carbon::now()
        ]);
        $data->save();

        $seller = Product::where('id',$id)->first();

        DB::table('notifs')
            ->where('product_id',$id)
            ->where('buyer_id',Auth::user()['id'])
            ->where('seller_id',$seller->user_id)
            ->update(['active' => 0]);

        return redirect('/notif');
    }

    public function form_ulasan($id){
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif = Notif::where('active',Auth::user()['id'])->count();
        $data = Product::where('id',$id)->first();

        return view('ulasan',compact('data','chat','notif'));
    }

    public function post_bukti(Request $request, $id){
        $image = $request->file('image');
        $names = time().'.'.$image->getClientOriginalName();
        $directory='image';
        $image->move($directory,$names);

        DB::table('notifs')
            ->where('id',$id)
            ->update(['struktur' => 2, 'active' => 2, 'bukti' => $names]);
        return redirect('/notif');
    }

    public function process($id,$ids){
        DB::table('notifs')
            ->where('id',$id)
            ->update(['active' => $ids,'struktur' => 3]);

        return redirect('/notif');
    }

}
