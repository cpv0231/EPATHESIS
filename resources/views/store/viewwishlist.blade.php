@extends('layout.app')
@section('content')
<br>
<h2 align="center" >{{Auth::user()->firstname}}'s wishlist</h2>

<div class="table-responsive">
     <table class="table table-hover">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Add to cart</th>
      </tr>
    </thead>
    <tbody>
       @foreach($wishlist_products as $wishlistitem)
      <?php 
        $imagepath = '';
        $imagepath=url('img/products/'. $wishlistitem->Products->image);
      ?>
      <tr>
        <td><img src="{{$imagepath}}" width="70px" height="auto">{{$wishlistitem->Products->title}}</td>
        <td>₱{{$wishlistitem->Products->price}}</td>
        <td>
        <form action="wishlistcart/" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="product" value="{{$wishlistitem->Products->id}}">
            <input type="hidden" name="price" value="{{$wishlistitem->Products->price}}">
            <input type="hidden" name="amount" value="1">
            <button class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i>Add to cart</button> 
        </form>
       

     
       <a href="wishlist/delete/{{$wishlistitem->id }} " class="btn btn-danger"><i class="glyphicon glyphicon-trash"> </i> Delete</a>
       </td>
      </tr>
      @endforeach

        </tbody>
  </table>
  
   </div> 
<br><br><br>
  
@stop

