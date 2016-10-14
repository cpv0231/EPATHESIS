
@extends('layout.app')
@section('content')
<div class="cover">
<div class="container">
    <div class="row">
        <div class="col-sm-2 col-md-4 col-md-offset-4">
            <div class="account-wall">
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

                <h1 class="form-signin-heading">Sign Up</h1>
                
                    <form class="form-signin" action="create" method="post">
                      <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    
                      <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2"> <span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" placeholder="First name" name="firstname" aria-describedby="sizing-addon2">
                      </div><br>

                      <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2"> <span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" placeholder="Last name" name="lastname" aria-describedby="sizing-addon2">
                      </div><br>

                      <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-tag"></span></span>
                        <input type="text" class="form-control" placeholder="Address1" name="address1" aria-describedby="sizing-addon2">
                      </div><br>

                        <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-tag"></span></span>
                        <input type="text" class="form-control" placeholder="Address2" name="address2" aria-describedby="sizing-addon2">
                      </div><br>


                      <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2"> <span class="glyphicon glyphicon-envelope"></span></span>
                        <input type="text" class="form-control" placeholder="Email" name="email" aria-describedby="sizing-addon2">
                      </div><br>

                      <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2"> <span class="glyphicon glyphicon-asterisk"></span></span>
                        <input type="password" class="form-control" placeholder="Password" name="password" aria-describedby="sizing-addon1">
                      </div><br>

                      <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2"> <span class="glyphicon glyphicon-asterisk"></span></span>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Comfirmed password" aria-describedby="sizing-addon2">
                      </div><br>
                      <hr>
                        <label class="checkbox pull-left" id="remember">
                            <input type="checkbox" value="remember-me">
                          Remember me
                        </label>
                        <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                        <a href="{{URL::to('users/signin')}}" class="text-center new-account">Already have an account </a>
                           
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
                    </form>
                </div> <!-- /wall -->
            </div><!-- /column -->
        </div><!-- /row -->
    </div><!-- /container -->
  
</div><!-- /cover -->

@stop