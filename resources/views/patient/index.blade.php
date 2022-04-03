@extends('layouts.master')
@section('title','Appointment Management | Login')
@section('content')

<div class='container'>
  <div class='row'>
    <div class='col-md-12'>
      <h1>{{ ucfirst($user->roles->first()->name) }} Dashboard</h1>
    </div>

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
    @can('appointment_show')
    <div>
      <div class="container">
        <h4>Patients</h4>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Mobile</th>
            </tr>
          </thead>
          <tbody>
            @foreach($patients as $patient)
              <tr>
                <th scope="row">{{ $patient->name ?? '' }}</th>
                <th scope="row">{{ $patient->email ?? '' }}</th>
                <td>{{ $patient->mobile ?? '' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endcan
  </div>
</div>
<div class="modal fade updateAppointmentStatus" id="updateAppointmentStatus" data-backdrop="static" data-keyboard="false" tabindex="-1" role="updateSplashImage" aria-labelledby="gridSystemModalLabel">
</div>
@endsection
@section('script')
  <script type="text/javascript">
    //On Edit of Discount
    $('a#update_status').on('click', function(e) {
     var appointmentId = $(this).attr('data-id');
     $.ajax({
        url: "{{route('updateStatus')}}",
        method: "POST",
        dataType: "json",
        data:{'id':appointmentId},
        success: function(response) {
          if (response.status == 200) {
            $('#updateAppointmentStatus').html(response.html);
            $('.updateAppointmentStatus').modal('show');
          } 
        }
      }); 
    });
  </script>
@stop