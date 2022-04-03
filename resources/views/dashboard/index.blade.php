@extends('layouts.master')
@section('title','Appointment Management | Login')
@section('content')

<div class='container'>
  <div class='row'>
    <div class='col-md-12'>
      <h1>{{ ucfirst($user->roles->first()->name) }} Dashboard - {{ $user->name }}</h1>
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
        <h4>Appointments</h4>
        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">Patient Name</th>
              <th scope="col">Patient Email</th>
              <th scope="col">Doctor Name</th>
              <th scope="col">Visit Date</th>
              <th scope="col">Timing</th>
              <th scope="col">Current Status</th>
              @can('appointment_status_update')
                <th scope="col">Update Status</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach($appointments as $appointment)
              <tr class="{{ $appointment->status_color }}">
                <th scope="row">{{ $appointment->patient_name ?? '' }}</th>
                <th scope="row">{{ $appointment->email ?? '' }}</th>
                <td>{{ $appointment->doctor->name ?? '' }}</td>
                <td>{{ $appointment->visit_date->format('Y-m-d') ?? '' }}</td>
                <td>{{ $appointment->visit_timing }}</td>
                <td>{{ $appointment->status }}</td>
                @can('appointment_status_update')
                  <td>
                    <a href="#" class="btn btn-sm btn-gradient-primary mb-3" data-id="{{ $appointment->id }}" id="update_status">Update Status</a>
                    <label class="togglebox toggleStatus ml-1" data-id="{{ $appointment->id ?? ''}}">
                    </label>
                  </td>
                @endcan
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
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );

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