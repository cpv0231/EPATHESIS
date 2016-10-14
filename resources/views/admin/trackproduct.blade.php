@extends('layout.app')

@section('content')
	<br>
<div class="col-md-2">
	
</div>
	<div class="col-md-8" >
			<div class="row">
					<div class="panel panel-default">
                		<div class="panel-heading">Most view </div>
					
							
						<table class="table table-responsive table-hover"  >
							<thead>	
								<th>Product ID</th>
								<th>Product Name</th>
								<th>Product view</th>
								
							</thead>	
								<tbody>	
								 @foreach($trackproduct as $data)
							  <tr>	
								  	 <?php 
					        		$imagepath = '';
					        		$imagepath=url('img/products/'.$data->Products -> image);

					      			?>
								 	<td>{{$data->Products -> id}}
								 	</td>
								 	<td><img src="{{$imagepath}}" width="50px" height="50px">{{$data->Products-> title}}
								 	</td>
								 	<td>{{($data -> countview)}}</td>
								  
                           
								</tr>	
								 @endforeach
								 <br/><br/>
								
								</tbody>
						</table>
						
						</div>
					</div>
				</div>
 @stop
