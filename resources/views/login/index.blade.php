@extends('layouts.master')
@section('title','Appointment Management | Login')
@section('content')

<div class='container'>
  <div class='row'>
    @if(isset(Auth::user()->id))
      <script>window.location="/dashboard";</script>
    @endif

    @if ($message = Session::get('error'))
     <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ $message }}</strong>
     </div>
   @endif

    @if(count($errors))
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div>
      <form id="login_form" method="post" action="{{  route('login') }}">
        @csrf
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-6">
              <h1>Login</h1>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                       <div class="mb-3">
                        <label for="email" class="form-label required">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter your email..." required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label required">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password..." required>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
  <script type="text/javascript">
    $().ready(function() {
        //Validate the form data
        $('form#login_form').validate({
          rules: {
            email: {
              required: true,
              email    : true,
               remote: {
                url: "{{ route('fetchUserOnEmail') }}",
                type: "post"
              }
            },
            password: {
              required: true,
            },
          },
          messages: {
            email: {
              required  : "Please Enter your Email",
              email: "Your email address must be in the format of name@domain.com",
              remote : "Sorry, no user found in our System."
            },
            password: {
              required: "Please enter Password.",
            }
          }
        });
    });
  </script>
@stop