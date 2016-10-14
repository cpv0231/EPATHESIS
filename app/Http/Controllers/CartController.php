<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Redirect;
use App\Category;
use App\Product;
use App\Cart;
use App\Brand;
use App\Subcategory;
use View;
use Auth;
use DB;
use Validator;
use Illuminate\Support\Facades\Input;
class CartController extends Controller
{

	 public function viewCart(Request $request){


    $user_id = Auth::user()->id;
    $cart_products = Cart::with('Products')->where('user_id', '=',$user_id)->get();
	 	$cart_total = Cart::with('Products')->where('user_id', '=',$user_id)->sum('total');
    $cart = Cart::where('user_id' , Auth::user()->id)->count();
	     

    
	 	return view('store/viewcart')
	 	->with('products_cart', $cart_products)
	 	->with('cart_total', $cart_total)
    ->with('cart',$cart)
	 	->with('category' , Category::all());
    	
    }


    public function addToCart(){

    	$rules = [
    		'amount' => 'required|numeric',
    		'product' => 'required|numeric|exists:products,id' // id exists in table
    	];
    	$validator = Validator::make(Input::all(),$rules);

    	if($validator->fails()){
    		return Redirect::to('/')->with('error', 'The product is already on your cart');
    	}

      if(Auth::check()){
          $user_id = Auth::user()->id;
          $product_id = Input::get('product');
          $amount = Input::get('amount');
          $price = Input::get('price');

          $product = Product::find($product_id);
          $total = $amount * $price;
          
          $count = Cart::where('product_id', $product_id)->where('user_id' , $user_id)->count();

          if($count){
           $total = $amount * $price;
           $update =  DB::table('carts')->where('product_id', $product_id)
                      ->update(array(
                          'amount' => DB::raw('amount + 1 '),
                          'total' => DB::raw('amount * price')
                        ));
            return Redirect::to('store/viewcart')->with('message' , 'The product added on your cart');
          }


          Cart::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'amount' => $amount,
            'price' => $price,
            'total' => $total

          ]);



    return Redirect::to('store/viewcart');
  
      }else{
        return Redirect::to('users/signin');
      }
    	
    }


public function amountIncrement(){

      $user_id = Auth::user()->id;
      $product_id = Input::get('product');
      $amount = Input::get('amount');
      $price = Input::get('price');

      $product = Product::find($product_id);
      $total = $amount * $price;
       $cart = Cart::where('user_id' , Auth::user()->id)->count();
      $count = Cart::where('product_id', $product_id)->where('user_id' , $user_id)->count();

      if($count){
       $total = $amount * $price;
       $update =  DB::table('carts')->where('product_id', $product_id)
                  ->update(array(
                      'amount' => DB::raw('amount + 1 '),
                      'total' => DB::raw('amount * price')
                    ));
    
        return Redirect::to('/store/viewcart')
        ->with('cart',$cart)
        ->with('message' , 'The product added on your cart');
    
      }else{
        echo "delete";
      }


}

public function amountDecrement(){

     $user_id = Auth::user()->id;
      $product_id = Input::get('product');
      $amount = Input::get('amount');
      $price = Input::get('price');
      $product = Product::find($product_id);
      
     $total = $amount * $price;

       $cart = Cart::where('user_id' , Auth::user()->id)->count();
      $count = Cart::where('product_id', $product_id)->where('user_id' , $user_id)->count();
      // existing product in the  cart
      if($count){

       $total = $amount * $price;
       $update =  DB::table('carts')
                ->where('product_id', $product_id)
                  ->update(array(
                      'amount' => DB::raw('amount - 1 '),
                      'total' => DB::raw('amount * price')
                    ));



        return Redirect::to('/store/viewcart')->with('message' , 'The product added on your cart');
      }else{
        echo "error";
      }
}

  public function deleteCart($id){
      $delete = DB::table('carts')->where('id',$id)->delete();
        if($delete){
     return Redirect::to('/store/viewcart')->with('message' , 'The product deleted from your cart');
    
     
    }

  }
}


