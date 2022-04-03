@extends('layouts.master')
@section('title','Appointment Management | Login')
@section('content')

<div class='container'>
  <div class='row'>
    @if ($message = Session::get('error'))
     <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ $message }}</strong>
     </div>
   @endif

    @if(session()->has('message'))
      <div class="alert alert-success">
          {{ session()->get('message') }}
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
      @if(isset(Auth::user()->id))
        <form id="login_form" method="post" action="{{  route('appointment.store') }}">
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" id="user_id">
      @else
        <form id="login_form" method="post" action="{{  route('guestAppointment.store') }}">
          <input type="hidden" name="user_id" value="0" id="user_id">
      @endif
        @csrf
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-6">
              <h1>Book Appointment</h1>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                       <div class="mb-3">
                        <label for="email" class="form-label required">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter your email..." required {{ $user != '' ? "readonly" : '' }} value="{{ $user != '' ? $user->email : ''}}">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label for="name" class="form-label required">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name..." required {{ $user != '' ? "readonly" : '' }} value="{{ $user != '' ? $user->name : ''}}">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label for="name" class="form-label required">Disease</label>
                        <input type="text" class="form-control" name="disease" id="disease" disease="disease" placeholder="Enter Disease..." required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label for="date_of_appointment" class="form-label required">Appointment Date</label>
                        <input type="text" class="form-control date_of_appointment" name="date_of_appointment" id="date_of_appointment" name="date_of_appointment" placeholder="Select Appointment Date..." required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label for="doctor" class="form-label required">Doctors</label>
                        <div class="dropdown">
                          <select  id="doctor" class="form-control required doctor" name="doctor_id" required>
                            @foreach($doctors as $doctor)
                              <option value="{{ $doctor->id }}">{{ $doctor->name_with_specialization }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="display:none" id="slots_main_div">
                      <label for="doctor" class="form-label required">Avilable Slots</label>
                      <div class="mb-3" id="slot_div">
                      </div>
                    </div>
                    <div class="col-md-12"  id="messageBox">
                      
                    </div>

                  </div>
                  <button type="submit" class="btn btn-primary">Create</button>
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
            },
            name: {
              required: true,
            },
             disease: {
              required: true,
            },
            date_of_appointment: {
              required: true,
            },
            slot_id: {
              required: true,
            },
          },
          errorPlacement: function (error, element) {
              if (element.attr("name") == "slot_id") {
                  error.appendTo("#messageBox");
              } else {
                  error.insertAfter(element)
              }
          },
          messages: {
            email: {
              required  : "Please Enter your Email",
              email: "Your email address must be in the format of name@domain.com",
            },
            name: {
              required: "Please enter Name.",
            },
            disease: {
              required: "Please enter Disease you have.",
            }, 
            date_of_appointment: {
              required: "Please choose Appointment Date.",
            }, 
            slot_id: {
              required: "Please choose Appointment Slot.",
            },
          }
        });
    });

    //Set Dates
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    //Set the datepicker date Style to Y-m-D
    $( "input#date_of_appointment" ).datepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
      startDate: today,
    });

    //onchange of doctor or appointment date
    $(".date_of_appointment, .doctor").on('change', function(e) {
      e.preventDefault();

      //Fetch dateof Appointment and doctor
      let appointmentDate = $('input.date_of_appointment').val();
      let doctorId = $('#doctor :selected').val();

      //call teh ajax to Fetch all Slots on Date and Doctor
      if(appointmentDate != '' && doctorId != '') {
        var userId = $("#user_id").val();
        var routeToFetchSlots = (userId == 0) ? 'fetchGuestSlots' : 'fetchSlots';
        
        //Ajax
        $.ajax({
          url: '/'+routeToFetchSlots,
          method: "POST",
          dataType: "json",
          data:{'doctorId':doctorId, 'appointmentDate':appointmentDate},
          success: function(response) {
            if (response.status == 200) {
              var slotHtml = '';
              $.each(response.slots, function(index, slot) {
                let slotName = slot.start_time+'-'+slot.end_time;
                slotHtml += `<div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value=`+slot.id+` name="slot_id" id="flexRadioDefault1" required>
                            <label class="form-check-label" for="flexRadioDefault1">
                              `+slotName+`
                            </label>
                          </div>`;
              });
              console
              //Append Slot
              $("#slot_div").html(slotHtml);
              $("#slots_main_div").show();
            } 
          }
        });
      }
    
    });
  </script>
@stop