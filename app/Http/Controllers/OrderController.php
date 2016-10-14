<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input,Auth;
use App\Cart;
use App\Category;
use App\Order;
use Redirect;
use App\Http\Requests;

class OrderController extends Controller
{
    public function getIndex(){

    	$user_id = Auth::user()->id;
    	$orders = Order::with('orderItems')->where('user_id',$user_id)->get();
    	$cart = Cart::where('user_id' , Auth::user()->id)->count();
	  
  return view('store/vieworders')
	 	->with('cart',$cart)
	 	->with('orders',$orders)
	 	->with('category' , Category::all());
    }

    public function postOrder(){

    	$address = Input::get('address');
    	$user_id = Auth::user()->id; 
    	
    	$cart_products = Cart::with('Products')->where('user_id', $user_id)->get();
    	$cart_total =Cart::with('Products')->where('user_id',$user_id)->sum('total');

    	$order = Order::create([
    		'user_id' => $user_id,
    		'address' => $address,
    		'total' => $cart_total
    	]);
	

    //	$order = Order::find(1);

    	foreach ($cart_products as $cart_product) {
    		$order->orderItems()->attach($cart_product->product_id,[
    			'amount' => $cart_product->amount,
    			'price' => $cart_product->price,
    			'total' => $cart_product->amount * $cart_product->price

    		]);
    	}

    	Cart::where('user_id' ,$user_id)->delete();


    	return Redirect::to('store/viewcart')->with('message','Your order processed successfully');
    }

}
