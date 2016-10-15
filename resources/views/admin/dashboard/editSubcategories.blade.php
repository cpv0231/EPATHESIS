3
@extends('layout.dashboard')

@section('content')

	<br><br><br><br>
	<div class="container-fluid">
	<div class="row">	
		<div class="col-md-12">
		<div id="edit">
			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
                <div class="panel-heading">Edit Subcategory</div>
                <form id="" action="{{action('AdminController@updateSubcategory')}}" method="POST">
							<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
							<br/>
							 <input type="hidden" name="id" value="<?=  $rows->id ?>">
							Subcategory Name
							<input type="text" name="subcategory" value="<?= $rows->name  ?>"
							class="form-control"><br/>
							Category
								<select name="category_id"  class="form-control input-sm">
								<option    value="<?= $rows->category_id  ?>" selected>Select your option</option>

								@foreach($category as $categories)
								<option  value="{{ $categories->id }}">
									{{ $categories -> name}}
								</option>
								@endforeach		
								</select>
								<class="form-control"><br/>
							
							<input type="submit" value="Save Category" class="btn btn-primary pull-right">
					</form>
					
                </div>
            </div>
         </div>

       <br><br><br><br>
		<hr>	
	</div>	
 @endsection

