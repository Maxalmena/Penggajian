<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Notif;
use Illuminate\Http\Request;

use App\User;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    // function for validating user data before saving it into database
    public function validateUserData($request) {
        $validator = Validator::make($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|numeric|digits_between:11,12',
            'gender' => 'required|in:Male,Female',
            'address' => 'required|min:15',
            'profile_picture' => 'mimes:jpeg,jpg,png'
        ]);

        return $validator;
    }


    // function for showing my profile page
    public function myProfile() {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $user = Auth::user();

        return view('my_profile', compact('user','chat','notif'));
    }

    // function for showing edit-my-profile page
    public function editMyProfile() {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $user = Auth::user();

        return view('edit_my_profile', compact('user','chat','notif'));
    }

    // function for updating my-profile into database
    public function updateMyProfile(Request $request) {
        $image = $request->file('profile_picture');
        $names = time().'.'.$image->getClientOriginalName();
        $directory='image';
        $image->move($directory,$names);

        $user = Auth::user();

        if ($names != null) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address,
                'profile_picture' => $names
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address,
            ]);
        }

        return redirect('/myProfile');
    }

    // function for showing manage-user page
    public function manageUser() {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $users = User::paginate(5);
        
        return view('manage_user', compact('users','chat','notif'));
    }

    // function for showing selected user profile page
    public function userProfile(User $user) {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        return view('user_profile', compact('user','chat','notif'));
    }

    // function for updating selected user profile into database
    public function updateUserProfile(Request $request, User $user) {
        $image = $request->file('profile_picture');
        $names = time().'.'.$image->getClientOriginalName();
        $directory='image';
        $image->move($directory,$names);

        if ($names != null) {

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address,
                'profile_picture' => $names
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address,
            ]);
        }

        return redirect('/manageUser');
    }

    // function for deleting selected user from database
    public function deleteUser(User $user) {
        $user->delete();

        return redirect()->back();
    }

    public function vipuser($id){
        DB::table('users')
            ->where('id',$id)
            ->update(['vip' => 1]);
        return redirect('/manageUser');
    }
}
