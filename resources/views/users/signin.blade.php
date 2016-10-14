
@extends('layout.app')
@section('content')
<div class="cover">

  <div class="container">
      <div class="row">
          <div class="col-sm-2 col-md-4 col-md-offset-4">
              <div class="account-wall col-md-12">
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

                  <h1 class="form-signin-heading">Login</h1>
                  <form class="form-signin" method="POST" action="login">
                  
                   <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    
                    
                    <div class="input-group">
                      <span class="input-group-addon" id="sizing-addon2"> <i class="glyphicon glyphicon-user"></i></span>
                      <input type="text" class="form-control" name="email" placeholder="Email" aria-describedby="sizing-addon2">
                    </div><br>
                  
                    <div class="input-group">
                      <span class="input-group-addon" id="sizing-addon2"> <i class="glyphicon glyphicon-asterisk"></i></span>
                      <input type="password" class="form-control" name="password" placeholder="Password" aria-describedby="sizing-addon2">
                    </div>
                    <br>
                    
                  <button class="btn btn-lg btn-primary btn-block" type="submit">
                     Sign in 
                  </button>
                      <hr>
                  <label class="checkbox pull-left" id="remember">
                      <input type="checkbox" value="remember-me">
                      Remember me
                  </label>
                  <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                  <a href="{{URL::to('users/newaccount')}}" class="text-center new-account">Create an account </a>
                  </form>
              </div>
              
          </div><!-- /column -->
      </div><!-- /row -->
  </div><!-- /container -->
</div><!-- /cover -->

@stop