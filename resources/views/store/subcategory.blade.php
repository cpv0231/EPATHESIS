@extends('layout.app')

@section('sidebar')
 <hr>
  <h2 align="center">{{ $subcategories->name}}</h2>   
  <input type="hidden" name="id" value="{{$subcategories->id}}">
  <hr>
 <div class="container"> 
  <div class="row">
    <div class="col-md-11 ">
    <div id="sortSub">
    <select class="input-sm selectpicker " name="sortSub" id="sortSub">
              <option value="" disabled selected> Sort by:</option>
                  <option value="DESC">
                      Price: High to Low
                  </option>
                  <option value="ASC">
                      Price Low to High  
                  </option>
                
        </select>
        </div>  
      </div>
   </div>
</div>
        <div class="col-md-2" id="sidebar" >
         <h3>Categories</h3>
         <hr>
                    <ul class="main-nav-ul">
                          @foreach($category as $navcat)
                              <li class="has-sub" value="{{$navcat->id}}">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $navcat -> name}}<strong class="caret"></strong>
                                   </a>
                                  <ul>
                                        @foreach($navcat -> subcategories as $subcat)
                                          <li><a href="{{URL::to('store/subcategory/'.$subcat->id) }}" value="">{{ $subcat->name }}</a></li>
                                       @endforeach
                                 </ul>
                                  
                            </li>
                         @endforeach          
                    </ul>

        <h3>Brands</h3>
        <hr>
          <form action="{{ URL::current() }}" method="GET"  >
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
        <hr>
            <ul>
              Price : <span id="spanOutput"></span>
                <br /><br />
                <div id="slider"></div>
                <br />
                <input type="submit" class="pull-right"/>
              
                <input id="min_price" value="{{ Input::get('min_price') }}" name="min_price" type="hidden" />
                <br /><br />
                <input id="max_price" value="{{ Input::get('max') }}" name="max_price" type="hidden" />

            </ul>
               
        </form>
        </div>

@stop

@section('content')

    <div class="col-md-9" >
            <div class="row">
            <br>
            <br>

    <div class="productsAjax">
        @foreach ($products as $data)

                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-8 ">
                    <div class="thumbnail">
                    <a class="view" href="{{URL::to('store/viewproduct/'. $data->id) }}">
                        <div class="caption clearfix">
                                <h4 >{{$data->title}}</h4>
                                <p >{{$data->description}}</p>
                                <div id="viewproductdetailed">
                                <button class="btn btn-info btn-xs modalproduct" >View Product</button></div>
                        </div>
                      </a>

                 <img src=" {!!URL::to('img/products/'. $data->image) !!} ">

                    @if(Auth::check())
                        <div id="authchecked">
                          <form action="{{URL::to('store/cart/')}}" method="post">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="product" value="{{$data->id}}">
                          <input type="hidden" name="price" value="{{$data->price}}">
                          <input type="hidden" name="amount" value="1">
                          <button class="btn btn-primary pull-right"><i class="fa fa-cart-plus" aria-hidden="true"></i>Add to cart</button> 
                          </form>
                        </div>
                    @else
                        <div id="authguest">
                        <a href=" {{URL::to('users/signin')}} " class="btn btn-primary pull-right"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</a>
                        </div>
                    @endif
                
                     <h4>{{$data->title}}</h4>
                     <p>₱{{$data->price}}
                    </p>
                     </div>
                </div>
        @endforeach   

        </div>
     
           
    </div>


    <!-- Modal category -->
            <div class="modal fade" id="modalproduct" role="dialog">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Category</h4>
                  </div>
                  <div class="modal-body">
                    <h2>hello</h2>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary" id="modalsave-category" >Save changes</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

  <script type="text/javascript">
   var token = '{{Session::token()}}';
    var url = '{{ URL::to('ajax-search') }}';
    var catId = '{{$subcategories->id}}'; 
  </script> 
  
@stop

