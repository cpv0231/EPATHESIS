
@extends('layout.dashboard')

@section('content')

	<br><br><br><br>
	<div class="container-fluid">
	<div class="row">	
		<div class="col-md-12">
		<div id="edit">
			<div class="row">
				<div class="col-md-8" style="align:center;">
					<div class="panel panel-default">
                <div class="panel-heading">Update Brand</div>
					<form id="categories-form" action="{{action('AdminController@updateBrands')}}" method="POST">
							<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
							<br/>
							 <input type="hidden" name="id" value="<?=  $row->id ?>">
							Category Name
							<input type="text" name="brand" value="<?= $row->name  ?>"class="form-control"><br/>
							<input type="submit" value="Save Brand" class="btn btn-primary pull-right">
					</form>
                </div>
            </div>
         </div>

       <br><br><br><br>
		<hr>	
	</div>	
 @stop

