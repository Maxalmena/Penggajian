<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Product;

use Auth;
use Session;
use Validator;

class ProductController extends Controller
{
    // function for validating product data before saving it into database
    public function validateProductData($request) {
        $validator = Validator::make($request, [
            'category' => 'required|not_in:-1',
            'name' => 'required',
            'price' => 'required|numeric|min:10000',
            'description' => 'required',
            'stock' => 'required|numeric|min:1',
            'image' => 'required|mimes:jpeg,png,jpg|max:5000'
        ]);

        return $validator;
    }

    // function for showing list of product page
    public function productList() {
        $products = Product::paginate(8);

        return view('product_list', compact('products'));
    }

    // function for showing cart page
    public function cart() {
        // Session::forget('cart_session');
        $cart = Session::get('cart_session');

        // dd($cart);

        return view('cart', compact('cart'));
    }

    // function for adding selected clothes into cart
    public function addToCart(Product $product) {
        $old_cart = Session::get('cart_session');

        $cart['products'] = [];

        if ($old_cart != null) {
            $cart = $old_cart;
        }

        $flag = false;

        if (!empty($cart['products'])) {
            foreach ($cart['products'] as $index => $item) {
                if ($item->id == $product->id) {
                    $flag = true;
                    $cart['products'][$index]->quantity += 1;
                }
            }
        } else {
            $flag = true;
            $product->quantity = 1;
            array_push($cart['products'], $product);
        }

        if (!$flag) {
            $product->quantity = 1;
            array_push($cart['products'], $product);
        }

        $total_amount = 0;

        foreach ($cart['products'] as $item) {
            $quantity = $item->quantity;
            $total_amount += $item->price * $quantity;

            $product = Product::findOrFail($item->id);

            $product->update([
                'stock' => $item->stock - $quantity
            ]);
        }

        $cart['total_amount'] = $total_amount;

        Session::put('cart_session', $cart);

        return redirect('/cart');
    }

    // function for removing selected item on cart
    public function deleteItemOnCart($index) {
        $cart = Session::get('cart_session');

        $item = $cart['products'][$index];

        $amount = $item['price'] * $item['quantity'];

        $product = Product::findOrFail($item['id']);

        $product->update([
            'stock' => $product->stock + $item['quantity']
        ]);

        unset($cart['products'][$index]);

        if (empty($cart['products'])) {
            Session::forget('cart_session');
        } else {
            $cart['products'] = array_values($cart['products']);

            $cart['total_amount'] -= $amount;

            Session::put('cart_session', $cart);
        }

        return redirect()->back();
    }

    // function for searching product based on name or description
    public function searchProduct(Request $request) {
        $search_string = $request->search_string;

        $products = Product::whereRaw("LOWER(name) LIKE '%" . strtolower($search_string) . "%'")
                        ->orWhereRaw("LOWER(description) LIKE '%" . strtolower($search_string) . "%'")
                        ->paginate(8);

        return view('product_list', compact('products'));
    }

    //function for showing manage-product page
    public function manageProduct() {
        $products = Product::paginate(8);

        return view('manage_product', compact('products'));
    }

    // function for showing add-product page
    public function addProductPage() {
        $categories = Category::all();

        return view('add_product', compact('categories'));
    }

    // function for storing product into database
    public function addProduct(Request $request) {
        $this->validateProductData($request->all())->validate();

        $image = $request->file('image');
        $path = $image->store('public/image');

        $user = Auth::user();

        $product = new Product([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'category_id' => $request->category,
            'image' => $path
        ]);

        $product->user()->associate($user);
        $product->save();

        return redirect('/manageClothes');
    }

    // function for showing edit-product page
    public function editProduct(Product $product) {
        $categories = Category::all();

        return view('edit_product', compact('product', 'categories'));
    }

    // function for updating selected product into database
    public function updateProduct(Product $product, Request $request) {
        $this->validateProductData($request->all())->validate();

        $image = $request->file('image');
        $path = $image->store('public/image');

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'category_id' => $request->category,
            'image' => $path
        ]);

        return redirect('/manageClothes');
    }

    // function for deleteing selected product from database
    public function deleteProduct(Product $product) {
        $product->delete();

        return redirect()->back();
    }
}
