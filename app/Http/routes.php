<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//use App\DB;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests;

Route::get('/', 'StoreController@index');
// route ajax sort products
Route::get('/ajax-sortproducts', function(){
	$sort = Input::get('sort');
	$product = Product::orderBy('price', $sort)->take(8)->get();
    return Response::json($product);

});

Route::get('store/subcategory/{cat_id}', 'StoreController@getSubcategory');


Route::get('store/subcategory/{cat_id}/ajax-sortproductsSub' , function($id){
	$sort = Input::get('sortSub');
	$product = Product::where('subcategories_id' , '=' , $id )->orderBy('price','=', $sort)->take(8)->get();
      return Response::json($product);

});
Route::get('store/search/', 'StoreController@getSearch');

Route::get('/ajax-search' , 'StoreController@Ajaxsearch');

Route::any('/ajax-price', 'StoreController@Ajaxprice');

Route::any('/ajax-products' , 'StoreController@Ajaxproducts');

Route::any('/ajax-brands', 'StoreController@Ajaxbrands');
Route::get('store/viewproduct/{id}' , 'StoreController@viewproduct');


Route::get('admin/categories/', 'AdminController@categoryIndex');

Route::post('/edit',[
	'uses' => 'AdminController@editCategory',
	'as' => '/edit']);



//Category 
//Route::get('admin/editCategory/{id}', 'AdminController@editCategory');
Route::post('updateCategory', 'AdminController@updateCategory');
Route::post('admin/storeCategories', 'AdminController@storeCategories');
Route::get('admin/deleteCat/{id}', 'AdminController@deleteCat');
Route::any('post/delete','AdminController@delete_post');
//End category

//subcategory
Route::get('admin/editSubcategory/{id}', 'AdminController@editSubcategory');
Route::post('updateSubcategory', 'AdminController@updateSubcategory');
Route::post('admin/storeSubcategories', 'AdminController@storeSubcategories');
Route::get('admin/deleteSub/{id}','AdminController@deleteSub');
//end subcategory


//Brand
Route::post('admin/storeBrands', 'AdminController@storeBrands');
Route::get('admin/editBrand/{id}', 'AdminController@editBrand');
Route::post('updateBrand', 'AdminController@updateBrand');

//end brand



Route::get('admin/products/', 'AdminController@productsIndex');
Route::post('admin/storeProducts', 'AdminController@storeProducts');
Route::get('admin/editProducts/{id}', 'AdminController@editProducts');
Route::get('admin/showPrducts/{id}', 'AdminController@showProducts');
Route::patch('updateProducts', 'AdminController@updateProducts');


Route::get('users/signin', 'UsersController@getSignin' );
Route::GET('users/newaccount' , 'UsersController@getNewaccount');
Route::POST('users/create' , 'UsersController@postCreate');
Route::POST('users/login' , 'UsersController@postSignin');
Route::GET('users/signout' , 'UsersController@getSignout');

//add cart

Route::post('store/cart/' ,'CartController@addToCart');
Route::get('store/viewcart/' ,'CartController@viewCart');
Route::post('store/viewcartplus' , 'CartController@amountIncrement');
Route::post('store/viewcartminus' , 'CartController@amountDecrement');
Route::get('store/cart/delete/{id}' ,'CartController@deleteCart');

//store orders
Route::post('store/order', 'OrderController@postOrder');
Route::get('/store/vieworders', 'OrderController@getIndex');
Route::post('store/viewproduct/addcart', 'StoreController@addtocart');

//store wishlist
Route::get('/store/viewwishlist', 'WishListController@viewWishlist');
Route::post('/store/addwishlist' ,'WishListController@addToWishlist');

Route::post('store/wishlistcart/' ,'WishListController@addToCart');

Route::get('store/wishlist/delete/{id}' ,'WishListController@deleteWishlist');

//dashboard every view

Route::get('admin/dashboard', 'AdminController@TrackProducts');
