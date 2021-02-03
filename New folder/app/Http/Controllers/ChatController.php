<?php

namespace App\Http\Controllers;

use App\Chat;
use App\ChatDetail;
use App\DetailChat;
use App\Notif;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{

    public function validateProductData($request) {
        $validator = Validator::make($request, [
            'name' => 'required'
        ]);

        return $validator;
    }

    public function addChat($id)
    {
        $chat = Chat::where('active', Auth::user()['id'])->where('user_id', Auth::user()['id'])->orWhere('seller_id', Auth::user()['id'])->where('active', Auth::user()['id'])->count();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $pro = Product::join('users as u','u.id','=','products.user_id')
            ->select('products.*','u.name as na')
            ->where('products.id', $id)->first();

        return view('add_chat', compact('pro', 'chat', 'notif'));
    }

    public function chatadd(Request $request, $id,$ids){
        $this->validateProductData($request->all())->validate();

        $check = Chat::where('seller_id',$ids)
            ->where('user_id',Auth::user()['id'])
            ->orWhere('seller_id',Auth::user()['id'])
            ->where('user_id',$ids)
            ->count();
        if($check == 0){
            $chat = new Chat([
                'seller_id' =>$ids,
                'user_id' => Auth::user()['id'],
                'active' => $ids,
                'user_active' => 0,
                'seller_active' =>1
            ]);
            $chat->save();
        }else{
            $datachat = Chat::where('seller_id',$ids)
                ->where('user_id',Auth::user()['id'])
                ->orWhere('seller_id',Auth::user()['id'])
                ->where('user_id',$ids)
                ->first();
            if($datachat->user_id == Auth::user()['id']){
                DB::table('chats')
                    ->where('id',$datachat->id)
                    ->update(['seller_active' => $datachat->seller_active+1]);
            }elseif ($datachat->seller_id == Auth::user()['id']){
                DB::table('chats')
                    ->where('id',$datachat->id)
                    ->update(['user_active' => $datachat->user_active+1]);
            }

        }

        $chatid = Chat::where('seller_id',$ids)
            ->where('user_id',Auth::user()['id'])
            ->orWhere('seller_id',Auth::user()['id'])
            ->where('user_id',$ids)
            ->first();

        $product = Product::where('id',$id)
            ->first();

        $detail = new ChatDetail([
            'id' => $chatid->id,
            'chat' => $request->name,
            'product_id' => $product->image,
            'struktur' => $ids,
            'active' => $ids,
            'date' => Carbon::now()
        ]);

        $detail->save();

        return redirect('/');
    }

    public function ChatHis()
    {
        $user = User::all();
        $chatt = Chat::join('chat_details', 'chat_details.id', '=', 'chats.id')
            ->select('chats.*', DB::raw('COUNT(chat_details.active) as con'))
            ->where('chats.seller_id', Auth::user()['id'])
            ->orWhere('chats.user_id', Auth::user()['id'])
            ->orWhere('chats.active',0)
            ->where('chats.seller_id', Auth::user()['id'])
            ->orWhere('chats.active',0)
            ->where('chats.user_id', Auth::user()['id'])
            ->groupBy('chats.id','chats.seller_id','chats.user_id','chats.active','chats.created_at','chats.updated_at','chats.user_active','chats.seller_active')
            ->orderBy('chat_details.date', 'desc')
            ->get();
        $list = Chat::where('user_id',Auth::user()['id'])
            ->where('active','seller_id')
            ->orWhere('seller_id',Auth::user()['id'])
            ->where('active','user_id')
            ->groupBy('chats.id','chats.seller_id','chats.user_id','chats.active','chats.created_at','chats.updated_at','chats.user_active','chats.seller_active')
            ->get();

        return view('chat_his', compact('chatt', 'user','list'));
    }

    public function detail($id){
        $detail = ChatDetail::where('id',$id)
            ->orderBy('date','asc')
            ->get();
        $chat = Chat::where('id',$id)
            ->where('seller_id',Auth::user()['id'])
            ->orWhere('id',$id)
            ->where('user_id',Auth::user()['id'])
            ->first();

        DB::table('chat_details')
            ->where('active',Auth::user()['id'])
            ->update(['active' => 0]);
        if($chat->active == Auth::user()['id']){
            if($chat->user_id == Auth::user()['id']){
                DB::table('chats')
                    ->where('id',$id)
                    ->update(['active' => 0,
                               'user_active' => 0 ]);
            }elseif ($chat->seller_id == Auth::user()['id']){
                DB::table('chats')
                    ->where('id',$id)
                    ->update(['active' => 0,
                        'seller_active' => 0 ]);
            }

        }


        if(Auth::user()['id'] == $chat->seller_id){
            $temp = $chat->user_id;
        }else{
            $temp = $chat->seller_id;
        }

        $user = User::where('id',$temp)->first();

        return view('/chat_detail',compact('detail','user','chat'));
    }

    public function insert_chat(Request $request,$id,$ids){


        $data = new ChatDetail;
        $data->id = $id;
        $data->chat = $request->name;
        $data->product_id = 0;
        $data->struktur = $ids;
        $data->active = $ids;
        $data->date = Carbon::now();
        $data->save();


        $chat = Chat::findOrFail($id);
        $chat->active = $ids;
        if($chat->seller_id == $ids){
            $chat->seller_active = $chat->seller_active +1;
        }elseif ($chat->user_id == $ids){
            $chat->user_active = $chat->user_active +1;
        }
        $chat->save();

    }
}
