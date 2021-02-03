<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Notif;
use App\Ulasan;
use App\User;
use Illuminate\Http\Request;

use App\Category;
use App\Product;

use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;

class ProductController extends Controller
{
    // function for validating product data before saving it into database
    public function validateProductData($request) {
        $validator = Validator::make($request, [
            'jenis' => 'required',
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
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();

        $products = Product::join('users','users.id','=','products.user_id')
            ->join('categories','categories.id','=','products.category_id')
            ->select('products.*','users.name as nama','users.kota','users.vip','categories.name as cate',DB::raw("(SELECT AVG(rating) FROM ulasans WHERE ulasans.product_id = products.id) as rate"))
            ->where('active',1)
            ->groupby('products.id','products.user_id','products.category_id','users.vip','products.name','products.price','products.description','products.totaunit','products.delivery','products.duration','products.image','products.type','products.active','products.created_at','products.updated_at','users.name','users.kota','categories.name')
            ->paginate(10);
        $rating = Ulasan::all();
        $categori = Category::all();
        $asc = 1;

        return view('product_list', compact('products' ,'chat','notif','rating','categori','asc'));
    }

    public function pro_find(Request $request){
        $type = $request->type;
        $game = $request->game;

        if($type !== null && $game !== null){
            $products = Product::join('users','users.id','=','products.user_id')
                ->join('categories','categories.id','=','products.category_id')
                ->select('products.*','users.name as nama','users.kota','users.vip','categories.name as cate',DB::raw("(SELECT AVG(rating) FROM ulasans WHERE ulasans.product_id = products.id) as rate"))
                ->where('active',1)
                ->where('products.type',$type)
                ->where('products.category_id',$game)
                ->groupby('products.id','products.user_id','products.category_id','products.name','users.vip','products.price','products.description','products.totaunit','products.delivery','products.duration','products.image','products.type','products.active','products.created_at','products.updated_at','users.name','users.kota','categories.name')
                ->paginate(10);
        }elseif ($type !== null && $game === null){
            $products = Product::join('users','users.id','=','products.user_id')
                ->join('categories','categories.id','=','products.category_id')
                ->select('products.*','users.name as nama','users.kota','users.vip','categories.name as cate',DB::raw("(SELECT AVG(rating) FROM ulasans WHERE ulasans.product_id = products.id) as rate"))
                ->where('active',1)
                ->where('products.type',$type)
                ->groupby('products.id','products.user_id','products.category_id','products.name','products.price','users.vip','products.description','products.totaunit','products.delivery','products.duration','products.image','products.type','products.active','products.created_at','products.updated_at','users.name','users.kota','categories.name')
                ->paginate(10);
        }elseif ($type === null && $game !== null){
            $products = Product::join('users','users.id','=','products.user_id')
                ->join('categories','categories.id','=','products.category_id')
                ->select('products.*','users.name as nama','users.kota','users.vip','categories.name as cate',DB::raw("(SELECT AVG(rating) FROM ulasans WHERE ulasans.product_id = products.id) as rate"))
                ->where('active',1)
                ->where('products.category_id',$game)
                ->groupby('products.id','products.user_id','products.category_id','products.name','products.price','users.vip','products.description','products.totaunit','products.delivery','products.duration','products.image','products.type','products.active','products.created_at','products.updated_at','users.name','users.kota','categories.name')
                ->paginate(10);
        }else{
            $products = Product::join('users','users.id','=','products.user_id')
                ->join('categories','categories.id','=','products.category_id')
                ->select('products.*','users.name as nama','users.kota','users.vip','categories.name as cate',DB::raw("(SELECT AVG(rating) FROM ulasans WHERE ulasans.product_id = products.id) as rate"))
                ->where('active',1)
                ->groupby('products.id','products.user_id','products.category_id','products.name','products.price','products.description','users.vip','products.totaunit','products.delivery','products.duration','products.image','products.type','products.active','products.created_at','products.updated_at','users.name','users.kota','categories.name')
                ->paginate(10);
        }
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();

        $rating = Ulasan::all();
        $categori = Category::all();

        $datas = array(
            'products' => $products,
            'rating' => $rating,
            'categori' => $categori,
            'chat' => $chat,
            'notif' => $notif,
            'asc' => 1
        );

        return view('product_list', $datas);
    }

    // function for showing cart page
    public function cart() {
        // Session::forget('cart_session');
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $cart = Session::get('cart_session');

        // dd($cart);

        return view('cart', compact('cart','chat','notif'));
    }

    // function for adding selected clothes into cart
    public function addToCart(Request $request ,Product $product) {
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
                    $cart['products'][$index]->quantity += $request->quan;
                    $cart['products'][$index]->price =  $cart['products'][$index]->price * $request->quan;
                }
            }
        } else {
            $flag = true;
            $product->quantity = $request->quan;
            $product->price = $product->price * $request->quan;
            array_push($cart['products'], $product);
        }

        if (!$flag) {
            $product->quantity = $request->quan;
            $product->price = $product->price * $request->quan;
            array_push($cart['products'], $product);
        }

        $total_amount = 0;

        foreach ($cart['products'] as $item) {
            $quantity = $item->quantity;
            $total_amount += $item->price;

            $product = Product::findOrFail($item->id);

            $product->update([
                'totaunit' => $item->totaunit - $quantity
            ]);
        }

        $cart['total_amount'] = $total_amount;
        $user_vip = User::where('id',$product->user_id)->first();
        $cart['user'] = $user_vip->vip;

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
            'totaunit' => $product->totaunit + $item['quantity']
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
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();

        return view('product_list', compact('products','chat','notif'));
    }

    //function for showing manage-product page
    public function manageProduct() {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $userid = Auth::user()['id'];
        $products = Product::where('user_id',$userid)->where('active',1)->paginate(8);
        return view('manage_product', compact('products','chat','notif'));
    }

    // function for showing add-product page
    public function addProductPage() {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $categories = Category::all();

        return view('add_product', compact('categories','chat','notif'));
    }

    // function for storing product into database
    public function addProduct(Request $request) {
        $this->validateProductData($request->all())->validate();

        $image = $request->file('image');
        $names = time().'.'.$image->getClientOriginalName();
        $directory='image';
        $image->move($directory,$names);

        $user = Auth::user();

        if($request->deliv == 'kosong'){
            $temp = $request->deliver;

        }else{
            $temp = $request->deliv;
        }

        $product = new Product([
            'type' => $request->jenis,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'totaunit' => $request->totunit,
            'delivery' =>  $temp,
            'duration' => $request->dur,
            'category_id' => $request->category,
            'image' => $names,
            'active' => 1
        ]);

        $product->user()->associate($user);
        $product->save();

        return redirect('/manageClothes');
    }

    // function for showing edit-product page
    public function editProduct(Product $product) {
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $categories = Category::all();

        return view('edit_product', compact('product', 'categories','chat','notif'));
    }

    // function for updating selected product into database
    public function updateProduct(Product $product, Request $request) {
        $this->validateProductData($request->all())->validate();

        $image = $request->file('image');
        $names = time().'.'.$image->getClientOriginalName();
        $directory='image';
        $image->move($directory,$names);

        if($request->deliv == 'kosong'){
            $temp = $request->deliver;

        }else{
            $temp = $request->deliv;
        }

        $product->update([
            'type' => $request->jenis,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'totaunit' => $request->totunit,
            'delivery' =>  $temp,
            'duration' => $request->dur,
            'category_id' => $request->category,
            'image' => $names
        ]);

        return redirect('/manageClothes');
    }

    // function for deleteing selected product from database
    public function deleteProduct(Product $product) {
        $product->delete();

        return redirect()->back();
    }

    public function detailProduct($id){
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $pro = Product::join('users','users.id','=','products.user_id')
            ->join('categories','categories.id','=','products.category_id')
            ->where('products.id',$id)
            ->select('products.*','users.name as nama','users.kota','categories.name as cate')
            ->first();
        $ulasan = Ulasan::join('users','users.id','=','ulasans.user_id')
            ->select('ulasans.*','users.profile_picture','users.name')
            ->where('ulasans.product_id',$id)->orderBy('ulasans.date','desc')->paginate(5);
        $rating = Ulasan::where('product_id',$id)->get();
        if(count($rating)==0) {
            $ratetotal = 0;
            $temp = 0;
        }else {
            $temp = 0;
            $rate = 0;
            foreach ($rating as $r){
                $rate += $r->rating;
                $temp +=1;
            }
            $ratetotal = $rate / $temp;
        }
        $asc = 1;
        $active = 'desc';

        return view('view_detail',compact('pro','chat','notif','ulasan','ratetotal','temp','rating', 'active','asc'));
    }

    public function detailProductSort(Request $request){
        if($request->asc == 1){
            $ulasan = Ulasan::join('users','users.id','=','ulasans.user_id')
                ->select('ulasans.*','users.profile_picture','users.name')
                ->where('ulasans.product_id',$request->id)->orderBy('ulasans.rating','asc')->paginate(5);
        }elseif($request->asc == 2){
            $ulasan = Ulasan::join('users','users.id','=','ulasans.user_id')
                ->select('ulasans.*','users.profile_picture','users.name')
                ->where('ulasans.product_id',$request->id)->orderBy('ulasans.rating','desc')->paginate(5);
        }
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();
        $pro = Product::join('users','users.id','=','products.user_id')
            ->join('categories','categories.id','=','products.category_id')
            ->where('products.id',$request->id)
            ->select('products.*','users.name as nama','users.kota','categories.name as cate')
            ->first();
        $rating = Ulasan::where('product_id',$request->id)->get();
        if(count($rating)==0) {
            $ratetotal = 0;
            $temp = 0;
        }else {
            $temp = 0;
            $rate = 0;
            foreach ($rating as $r){
                $rate += $r->rating;
                $temp +=1;
            }
            $ratetotal = $rate / $temp;
        }

        $data = array(
            'pro' => $pro,
            'chat' => $chat,
            'notif' => $notif,
            'temp' => $temp,
            'ratetotal' => $ratetotal,
            'rating' => $rating,
            'ulasan' => $ulasan,
            'active' => 'sort',
            'asc' => $request->asc
        );

        return view('view_detail', $data);
    }

    public function dash_rating_sort(Request $request){
        $chat = Notif::join('products as p','p.id','=','notifs.product_id')->select('notifs.*','p.image','p.name')->where('notifs.buyer_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->orWhere('notifs.seller_id',Auth::user()['id'])->where('notifs.active',Auth::user()['id'])->get();
        $notif =$notif = Notif::where('active',Auth::user()['id'])->count();

        if($request->asc == 1){
            $products = Product::join('users','users.id','=','products.user_id')
                ->join('categories','categories.id','=','products.category_id')
                ->select('products.*','users.name as nama','users.kota','categories.name as cate',DB::raw("(SELECT AVG(rating) FROM ulasans WHERE ulasans.product_id = products.id) as rate"))
                ->where('active',1)
                ->groupby('products.id','products.user_id','products.category_id','products.name','products.price','products.description','products.totaunit','products.delivery','products.duration','products.image','products.type','products.active','products.created_at','products.updated_at','users.name','users.kota','categories.name')
                ->orderby('rate','asc')
                ->paginate(10);
        }elseif ($request->asc == 2){
            $products = Product::join('users','users.id','=','products.user_id')
                ->join('categories','categories.id','=','products.category_id')
                ->select('products.*','users.name as nama','users.kota','categories.name as cate',DB::raw("(SELECT AVG(rating) FROM ulasans WHERE ulasans.product_id = products.id) as rate"))
                ->where('active',1)
                ->groupby('products.id','products.user_id','products.category_id','products.name','products.price','products.description','products.totaunit','products.delivery','products.duration','products.image','products.type','products.active','products.created_at','products.updated_at','users.name','users.kota','categories.name')
                ->orderby('rate','desc')
                ->paginate(10);
        }

        $rating = Ulasan::all();
        $categori = Category::all();

        $data = array(
            'products'=> $products,
            'notif' =>$notif,
            'chat' => $chat,
            'rating' => $rating,
            'categori' => $categori,
            'asc' => $request->asc
        );

        return view('product_list',$data);
    }

}
