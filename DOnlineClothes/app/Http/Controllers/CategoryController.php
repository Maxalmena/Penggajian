<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

use Validator;

class CategoryController extends Controller
{
    // function for validating category data before saving it into database
    public function validateCategoryData($request) {
        $validator = Validator::make($request, [
            'name' => 'required',
            'category_gender' => 'required|in:Male,Female',
            'category_age' => 'required|numeric|min:1'
        ]);

        return $validator;
    }

    // function for showing manage-category page
    public function manageCategory() {
        $categories = Category::all();
        
        return view('manage_category', compact('categories'));
    }

    // function for showing add-category page
    public function addCategoryPage() {
        return view('add_category');
    }

    // function for storing category into database with validation
    public function addCategory(Request $request) {
        $this->validateCategoryData($request->all())->validate();

        $category = Category::create([
            'name' => $request->name,
            'category_gender' => $request->category_gender,
            'category_age' => $request->category_age
        ]);

        return redirect('/manageCategory');
    }

    // function for showing edit-category page
    public function editCategory(Category $category) {
        return view('edit_category', compact('category'));
    }

    // function for updating selected category into database
    public function updateCategory(Request $request, Category $category) {
        $this->validateCategoryData($request->all())->validate();

        $category->update([
            'name' => $request->name,
            'category_gender' => $request->category_gender,
            'category_age' => $request->category_age
        ]);

        return redirect('/manageCategory');
    }

    // function for deleting selected category from database
    public function deleteCategory(Category $category) {
        $category->delete();

        return redirect()->back();
    }
}
