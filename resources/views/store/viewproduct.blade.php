@extends('layout.app')
@section('sidebar')
        <div class="col-md-1" id="sidebar">
            
        </div>
@stop

@section('content')
   


<br>   
<div class="container" id="product-section">
  <div class="row">
   <div class="col-md-6">
    <div class="productimg">
      {{ HTML::image('img/products/'. $products->image) }}
     </div>        
   </div>

   <div class="col-md-4">
    <div class="row">
        <br>
        <div class="col-md-7 bottom-rule">
          <h2 class="product-title">{{$products->title}}</h2>
        </div>
        <div class="col-md-5 bottom-rule" id="addwishlist">
          <br>
             <form action="{{URL::to('/store/addwishlist')}}" method="post">
              <p> 
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="product" value="{{$products->id}}">
              <button class="btn btn-info" > <i class="glyphicon glyphicon-heart"></i> Add to wishlist
             </button>
              </p> 
              </form>

        </div>

          <div class="col-md-12 bottom-rule">
          <h4>Product Description: </h4>
          <h3 class="product-title">{{$products->description}}</h3>

          <hr>
          <h4>Stocks: {{$products->stocks}} </h4>
        </div>
           @if(Auth::check())
         <form action="addcart" method="post">
            
             
             <div class="col-md-3 product-qty">
                <h3>quantity:</h3>
                <input type="number" name="qty" min="1" max="{{ $products->stocks}}" placeholder="1" ">
             </div>
              <div class="row">
                     <div class="col-md-3 bottom-rule">

                        <h3 class="product-price">₱{{$products->price}}</h3>
                    </div>

              </div>
            <div class="col-md-4 cart">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="product" value="{{$products->id}}">
                  <input type="hidden" name="price" value="{{$products->price}}">
                   <button class="btn btn-primary btn-brand pull-right"><i class="fa fa-cart-plus" aria-hidden="true"></i>Add to cart</button> 
            </form>

            @else

                     <div class="col-md-3 product-qty">
                        <h3>quantity:</h3>
                        <input type="number" name="qty" min="1" placeholder="1">
                     </div>
                      <div class="row">
                             <div class="col-md-3 bottom-rule">
                                <h3 class="product-price">₱{{$products->price}}</h3>
                        
                       <a href="{{ URL::to('users/signin') }}" class="btn btn-primary pull-right"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</a>
                        </div>

            @endif
    
</div><!-- end row -->
 
 </div><!-- end container -->
            
  </div>
  
 
@stop

