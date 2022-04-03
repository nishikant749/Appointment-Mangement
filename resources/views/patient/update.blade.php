<form action="{{ route('patient.update', $patient->id) }}" method="post" enctype="multipart/form-data" id="update_patient">
  <input type="hidden" name="appointment_id" value="{{$patient->id}}">
  @csrf
  {{ method_field('PUT') }}
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <h5>Update Patient</h5>
            <div class="col-md-12">
                       <div class="mb-3">
                        <label for="name" class="form-label required">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name..." value="{{ $patient->name ?? '' }}" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                       <div class="mb-3">
                        <label for="email" class="form-label required">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter your email..." value="{{ $patient->email ?? '' }}" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                       <div class="mb-3">
                        <label for="mobile" class="form-label required">Mobile Number</label>
                        <input type="mobile" class="form-control number-only" id="mobile" name="mobile" placeholder="Enter your mobile..." value="{{ $patient->mobile ?? '' }}" required>
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
            email: {
              required: true,
              email    : true,
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
            email: {
                required  : "We need your valid email address for communication",
                email: "Your email address must be in the format of name@domain.com",
                remote : "User already exist on provided email."
            },
          }
        });
    });
</script>
