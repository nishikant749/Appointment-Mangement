@extends('layouts.master')
@section('title','Appointment Management | Register')
@section('content')

<div class='container'>
  <div class='row'>
    <div>
      <form id="register_form" method="post" action="{{  route('register.store') }}">
        @csrf
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-6">
              <h1>Register</h1>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="i_am" class="form-label required">I am</label>
                        <div class="dropdown">
                          <select name="user_type" id="i_am" class="form-control required" name="i_am" required>
                            <option value="doctor">Doctor</option>
                            <option value="patient">Patient</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="mb-3">
                        <label for="name" class="form-label required">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name..." required>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="mb-3">
                        <label for="email" class="form-label required">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter your email..." required>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="mb-3">
                        <label for="mobile" class="form-label required">Mobile Number</label>
                        <input type="mobile" class="form-control number-only" id="mobile" name="mobile" placeholder="Enter your mobile..." required>
                      </div>
                    </div>
                    <div class="col-md-6" id="qualification_div">
                      <div class="mb-3">
                        <label for="qualification" class="form-label required">Qualification</label>
                        <input type="qualification" class="form-control" id="qualification" name="qualification" placeholder="Enter Qualification..." required>
                      </div>
                    </div>
                    <div class="col-md-6" id="specialization_div">
                      <div class="mb-3">
                        <label for="specialization" class="form-label required">Specialization</label>
                        <input type="specialization" class="form-control" id="specialization" name="specialization" placeholder="Enter Specialization..." required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label required">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password..." required>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                  </div>
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
        $('form#register_form').validate({
          rules: {
            name: {
              required: true,
            },
            mobile: {
              required: true,
              digits    : true,
              minlength : 10,
              maxlength : 10
            },
            i_am: {
              required: true
            },
            email: {
              required: true,
              email    : true,
              remote: {
                  url: "{{ route('userCheckOnEmail') }}",
                  type: "post"
              }
            },
            qualification: {
              required: true,
            },
            password: {
              required: true,
              rangelength  : [8, 12],
            },
          },
          messages: {
            name: "Please enter your name.",
            mobile: {
              required: "Please enter your mobile number.",
              digits : "Please enter digits only",
              minlength: "Please enter 10 digits number.",
              maxlength: "Please enter 10 digits number."
            },
            i_am: "Please choose who you are.",
            email: {
                required  : "We need your valid email address for communication",
                email: "Your email address must be in the format of name@domain.com",
                remote : "User already exist on provided email."
            },
            qualification: "Please enter your Qualification.",
            specialization: "Please enter your Specialization.",
            password: {
              required: "Please enter strong Password.",
              rangelength: "Please enter min 8 and max 12 characters.",
            }
          }
        });
    });

    //On change of User Type Hide show the inputs
    $("select#i_am").on('change', function(e) {
      //fetch the value of selected 
      let userType = $('select#i_am :selected').val();

      //Validate user Type and do action
      if(userType == 'patient') {
        $("input#qualification").val('');
        $("input#specialization").val('');
        $("#qualification_div").hide();
        $("#specialization_div").hide();
      } else {
        $("#qualification_div").show();
        $("#specialization_div").show();
      }
    });
    //Validate password on form Submit
    $("form#register_form").on('submit', function(e) {
      e.preventDefault();
      //Set Password Validation Regular Expression
      //let strongPasswordRegex = new RegExp('(^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8}$)');
      let strongPasswordRegex = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})');
      //Fetch the password
      let password = $("#password").val();
      console.log(password);

      //Validate password
      if(!strongPasswordRegex.test(password)) {
        //alert for Strong Password
        alert("*Ensure string has one uppercase letters.\n*Ensure string has one special case letter.\n*Ensure string has one digits.\n*Ensure string has one lowercase letters.\n*Ensure string is of length 8.");
        
        //return false
        return false;
      }

      //check if user already exist on email

      //return 
      $("form#register_form")[0].submit();
    });

    //accept only numbers
    $('.number-only').keypress(function(event){
      if ( event.which < 48 || event.which > 57 ) {
        event.preventDefault();
      }
    });
   
  </script>
@stop