@extends('layout.app')
@section('content')
<br>
<h2 align="center" >{{Auth::user()->firstname}}'s shopping cart </h2>

<div class="table-responsive">
     <table class="table table-hover">
    <thead>
      <tr>
        <th>Product Name</th>
         <th>quantity</th>
        <th>Price</th>
        <th>Subtotal</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
       @foreach($products_cart as $cart_item)
      <?php 
        $imagepath = '';
        $imagepath=url('img/products/'. $cart_item->Products->image);
      ?>
      <tr>
        <td><img src="{{$imagepath}}" width="70px" height="auto">{{$cart_item->Products->title}}</td>
        
        <td> 
        @if($cart_item->amount < $cart_item->Products->stocks)
         <form action="viewcartplus/" style="float: left;" method="post">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="product" value="{{$cart_item->Products->id}}">
                          <input type="hidden" name="price" value="{{$cart_item->Products->price}}">
                          <input type="hidden" name="amount" value="{{$cart_item->amount}}">
                        <button style="margin-right: 5px;"> + </button> 
         </form>
          <input style="float: left;" class="cart_quantity_input" type="text" min="0" name="quantity" value="{{$cart_item->amount}}" autocomplete="off" size="1"/>
        @else
         <button style="margin-right: 5px; float: left;" disabled="disabled"> + </button> 


          <input style="float: left;" class="cart_quantity_input" type="text" min="0" name="quantity" value="{{$cart_item->Products->stocks}}" autocomplete="off" size="1"/>
       

        @endif
          @if( $cart_item->amount > 1 )
          <form action="viewcartminus/" style="float: left;" method="post" ">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="product" value="{{$cart_item->Products->id}}">
              <input type="hidden" name="price" value="{{$cart_item->Products->price}}">
              <input type="hidden" name="amount" value="1">
             <button  id="minus" style="margin-left: 5px;">-</button> 
          </form>
          

          @else
             <button  disabled="disabled" style="margin-left: 5px;">-</button> 

          @endif
           
            
                   

        </td>


        <td>₱{{$cart_item->Products->price}}</td>
        <td>₱{{$cart_item->total}}</td>
        <td>
  
            <a href="cart/delete/{{$cart_item->id }} " class="btn btn-danger"><i class="glyphicon glyphicon-trash"> </i> Delete</a>
         </td>
      </tr>
      @endforeach
      <tr>
        <td></td>
        <td></td>
        <td><br><br><h2>Total</h2></td>
        <td><br><br><h3>₱{{$cart_total}}</h3></td>
        <td></td>
      </tr>
        </tbody>
  </table>
  
   </div> 

  <div id="shipping">
  
  <h2> Shipping address </h2>  
   <form action="order" method="post"> 
    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
    <div class="form-group">
      <textarea name="address" cols="50" clas="form-control"> </textarea>
      </div>
      <button class="btn btn-info">Place order</button>
    </form>
   </div>

@stop

