<form action="{{ route('doctor.update', $doctor->id) }}" method="post" enctype="multipart/form-data" id="update_doctor">
  <input type="hidden" name="appointment_id" value="{{$doctor->id}}">
  @csrf
  {{ method_field('PUT') }}
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <h5>Update Doctor</h5>
            <div class="col-md-12">
                       <div class="mb-3">
                        <label for="name" class="form-label required">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name..." value="{{ $doctor->name ?? '' }}" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                       <div class="mb-3">
                        <label for="email" class="form-label required">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter your email..." value="{{ $doctor->email ?? '' }}" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                       <div class="mb-3">
                        <label for="mobile" class="form-label required">Mobile Number</label>
                        <input type="mobile" class="form-control number-only" id="mobile" name="mobile" placeholder="Enter your mobile..." value="{{ $doctor->mobile ?? '' }}" required>
                      </div>
                    </div>
                    <div class="col-md-12" id="qualification_div">
                      <div class="mb-3">
                        <label for="qualification" class="form-label required">Qualification</label>
                        <input type="qualification" class="form-control" id="qualification" name="qualification" placeholder="Enter Qualification..." value="{{ $doctor->qualification ?? '' }}" required>
                      </div>
                    </div>
                    <div class="col-md-12" id="specialization_div">
                      <div class="mb-3">
                        <label for="specialization" class="form-label required">Specialization</label>
                        <input type="specialization" class="form-control" id="specialization" name="specialization" placeholder="Enter Specialization..." value="{{ $doctor->specialization ?? '' }}" required>
                      </div>
                    </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Update</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
  </div>
</form>
<script type="text/javascript">
  $().ready(function() {
        //Validate the form data
        $('form#update_doctor').validate({
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
</script>
