

@extends('layout.app')



@section('content')
<div class="container">
 
<br>
<h2 > Orders </h2>

  @foreach($orders as $order)
    <a href="#">Order # {{$order->id}} - {{Auth::user()->firstname}}
    -
    {{$order->created_at}}
    </a>
 <div class="table-responsive">
     <table class="table table-hover">
    <thead>
      <tr>
        <th>Product Name</th>
         <th>quantity</th>
        <th>Price</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
    
      @foreach($order->orderItems as $order_item)

      <tr>
      <td> {{$order_item->title}} </td>
      <td>  {{$order_item->pivot->amount}} </td>
      <td> {{$order_item->pivot->price}} </td>
      <td> {{$order_item->pivot->total}}</td>
      </tr>
      @endforeach


      <tr>
        <td></td>
        <td></td>
        <td><strong> Total</strong></td>
        <td><strong>{{$order->total}}</strong></td>
        <td></td>
      </tr>

  </tbody>
  </table>
    </div>

    @endforeach

@stop

