@extends('layout.app')

@section('sidebar')

<hr>  <h2 align="center">Search result for <span>"{{$keyword}}"</span></h2>
        <div class="col-md-2" id="sidebar">
               <h3>Categories</h3>
                    <ul style="list-style: none;">
                    @foreach($category as $navcat)
                        <li class="dropdown"  value="{{$navcat->id}}">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $navcat -> name}}<strong class="caret"></strong>
                             </a>
                            <ul class="dropdown-menu">
                                  @foreach($navcat -> subcategories as $subcat)
                                    <li><a href="{{URL::to('store/subcategory/'.$subcat->id) }}" value="">{{ $subcat->name }}</a></li>
                                 @endforeach
                           </ul>
                            
                      </li>
                   @endforeach          
            </ul>
        <form action="{{ URL::current() }}" method="GET"  >
              <h3>Brands</h3>
            <ul>
              @foreach($brands as $brand)
              <?php
              $brands = Input::has('brands') ? Input::get('brands'): [];
               $brand_id = $brand->id;
              ?>        
            <input type="checkbox" name="brands[]" value="{{$brand_id}}"{{ in_array( $brand_id  , $brands) ? 'checked': ''  }} >{{$brand->name}}<br>
                  

                @endforeach
            </ul>

            <h3>Price</h3>
            <ul>
              Price : <span id="spanOutput"></span>
                <br /><br />
                <div id="slider"></div>
                <br />
                <input id="min_price" value="{{ Input::get('min_price') }}" name="min_price" type="hidden" />
                <br /><br />
                <input id="max_price" value="{{ Input::get('max') }}" name="max_price" type="hidden" />

            </ul>
              <input type="submit" class="pull-right"/>
               
        </form>
        </div>
@stop

@section('content')
   

    <div class="col-md-9">
            <div class="row">

        @foreach ($products as $data)

                <div class="col-md-3">
                    <div class="thumbnail">
                        <div class="caption clearfix">

                                <h4>Thumbnail Headline</h4>
                                <p>{{$data->description}}</p>
                                <button class="btn btn-info btn-xs">View Product</button>
                         
                         </div>

                      {{ HTML::image('img/products/'. $data->image) }}
                        <button class="btn btn-primary pull-right">Add to cart</button>
                        <h4>{{$data->title}}</h4>
                        <p>₱{{$data->price}}</p>
                 
                      </div>
                </div>
        @endforeach    
            </div>
    </div>


  
@stop
