<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Notif;
use Illuminate\Http\Request;

use App\Category;

use Illuminate\Support\Facades\Auth;
use Validator;

class CategoryController extends Controller
{
    // function for validating category data before saving it into database
    public function validateCategoryData($request) {
        $validator = Validator::make($request, [
            'name' => 'required',
        ]);

        return $validator;
    }

    // function for showing manage-category page
    public function manageCategory() {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $categories = Category::all();
        
        return view('manage_category', compact('categories','chat','notif'));
    }

    // function for showing add-category page
    public function addCategoryPage() {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        return view('add_category',compact('chat','notif'));
    }

    // function for storing category into database with validation
    public function addCategory(Request $request) {
        $this->validateCategoryData($request->all())->validate();

        $category = Category::create([
            'name' => $request->name,
        ]);

        return redirect('/manageCategory');
    }

    // function for showing edit-category page
    public function editCategory(Category $category) {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        return view('edit_category', compact('category','chat','notif'));
    }

    // function for updating selected category into database
    public function updateCategory(Request $request, Category $category) {
        $this->validateCategoryData($request->all())->validate();

        $category->update([
            'name' => $request->name,
        ]);

        return redirect('/manageCategory');
    }

    // function for deleting selected category from database
    public function deleteCategory(Category $category) {
        $category->delete();

        return redirect()->back();
    }
}
