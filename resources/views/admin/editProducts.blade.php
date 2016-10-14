
@extends('layout.app')

@section('content')
	<br>
	<br>
<div class="jumborton">
	<h1>Here you can Add categories, subcategories, brand</h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
	<div class="row"> 
		<div class="col-md-8">
			<div class="row">
					<div class="panel panel-default">
                		<div class="panel-heading">Edit Products</div>
		@if($errors->has())
		<div id="form-errors">
			<p>The following errors have occurred:</p>

			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div><!-- end form-errors -->
		@endif
		  	 <?php 
				$imagepath = '';
				$imagepath=url('img/products/'.$products -> image);

			?>
	{{ Form::model($products,['method' =>'patch' , 'action'=>'AdminController@updateProducts' , $products->id , 'files'=>true ])}}		
						 <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
						 <br/>
						 <input type="hidden" name="id" value="<?=  $products->id ?>" class="form-control"> <br>
						
						<img src="{{$imagepath}}" width="50%" height="auto">
						<input type="file" name="image" class="form-control" ><br/>	
						<br/>
						
						Product Name
						<input type="text" name="title" value="<?=  $products->title ?>" class="form-control" ><br/>
						Price
						<input type="text" name="price" value="<?=  $products->price ?>" class="form-control" ><br/>
						<h3>Subcategories</h3>
						{{ Form::select('subcategories_id', $subcategories ) }}
						<br>
						Brand
						<h3>Brand</h3>
						{{ Form::select('brand_id', $brands ) }}

						<br>
					
						Description
						<textarea  rows="5" name="description" class="form-control"> 
						<?=  $products->description ?>	
						</textarea> <br/>
						Stocks 
						<input type="text" name="stocks" class="form-control" value="<?=  $products->stocks ?>">
						<br>
						<input type="submit" value="Update Record" class="btn btn-primary pull-right">
				{{Form::close()}}
				<br>

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

