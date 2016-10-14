<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Subcategory;
use App\Product;
use App\Brand;
use App\Cart;
use App\TrackProducts;
use App\Http\Requests;
use DB;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Input;
use Auth;

class AdminController extends Controller
{	

 public function __construct(){
  $this->middleware('isAdmin');
 }
      //Category , Brand , Subcategory
     public function categoryIndex(){
      $cart = Cart::where('user_id' , Auth::user()->id)->count();
      
    	  return view('admin/categories')
        ->with('category' ,Category::paginate(5))
        ->with('subcategories',Subcategory::paginate(5))
        ->with('cart',$cart)
        ->with('brand' ,Brand::paginate(5));
      
    }
     
    //store categories
     public function storeCategories(){
            $categories = new Category();
            $categories->name = Input::get('category');
    	      $categories->save();
        
    	     return redirect('admin/categories');
    }
    //edit categories
     public function editCategory(Request $request){
      $this->validate($request,[
        'name'=>'required'
      ]);
      $category = Category::find($request['postCatId']);
      $category->name = $request['name'];
      $category->update();
       return response()->json(['new_category' => $category->name] , 200);      
    }


    // update categories
    public function updateCategory(){
 
       $data = array(
                   'name' => Input::get('category')
                );
        $id = Input::get('id');
        $i = DB::table('categories')->where('id',$id)->update($data);
               if($i > 0){
                    return redirect('admin/categories');

        }return redirect('admin/categories');

   }
   //delete category
    public function deleteCat($id){
      $delete = DB::table('categories')->where('id',$id)->delete();
        if($delete){
          return redirect('admin/categories');
        }

    }

  public  function delete_post(){

    $id =  Input::get('id');
    // YOUR ACTION
    if($this->post->delete($id)){
        return array('status'=>'success');
    }
    else {
        return array('status'=>'error');
    }
}

    //store subcategory
     public function storeSubcategories(){
    	 $subcategory = new Subcategory();
    	 $subcategory->name = Input::get('subcategory');
    	 $subcategory->category_id = Input::get('category_id');
    	 $subcategory->save();
    	 return redirect('admin/categories');
    }


 

    //edit Subcategory
     public function editSubcategory($id){
          $cart = Cart::where('user_id' , Auth::user()->id)->count();
          $subcategory = DB::table('subcategories')->get();
          $category = Category::all();
          $rows = DB::table('subcategories')->where('id',$id)->first();

         return view('admin.editSubcategory')
         ->with('rows',$rows)
         ->with('cart',$cart)
         ->with('category',$category)
         ->with('subcategories',$subcategory);
        }
    
    //update subcategory
      public function updateSubcategory(){
     
       $data = array(
                'name' => Input::get('subcategory'),
                'category_id' => Input::get('category_id')
                );

        $id = Input::get('id');
        $i = DB::table('subcategories')->where('id',$id)->update($data);
               if($i > 0){
                    return redirect('admin/categories');

               }return redirect('admin/categories');

       }
      //delete subcategory
   public function deleteSub($id){
        $delete = DB::table('subcategories')->where('id',$id)->delete();
        if($delete){
            echo 'Record have been delete successfuly';
            return redirect('admin/categories');
        }

    }
   
   // BRAND

    //storebrand
     public function storeBrands(){
       $brands = new Brand();
       $brands->name = Input::get('brand');
       $brands->save();
       return redirect('admin/categories');
    }
    //edit brand
     public function editBrand($id){
      $row = DB::table('brands')->where('id',$id)->first();

     return view('admin.editBrand')
     ->with('row',$row)
     ->with('category',Category::all())
     ->with('subcategories',Subcategory::All());
     } 
    
    //update brand
     public function updateBrand(){
 
   $data = array(
            'name' => Input::get('brand')
            );
    $id = Input::get('id');
    $i = DB::table('brands')->where('id',$id)->update($data);
           if($i > 0){
                return redirect('admin/categories');

           }return redirect('admin/categories');

   }

 
    //End BRAND




     //PRODUCTS

    public function productsIndex(){
      $category = Category::all();
      $subcategory = Subcategory::all();
      $products = Product::all();
      $brands = Brand::all();
      $cart = Cart::where('user_id' , Auth::user()->id)->count();
      

      return view('admin/addProducts', compact('category'))
      ->with('subcategories',$subcategory)
      ->with('cart',$cart)
      ->with('products',$products)
      ->with('brand', $brands);
     

    }
//store products
public function storeProducts(Request $request) {
    $validator = Validator::make($request->all(), Product::$rulesUpdate);

    if ($validator->passes()) {
      $product = new Product;
      $product->subcategories_id = Input::get('subcategories_id');
      $product->brand_id = Input::get('brand_id');
      $product->title = Input::get('title');
      $product->description = Input::get('description');
      $product->price = Input::get('price');
      $product->stocks = Input::get('stocks');
      $product->save();

       $insert_id = $product->id;

      
           if($request->file('image')){
          //move file
                $img = $request->file('image');
                $img->move('img/products/',  $insert_id .'.jpg');
          
             $product->image = $insert_id . '.jpg';
             $product->save();  
         }    

    

        return Redirect::to('admin/products')
        ->with('message', 'Product Created');
    }

    return Redirect::to('admin/products')
      ->with('message', 'Something went wrong')
      ->withErrors($validator)
      ->withInput();
  }

  //showproducts
  public function showProducts($id) {
    $brands = array();
      $cart = Cart::where('user_id' , Auth::user()->id)->count();
    foreach(Brand::all() as $brand) {  
      $brands[0] = 'no brand';
      $brands[$brand->id] = $brand->name;
    }

    $subcategories = array();

    foreach(Subcategory::all() as $subcategory) {

      $subcategories[$subcategory->id] = $subcategory->name;
    }
    return View('admin.editProducts')
    ->with('products', Product::find($id))
    ->with('subcategories', $subcategories)
    ->with('brands', $brands)
    ->with('cart',$cart)
    ->with('category' , Category::all());
  }

/*
  //edit products
    public function editProducts($id) {
    $brands = array();
      $cart = Cart::where('user_id' , Auth::user()->id)->count();
    
    foreach(Brand::all() as $brand) {  
      $brands[0] = 'no brand';
      $brands[$brand->id] = $brand->name;
    }

    $subcategories = array();

    foreach(Subcategory::all() as $subcategory) {

      $subcategories[$subcategory->id] = $subcategory->name;
    }
    return View('admin.editProducts')
    ->with('products', Product::find($id))
    ->with('subcategories', $subcategories)
    ->with('brands', $brands)
     ->with('cart',$cart)
    ->with('category' , Category::all());
  }
  */


// update products
public function updateProducts(Request $request) {
    $post =$request->all();
    $validator = Validator::make($request->all(), Product::$rulesUpdate);

      
    if ($validator->passes()) {
    
       //get file name
          
           if($request->file('image')){
          //move file
                $img = $request->file('image');
                $img->move('img/products/',  Input::get('id') .'.jpg');
          }
     $data = array(
            'title' => $post['title'],
            'brand_id' => $post['brand_id'],
            'subcategories_id' => $post['subcategories_id'],
            'price' => $post['price'],
            'description' => $post['description'],
            'stocks' => $post['stocks'],
            'image' =>  Input::get('id'). '.jpg',
        ); 
    $i = DB::table('products')->where('id', $post['id'])->update($data);
           if($i > 0){
           return Redirect::to('admin/products')
        ->with('message', 'Product Updated');
           }
                    
  }

    return Redirect::to('admin/products')
      ->with('message', 'Something went wrong')
      ->withErrors($validator)
      ->withInput();
  }
//view of track productss ---SAKA NA MUNA TO ISISINGIT---
  public function TrackProducts(){
      $category = Category::all();
      $subcategory = Subcategory::all();
      $products = Product::all();
      $brands = Brand::all();
      $cart = Cart::where('user_id' , Auth::user()->id)->count();

    $trackproduct =TrackProducts::with('Products')
              ->select('product_id', DB::raw('SUM(countview) as countview'))
               ->groupBy('product_id')  
               ->orderBy('countview','desc')
                ->get();


    return view('admin/trackproduct')
    ->with('brands', $brands)
    ->with('cart',$cart)
    ->with('trackproduct', $trackproduct)
    ->with('category' , Category::all());
  }


//DITO LAHAT NAG START YUNG ADMIN DASHBOARD ---MARK
  public function adminDashboard(){
    return view('admin.dashboard.index');
  }

public function adminCharts(){
    return view('admin.dashboard.charts');
  }

  public function adminTables(){
    return view('admin.dashboard.tables');
  }


//LANDING PAGE NG PRODUCT NA MERONG ADD FUNCTIONALITY
  public function addProducts(){
    $category = Category::all();
      $subcategory = Subcategory::all();
      $products = Product::all();
      $brands = Brand::all();

    return view('admin.dashboard.addProducts')
    ->with('subcategories', subcategory::all())
    ->with('brand', Brand::all())
    ->with('products', Product::all());
  }
//END NG PRODUCT NA MERONG ADD FUNCTIONALITY


//START NG EDIT PRODUCTS    <<<<<<<<<<<<<<<<<<<<<<<-------ERROR PA! HINDI KO MAGAWA YUNG MAY KASAMANG VIEW PRODUCTS YUNG EDIT PRODUCT FORM PARA MAGKATABI SILA
    public function editProducts($id) {
    $brands = array();
    foreach(Brand::all() as $brand) {  
      $brands[0] = 'no brand';
      $brands[$brand->id] = $brand->name;
    }

     $subcategories = array();

    foreach(Subcategory::all() as $subcategory) {

      $subcategories[$subcategory->id] = $subcategory->name;
    }

    $viewproducts = Product::all();

    return View('admin.dashboard.editProducts')
    ->with('products', Product::find($id))
    ->with('subcategories', $subcategory)
    ->with('brands', $brands)
    ->with('viewproducts', $viewproducts)
    ->with('category' , Category::all());

  }
//END NG EDIT PRODUCTS


//CATEGORIES
  public function categories(){
        return view('admin/dashboard/categories')
        ->with('category' ,Category::paginate(5))
        ->with('subcategories',Subcategory::paginate(5))
        ->with('brand' ,Brand::paginate(5));
      
    }
     
    //store categories
     public function addCategories(){
            $categories = new Category();
            $categories->name = Input::get('category');
            $categories->save();
        
           return redirect('admin/dashboard/categories');
    }
    //edit categories
     public function editCategories(Request $request){
      $category = Category::find($request['postId']);
      $category->name = $request['category'];
      $category->update();
       return response()->json(['message' => 'Updated Category'] , 200);      
    }


    // update categories
    public function updateCategories(){
 
       $data = array(
                   'name' => Input::get('category')
                );
        $id = Input::get('id');
        $i = DB::table('categories')->where('id',$id)->update($data);
               if($i > 0){
                    return redirect('admin/dashboard/categories');

        }return redirect('admin/dashboard/categories');

   }
   //delete category
    public function deleteCategories($id){
      $delete = DB::table('categories')->where('id',$id)->delete();
        if($delete){
          return redirect('admin/dashboard/categories');
        }

    }

    //store subcategory
     public function addSubcategories(){
       $subcategory = new Subcategory();
       $subcategory->name = Input::get('subcategory');
       $subcategory->category_id = Input::get('category_id');
       $subcategory->save();
       return redirect('admin/dashboard/categories');
    }


 

    //edit Subcategory
     public function editSubcategories($id){
          $subcategory = DB::table('subcategories')->get();
          $category = Category::all();
          $rows = DB::table('subcategories')->where('id',$id)->first();

         return view('admin.dashboard.editSubcategories')
         ->with('rows',$rows)
         ->with('category',$category)
         ->with('subcategories',$subcategory);
        }
    
    //update subcategory
      public function updateSubcategories(){
     
       $data = array(
                'name' => Input::get('subcategory'),
                'category_id' => Input::get('category_id')
                );

        $id = Input::get('id');
        $i = DB::table('subcategories')->where('id',$id)->update($data);
               if($i > 0){
                    return redirect('admin/dashboard/categories');

               }return redirect('admin/dashboard/categories');

       }
      //delete subcategory
   public function deleteSubcategories($id){
        $delete = DB::table('subcategories')->where('id',$id)->delete();
        if($delete){
            echo 'Record have been delete successfuly';
            return redirect('admin/dashboard/categories');
        }

    }

    // BRAND

    //storebrand
     public function addBrands(){
       $brands = new Brand();
       $brands->name = Input::get('brand');
       $brands->save();
       return redirect('admin/dashboard/categories');
    }

    //edit brand
     public function editBrands($id){
      $row = DB::table('brands')->where('id',$id)->first();

     return view('admin.dashboard.editBrands')
     ->with('row',$row)
     ->with('category',Category::all())
     ->with('subcategories',Subcategory::All());
     } 
    
    //update brand
     public function updateBrands(){
 
   $data = array(
            'name' => Input::get('brand')
            );
    $id = Input::get('id');
    $i = DB::table('brands')->where('id',$id)->update($data);
           if($i > 0){
                return redirect('admin/dashboard/categories');

           }return redirect('admin/dashboard/categories');

   }

    //End BRAND

}


