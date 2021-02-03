<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Auth;
use Validator;

class UserController extends Controller
{
    // function for validating user data before saving it into database
    public function validateUserData($request) {
        $validator = Validator::make($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|numeric|digits_between:11,12',
            'gender' => 'required|in:Male,Female',
            'address' => 'required|regex:/(\bStreet\b)/',
            'profile_picture' => 'mimes:jpeg,jpg,png'
        ]);

        return $validator;
    }

    // function for showing my profile page
    public function myProfile() {
        $user = Auth::user();

        return view('my_profile', compact('user'));
    }

    // function for showing edit-my-profile page
    public function editMyProfile() {
        $user = Auth::user();

        return view('edit_my_profile', compact('user'));
    }

    // function for updating my-profile into database
    public function updateMyProfile(Request $request) {
        $this->validateUserData($request->all())->validate();

        $user = Auth::user();
        
        $profile_picture = $request->file('profile_picture');

        if ($profile_picture != null) {
            $path = $profile_picture->store('public/profile_picture');

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address,
                'profile_picture' => $path
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
        $users = User::paginate(5);
        
        return view('manage_user', compact('users'));
    }

    // function for showing selected user profile page
    public function userProfile(User $user) {
        return view('user_profile', compact('user'));
    }

    // function for updating selected user profile into database
    public function updateUserProfile(Request $request, User $user) {
        $this->validateUserData($request->all())->validate();
        
        $profile_picture = $request->file('profile_picture');

        if ($profile_picture != null) {
            $path = $profile_picture->store('public/profile_picture');

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address,
                'profile_picture' => $path
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
}
