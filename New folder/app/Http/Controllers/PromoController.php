<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Notif;
use Illuminate\Http\Request;

use App\Promo;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Validator;

class PromoController extends Controller
{
    // function for validating promo data before saving it into database
    public function validatePromoData($request) {
        $validator = Validator::make($request, [
            'name' => 'required',
            'code' => 'required|between:10,30|alpha_dash',
            'promo_discount' => 'required|between:1,99',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        return $validator;
    }

    // function for showing manage-promo page
    public function managePromo() {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $promoes = Promo::where('start_date', '<=', Carbon::now())
                        ->Where('end_date', '>=', Carbon::now())->get();

        return view('manage_promo', compact('promoes','chat','notif'));
    }

    // function for showing add-promo page
    public function addPromoPage() {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        return view('add_promo',compact('chat','notif'));
    }

    // function for storing promo into database with validation
    public function addPromo(Request $request) {
        $this->validatePromoData($request->all())->validate();

        $promo = Promo::create([
            'name' => $request->name,
            'type' => $request->type,
            'code' => $request->code,
            'promo_discount' => $request->promo_discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return redirect('/managePromo');
    }

    // function for showing edit-promo page
    public function editPromo(Promo $promo) {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        return view('edit_promo', compact('promo','chat','notif'));
    }

    // function for updating selected promo into database
    public function updatePromo(Promo $promo, Request $request) {
        $this->validatePromoData($request->all())->validate();

        $promo->update([
            'name' => $request->name,
            'code' => $request->code,
            'promo_discount' => $request->promo_discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return redirect('/managePromo');
    }

    // function for deleting selected promo from database
    public function deletePromo(Promo $promo) {
        $promo->delete();

        return redirect()->back();
    }
}
