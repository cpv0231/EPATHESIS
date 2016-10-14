
@extends('layout.app')

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
						Price
						<input type="text" name="price" class="form-control" ><br/>
						Subcatageroy
						<select  class="form-control input-sm" name="subcategories_id"	>
						<option selected>Select your option</option>
						@foreach($subcategories as $subcat)
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
						<br/>
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
					  	<a href="{{ 'deleteProducts/' . $data->id}}">delete</a></td>
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

