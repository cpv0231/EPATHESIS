<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;
use App\Product;
use App\Brand;
use App\TrackProducts;
use App\Subcategory;
use View;
use Auth;
use Redirect;
use Validator;
use Response;
use App\Cart;
use DB;
use Illuminate\Support\Facades\Input;
class StoreController extends Controller
{
  	public function index()
    {
        $products = Product::where(function($query){
                
                $min_price = Input::has('min_price') ? Input::get('min_price'):null ;
                $max_price = Input::has('max_price') ? Input::get('max_price'):null ;
                $brands = Input::has('brands') ? Input::get('brands'):[];

                if(isset($min_price) && isset($max_price)){
                    
                    if(isset($brands)){
                        foreach ($brands as  $brand) {
                        $query->orWhere('price', '>=', $min_price)
                        ->where('price', '<=' , $max_price)
                        ->where('brand_id', '=' , $brand);                      
                            
                        }
                    }
                

            $query->where('price', '>=' , $min_price)
            ->where('price', '<=' , $max_price);

            }
            })->paginate(12);

      //  $product = Product::all()->orderBy('price','desc')->get();
        $category = Category::all();
        $cart =0;
        if(Auth::check()){
         $user = Auth::user()->id;  
         $cart = Cart::where('user_id' , $user)->count();
    
        }

        return view('store/index', compact('category'))
        ->with('products', $products)
        ->with('cart',$cart)
        ->with('brands', Brand::all());
    }





    public function viewproduct($id){
      $cart =0;
      $products = Product::find($id);
       $product_id = $id;
        if(Auth::check()){
         $user_id = Auth::user()->id;  
         $cart = Cart::where('user_id' , $user_id)->count();
        


          $count = TrackProducts::where('product_id', $product_id)->where('user_id' , $user_id)->count();

           if($count){
            $update =  DB::table('track_products')->where('user_id', $user_id)->where('product_id', $product_id)
                      ->update(array(
                          'countview' => DB::raw('countview + 1 ')
                        ));
              return view('store/viewproduct')
                ->with('products',$products)
                ->with('cart',$cart)
                ->with('category', Category::all())
                ->with('brands', Brand::all());
           
          }

         TrackProducts::create([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'countview' => '1'

          ]); 
       }else{

        $count = TrackProducts::where('product_id', $product_id)->where('user_id' , '0')->count();

           if($count){
            $update =  DB::table('track_products')->where('user_id', '0')->where('product_id', $product_id)
                      ->update(array(
                          'countview' => DB::raw('countview + 1 ')
                        ));
              return view('store/viewproduct')
                ->with('products',$products)
                ->with('cart',$cart)
                ->with('category', Category::all())
                ->with('brands', Brand::all());
           
          }

         TrackProducts::create([
                    'user_id' => '0',
                    'product_id' => $product_id,
                    'countview' => '1'

          ]); 


       }

    
         

       return view('store/viewproduct')
        ->with('products',$products)
        ->with('cart',$cart)
        ->with('category', Category::all())
        ->with('brands', Brand::all());
    }
    public function addtocart(){
   


        $user_id = Auth::user()->id;
        $product_id = Input::get('product');
        $amount = Input::get('qty');
        $price = Input::get('price');
        $product = Product::find($product_id);
        $total = $amount * $price;
        
        $count = Cart::where('product_id', $product_id)->where('user_id' , $user_id)->count();

        if($count){
            if($amount>1){
                  $total = $amount * $price;
                   $update =  DB::table('carts')->where('product_id', $product_id)
                            ->update(array(
                                'amount' => DB::raw($amount),
                                'total' => DB::raw('amount * price')
                              ));
                  return Redirect::to('store/viewcart')->with('message' , 'The product added on your cart');
            }else{
                 $total = $amount * $price;
                   $update =  DB::table('carts')->where('product_id', $product_id)
                            ->update(array(
                                'amount' => DB::raw('amount +1'),
                                'total' => DB::raw('amount * price')
                              ));
                  return Redirect::to('store/viewcart')->with('message' , 'The product added on your cart');

            }
                 
        }else{
          if($amount==0){
                $price = Input::get('price');
                $amount = 1;
                $total = $amount * $price;
                  Cart::create([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'amount' => 1,
                    'price' => $price,
                    'total' => $total
                      ]);

          }else{  
                 $total = $amount * $price;
                  Cart::create([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'amount' => $amount,
                    'price' => $price,
                    'total' => $total
                  ]);



          }
        
        

        }

        
    return Redirect::to('store/viewcart');

    }

    public function getSubcategory($cat_id){
       if(Auth::check()){
         $cart = Cart::where('user_id' , Auth::user()->id)->count(); 
      }
      else{
        $cart = 0;
      }
      $product= Product::where('subcategories_id', '=', $cat_id)->get();
   
    return view('store.subcategory')
			->with('products', $product)
			->with('category' , Category::all())
            ->with('cart',$cart)
			->with('subcategories', Subcategory::find($cat_id))->with('brands', Brand::all());	
    }

    public function getSearch(){
    $keyword = Input::get('keyword');
     $cart =0;
        if(Auth::check()){
         $user = Auth::user()->id;  
         $cart = Cart::where('user_id' , $user)->count();
    
        }

    $products = DB::table('products')
            ->where('title', 'LIKE', '%'.$keyword.'%')
            ->orWhere('brand_id', 'LIKE', '%'.$keyword.'%')->get();

          
		return View('store.search')
			->with('products', $products)
            ->with('cart',$cart)
         	->with('category' , Category::all())
			->with('keyword', $keyword)->with('brands', Brand::all());


    }


    public function Ajaxsearch(Request $request){
      if($request->ajax()){
        $output='';
         $search = Product::where('title', 'LIKE', 
        '%' .$request->keyword. '%' )->take(12)->get();

       
               foreach ($search as $keysearch) {
               $output .= '
                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-8 ">
                <div class="thumbnail">
                   <a class="view" href="store/viewproduct/'.$keysearch->id.'">
                      <div class="caption clearfix">
                         <h4 >'.$keysearch->title .'</h4>
                              <div id="viewproductdetailed">
                                   <button class="btn btn-info btn-xs modalproduct" >View Product</button>
                              </div>
                          </div>
                      </a>

                      <img src="img/products/'.$keysearch->image.'">
                          <form action="store/cart/" method="post">
                          <input type="hidden" name="_token" value="'. csrf_token() .'">
                          <input type="hidden" name="product" value="'.$keysearch->id .'">
                          <input type="hidden" name="price" value="'.$keysearch->price.'">
                          <input type="hidden" name="amount" value="1">
                          <button class="btn btn-primary pull-right"><i class="fa fa-cart-plus" aria-hidden="true"></i>Add to cart</button> 
                          </form>
                      <h4>'.$keysearch->title .'</h4>
                      <p>₱'.$keysearch->price.'</p>
                     </div>
                </div>
              </div>

                ';

            
            }


         return Response($output);
      }
    }


    public function Ajaxprice(Request $request){
      
      if($request->ajax()){
        $output='';


            $products = Product::where(function($query){
                
                $min_price = Input::has('min_price') ? Input::get('min_price'):null ;
                $max_price = Input::has('max_price') ? Input::get('max_price'):null ;
                $brands = Input::has('brands') ? Input::get('brands'):[];

                

                if(isset($min_price) && isset($max_price)){
                    $query->where('price', '>=' , $min_price)
                    ->where('price', '<=' , $max_price);
                }
            })->take(12)->get();

           //dd($products);

       
               foreach ($products as $keysearch) {
               $output .= '
                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-8 ">
                <div class="thumbnail">
                   <a class="view" href="store/viewproduct/'.$keysearch->id.'">
                      <div class="caption clearfix">
                         <h4 >'.$keysearch->title .'</h4>
                              <div id="viewproductdetailed">
                                   <button class="btn btn-info btn-xs modalproduct" >View Product</button>
                              </div>
                          </div>
                      </a>

                      <img src="img/products/'.$keysearch->image.'">
                          <form action="store/cart/" method="post">
                          <input type="hidden" name="_token" value="'. csrf_token() .'">
                          <input type="hidden" name="product" value="'.$keysearch->id .'">
                          <input type="hidden" name="price" value="'.$keysearch->price.'">
                          <input type="hidden" name="amount" value="1">
                          <button class="btn btn-primary pull-right"><i class="fa fa-cart-plus" aria-hidden="true"></i>Add to cart</button> 
                          </form>
                      <h4>'.$keysearch->title .'</h4>
                      <p>₱'.$keysearch->price.'</p>
                     </div>
                </div>
              </div>

                ';

            
            }


         return Response($output);
      }
    }

  public function Ajaxbrands(Request $request){


      
       if($request->ajax()){
        $output='';


            $products = Product::where(function($query){
                
                $min_price = Input::has('min_price') ? Input::get('min_price'):null ;
                $max_price = Input::has('max_price') ? Input::get('max_price'):null ;
                $brands = Input::has('brands') ? Input::get('brands'):[];



          if(isset($brands)){

                if(isset($min_price) && isset($max_price)){
                    
                      foreach ($brands as  $brand) {
                        $query->orWhere('price', '>=', $min_price)
                        ->where('price', '<=' , $max_price)
                        ->where('brand_id', '=' , $brand); 
                        }  
                 }else{
                    if(isset($brands))
                        foreach ($brands as $brand) {
                       $query->orWhere('brand_id', '=' ,$brand); 
                 
                    }else{
                       $products = Product::all()->get();
                    } 
                   
                 }
                
               }           

            })->get();


         //dd($products);         

           foreach ( $products as $keysearch) {
               $output .= '
                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-8 ">
                <div class="thumbnail">
                   <a class="view" href="store/viewproduct/'.$keysearch->id.'">
                      <div class="caption clearfix">
                         <h4 >'.$keysearch->title .'</h4>
                              <div id="viewproductdetailed">
                                   <button class="btn btn-info btn-xs modalproduct" >View Product</button>
                              </div>
                          </div>
                      </a>

                      <img src="img/products/'.$keysearch->image.'">
                          <form action="store/cart/" method="post">
                          <input type="hidden" name="_token" value="'. csrf_token() .'">
                          <input type="hidden" name="product" value="'.$keysearch->id .'">
                          <input type="hidden" name="price" value="'.$keysearch->price.'">
                          <input type="hidden" name="amount" value="1">
                          <button class="btn btn-primary pull-right"><i class="fa fa-cart-plus" aria-hidden="true"></i>Add to cart</button> 
                          </form>
                      <h4>'.$keysearch->title .'</h4>
                      <p>₱'.$keysearch->price.'</p>
                     </div>
                </div>
              </div>

                ';

            
            }


         return Response($output);
      }


  }

}

