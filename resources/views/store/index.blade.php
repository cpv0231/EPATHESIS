@extends('layout.app')



@section('carousel')
  <div class="container">
  <div class="row">
    <div class="col-md-12">
    <!-- Carousel -->
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
          <div class="item active">
            <img src="images/logo/epalogo.jpg" alt="First slide">
                    <!-- Static Header -->
                    <div class="header-text hidden-xs">
                             <a href=".productsAjax" class="btn btn-primary btn-sm btn-min-blocl shopnow"><h4> Shop now</h4></a>
                    </div><!-- /header-text -->
          </div>
          <div class="item">
            <img src="images/logo/epalogo2.jpg" alt="Second slide">
            <!-- Static Header -->
                    <div class="header-text hidden-xs">
                        <div class="col-md-12 text-center">
                            
                        </div>
                    </div><!-- /header-text -->
          </div>
          <div class="item">
            <img src="images/logo/epalogo3.jpg" alt="Third slide">
            <!-- Static Header -->
                    <div class="header-text hidden-xs">
                        <div class="col-md-12 text-center">
                         
                        </div>
                    </div><!-- /header-text -->
                </div>
          </div>
      </div>
      <!-- Controls -->
      <a class="left carousel-control col-md-12" href="#carousel-example-generic" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
      </a>
      <a class="right carousel-control col-md-12" href="#carousel-example-generic" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
      </a>
    </div><!-- /carousel -->
    <div class="col-md-1">
            
      </div>
  </div>
</div>
@stop

@section('sidebar')
  <hr>
 <div class="container"> 
  <div class="row">
    <div class="col-md-11 ">
    <div id="sort">
    <select class="input-sm selectpicker " name="sort" id="sort">
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
                <input type="checkbox" name="brands[]" id="brands" value="{{$brand_id}}">{{$brand->name}}<br>
               @endforeach
            </ul>

        <h3>Price</h3>
        <hr>
            <ul>
              Price : <span id="spanOutput"></span>
                <br /><br />
                <div id="slider"></div>
                <br />
                
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
                    <a class="view" href="store/viewproduct/{{$data->id}}">
                        <div class="caption clearfix">
                                <h4 >{{$data->title}}</h4>
                                <div id="viewproductdetailed">
                                <button class="btn btn-info btn-xs " >View Product</button></div>
                        </div>
                      </a>

                 {!! HTML::image('img/products/'. $data->image) !!}

                    @if(Auth::check())
                        <div id="authchecked">
                          <form action="store/cart/" method="post">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="product" value="{{$data->id}}">
                          <input type="hidden" name="price" value="{{$data->price}}">
                          <input type="hidden" name="amount" value="1">
                          <button class="btn btn-primary pull-right"><i class="fa fa-cart-plus" aria-hidden="true"></i>Add to cart</button> 
                          </form>
                        </div>
                    @else
                        <div id="authguest">
                        <a href="users/signin" class="btn btn-primary pull-right"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</a>
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
    var urlSearch = '{{ URL::to('ajax-search') }}';
     var urlPrice = '{{ URL::to('ajax-price') }}';
     var urlBrands ='{{ URL::to('ajax-brands') }}';
     var urlProducts = '{{ URL::to('ajax-products') }}';

  </script> 
 
@stop

