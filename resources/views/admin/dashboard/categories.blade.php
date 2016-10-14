@extends('layout.dashboard')


@section('content')
	<br>
	<h1>Here you can Add categories, subcategories, brand</h1>
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
	

	<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4">
					<div id="categories-form"  class="panel panel-default">
                <div class="panel-heading" > Category</div>
					<form action="addCategories" method="POST">
							<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
							<br/>
							Category Name
							<input type="text" name="category" class="form-control"><br/>
							<input type="submit" value="Save Category" class="btn btn-primary pull-right">
					</form>
					<hr>
			
		 					<table class="table table-responsive table-hover"  width="100px" >
					        <thead> 
					            <th>Category Name</th>
					            <th>Action</th>
					        </thead> 
					         @foreach($category as $categories)   
					        <tbody class="category" data-postid="{{$categories->id}}"> 
					            
					              <tr>
					                <td ><p> {{  $categories -> name }} </p></td>
					                  <td>    
									    <a href="#" class="editCat"> Edit  </a>
									   	<a href="{{ 'deleteCategories/' . $categories->id}}">Delete</a>
									  </td>
								   </tr>    
					             @endforeach
					            
					            </tbody>
					    </table>
                	  {{ $category->links() }}
      
                	</div>
            	
            	</div>	





				<div class="col-md-4">
					<div class="panel panel-default">
                <div class="panel-heading"> Subcategory</div>
					<form id="categories-form" action="addSubcategories" method="POST">
							<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
							<br/>
							Category
								<select class="form-control input-sm" name="category_id" >
								<option value="" disabled selected>Select your option</option>
								@foreach($category as $categories)
								<option value="{{ $categories->id }}">
									{{ $categories -> name}}
								</option>
								@endforeach		
								</select>


							Subcategory
							<input type="text" name="subcategory" class="form-control"><br/>
							<input type="submit" value="Save Category" class="btn btn-primary  pull-right">
					</form>
					<hr>
			
		 					<table class="table table-responsive table-hover"  width="100px" >
					        <thead> 
					            <th>Subcategory Name</th>
					            <th>Categoryid</th>
					            <th>Action</th>
					        </thead>    
					        <tbody> 
					             @foreach($subcategories as $subcategory)
					              <tr>
					              	<td>{{ $subcategory -> name }}</td>
					                <td>{{ $subcategory -> category_id }}</td>
					                <td>    
								    <a href="{{ 'editSubcategories/'. $subcategory->id}}">Edit</a>
								    <a href="{{ 'deleteSubcategories/' . $subcategory->id}}">Delete</a>
								    </td>
								    </tr>    
					             @endforeach
					         
					            </tbody>
					    </table>
                	  {{ $subcategories->links() }}
                </div>
            	
            	</div>	
					<div class="col-md-4">
					<div class="panel panel-default">
                <div class="panel-heading"> Brand</div>
					<form id="categories-form" action="addBrands" method="POST">
							<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
							<br/>
							Brand Name
							<input type="text" name="brand" class="form-control"><br/>
							<input type="submit" value="Save Category" class="btn btn-primary  pull-right">
					</form>
					<hr>
			
		 					<table class="table table-responsive table-hover"  width="100px" >
					        <thead> 
					            <th>Brand ID</th>
					            <th>Brand Name</th>
					            <th>Action</th>
					        </thead>    
					        <tbody> 
					             @foreach($brand as $brands)
					              <tr>
					              	<td>{{ $brands -> id }}</td>
					                <td>{{ $brands -> name }}</td>
					                <td>    
								    <a href="{{ 'editBrands/'. $brands->id}}">Edit  </a>
								    <a href="{{ 'deleteBrands/' . $brands->id}}">Delete</a>
								    </td>
								    </tr>    
					             @endforeach
					            </tbody>
					    </table>
                	  {{ $brand->links() }}
                </div>
            	
            	</div>	
			</div>
		</div>
	</div> 

<hr>
<!-- Modal category -->
					  <div class="modal fade" id="editCatModal" role="dialog">
					    <div class="modal-dialog modal-sm">
					      <div class="modal-content">
					        <div class="modal-header">
					          <button type="button" class="close" data-dismiss="modal">&times;</button>
					          <h4 class="modal-title">Edit Category</h4>
					        </div>
					        <div class="modal-body">
					          <form id="categories-form" action="{{action('AdminController@updateCategories')}}" method="POST">
									<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
									<br/>
									Category Name
									<input type="text" name="category" id="category" class="form-control"><br/>
							  </form>
					        </div>
					        <div class="modal-footer">
					          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					           <button type="button" class="btn btn-primary" id="modalsave-category" data-dismiss="modal">Save changes</button>
					        </div>
					      </div>
					    </div>
					  </div>
					</div>

	<script>
			var url = '{{ URL::to('edit') }}';
	</script>
@stop
