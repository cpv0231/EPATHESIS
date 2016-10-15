
@extends('layout.dashboard')

@section('content')
	<br>
	<br>
<div class="jumborton">
	<h1>Here you can Add categories, subcategories, brand</h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			@if($errors->has())
				<div id="form-errors" class="alert alert-danger">
					<p>The following errors have occurred:</p>

					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div><!-- end form-errors -->
				@endif
		</div>

	</div>
	<div class="row">
		<div class="col-md-12">
	<div class="row"> 
		<div class="col-md-3" id="products-form" >
			<div class="row">
					<div class="panel panel-default">
                		<div class="panel-heading">Add Products</div>
		
	
				<form  action="storeProducts" method="POST" enctype="multipart/form-data">
						 <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
						 <br/>
						Product Name
						<input type="text" name="title" class="form-control" ><br/>
						SKU(stock-keeping unit)
						<input type="text" name="sku" class="form-control" ><br/>
						Price
						<input type="text" name="price" class="form-control" ><br/>
						Subcatageroy
						<select  class="form-control input-sm" name="subcategories_id"	>
						<option selected>Select your option</option>
						<@foreach($subcategories as $subcat)
								<option   value="{{ $subcat->id }}">
									{{ $subcat -> name}}
								</option>
						@endforeach
						</select>
						<br>
						Brand
						<select  class="form-control input-sm" name="brand_id"	>
						<option selected>Select your brand</option>
						@foreach($brand as $brands)
								<option   value="{{ $brands->id }}">
									{{ $brands -> name}}
								</option>
						@endforeach
						</select>		

						Description
						<textarea  rows="5" name="description" class="form-control" > 

						</textarea> <br/>
						Stocks 
						<input type="text" name="stocks" class="form-control">
						Image
						<input type="file" name="image" class="form-control" ><br/>	

						<input type="checkbox" name="advancetab"  >Show Advanced Input<br/>	
						<br/>
						Meta Title (optional)
						<input type="text" name="metatitle" class="form-control" ><br/>

						Meta Keyword (optional)
						<input type="text" name="metakeyword" class="form-control" ><br/>

						Meta Description (optional)
						<input type="text" name="metadescription" class="form-control" ><br/>

						<input type="checkbox" name="disableBuy"  >Disable Buy Button<br/>
						<input type="checkbox" name="disableWishlist"  >Disable Wishlist Button<br/><br/>

						Special/Sale Options<br/><br/>
						Old Price
						<input type="text" name="oldprice" class="form-control">
						<br/>

						Special Price
						<input type="text" name="specialprice" class="form-control">
						<br/>

						Special/Sale Event Start Date
						<input type="date" name="specialstartdate" class="form-control">
						<br/>

						Special/Sale Event End Date
						<input type="date" name="specialenddate" class="form-control"><br/>
						<br/>

						Latest Product Options<br/><br/>

						<input type="checkbox" name="markasnew"  >Mark As New<br/><br/>

						Mark as New Start Date
						<input type="date" name="markasnewstartdate" class="form-control"><br/>

						Mark as New End Date
						<input type="date" name="markasnewenddate" class="form-control"><br/>

						<input type="checkbox" name="preorderonly"  >Available in Pre-order Only<br/><br/>

						<input type="checkbox" name="limitedtimeonly"  >Limited Time Only<br/><br/>

						Limited Time Start Date
						<input type="date" name="limitedstartdate" class="form-control"><br/>

						Limited Time End Date
						<input type="date" name="limitedenddate" class="form-control"><br/>

						<input type="checkbox" name="displaystock"  >Display Stock Availability<br/><br/>

						Minimum Stock Quantity
						<input type="text" name="minstock" class="form-control"><br/>

						<input type="submit" value="Save Record" class="btn btn-primary">
				</form>
				<br>

				</div>
			</div>
		</div>
<div id="viewproducts">
		<div class="col-md-8" >
			<div class="row">
					<div class="panel panel-default">
                		<div class="panel-heading">View Products</div>
					
							
						<table class="table table-responsive table-hover"  >
							<thead>	
								<th>Product ID</th>
								<th>Product Name</th>
								<th>Product Description</th>
								<th>Product subcatagory</th>
								<th>Product brand</th>
								<th>Product Price</th>
								<th>Product Image</th>
								<th>Action</th>
							</thead>	
								<tbody>	
								 @foreach($products as $data)
										  <tr>	
								  	 <?php 
					        		$imagepath = '';
					        		$imagepath=url('img/products/'.$data -> image);

					      			?>
								 	<td>{{$data -> id}}</td>
								 	<td>{{$data -> title}}</td>
								 	<td>{{$data -> description}}</td>
								  	<td>{{$data ->subcategories_id}}</td>
								  	<td>{{$data ->brand_id}}</td>	
                                 	<td>{{$data -> price}}</td>
								 	<td><img src="{{$imagepath}}" width="50px" height="50px"></td>
								 	<td> 	
					  	<a href="{{ 'editProducts/'. $data->id}}">Edit  </a>
					  	<a href="{{ 'showProducts/'. $data->id}}">Show  </a>
					  	<a href="{{ 'deleteProducts/' . $data->id}}">Delete</a></td>
								   </tr>	
								 @endforeach
								 <br/><br/>
								
								</tbody>
						</table>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 </div>
</div>		
<hr>




 @stop

