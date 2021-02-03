<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/productList');
});

Auth::routes();

Route::get('/home', 'ProductController@productList')->name('home');

Route::group(['middleware' => 'admin'], function() {
    Route::get('/manageCategory', 'CategoryController@manageCategory')->name('manage_category');
    Route::get('/addCategory', 'CategoryController@addCategoryPage')->name('add_category_page');
    Route::post('/addCategory', 'CategoryController@addCategory')->name('add_category');
    Route::get('/editCategory/{category}', 'CategoryController@editCategory')->name('edit_category');
    Route::put('/updateCategory/{category}', 'CategoryController@updateCategory')->name('update_category');
    Route::delete('/deleteCategory/{category}', 'CategoryController@deleteCategory')->name('delete_category');
});

Route::get('/productList', 'ProductController@productList')->name('product_list');
Route::post('/search', 'ProductController@searchProduct')->name('search_product');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/cart', 'ProductController@cart')->name('cart');
    Route::post('/addToCart/{product}', 'ProductController@addToCart')->name('add_to_cart');
    Route::delete('/deleteItemOnCart/{index}', 'ProductController@deleteItemOnCart')->name('delete_item_on_cart');

    Route::group(['middleware' => 'admin'], function() {
        Route::get('/manageClothes', 'ProductController@manageProduct')->name('manage_product');
        Route::get('/addClothes', 'ProductController@addProductPage')->name('add_product_page');
        Route::post('/addClothes', 'ProductController@addProduct')->name('add_product');
        Route::get('/editClothes/{product}', 'ProductController@editProduct')->name('edit_product');
        Route::put('/updateClothes/{product}', 'ProductController@updateProduct')->name('update_product');
        Route::delete('/deleteClothes/{product}', 'ProductController@deleteProduct')->name('delete_product');
    });
});

Route::group(['middleware' => 'admin'], function() {
    Route::get('/managePromo', 'PromoController@managePromo')->name('manage_promo');
    Route::get('/addPromo', 'PromoController@addPromoPage')->name('add_promo_page');
    Route::post('/addPromo', 'PromoController@addPromo')->name('add_promo');
    Route::get('/editPromo/{promo}', 'PromoController@editPromo')->name('edit_promo');
    Route::put('/updatePromo/{promo}', 'PromoController@updatePromo')->name('update_promo');
    Route::delete('/deletePromo/{promo}', 'PromoController@deletePromo')->name('delete_promo');
});

Route::get('/transactionList', 'TransactionController@transactionList')->name('transaction_list')->middleware('admin');
Route::post('/checkout', 'TransactionController@insertTransaction')->name('checkout')->middleware('auth');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/myProfile', 'UserController@myProfile')->name('my_profile');
    Route::get('/myProfile/edit', 'UserController@editMyProfile')->name('edit_my_profile');
    Route::put('/myProfile/update', 'UserController@updateMyProfile')->name('update_my_profile');
});

Route::group(['middleware' => 'admin'], function() {
    Route::get('/manageUser', 'UserController@manageUser')->name('manage_user');
    Route::get('/userProfile/{user}', 'UserController@userProfile')->name('user_profile');
    Route::put('/userProfile/{user}/update', 'UserController@updateUserProfile')->name('update_user_profile');
    Route::delete('/userProfile/{user}/delete', 'UserController@deleteUser')->name('delete_user');
});