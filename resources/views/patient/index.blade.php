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
        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Mobile</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($patients as $patient)
              <tr>
                <td scope="row">{{ $patient->name ?? '' }}</td>
                <td scope="row">{{ $patient->email ?? '' }}</td>
                <td>{{ $patient->mobile ?? '' }}</td>
                @can('patient.edit')
                  <td>
                    <a href="#" class="btn btn-sm btn-gradient-primary mb-3" data-id="{{ $patient->id }}" id="update_patient">Edit</a>
                    <label class="togglebox toggleStatus ml-1" data-id="{{ $patient->id ?? ''}}">
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
<div class="modal fade updatePatient" id="updatePatient" data-backdrop="static" data-keyboard="false" tabindex="-1" role="updateSplashImage" aria-labelledby="gridSystemModalLabel">
</div>
@endsection
@section('script')
  <script type="text/javascript">
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );

    //On Edit of Discount
    $('a#update_patient').on('click', function(e) {
     var patientId = $(this).attr('data-id');
     $.ajax({
        url: "{{route('updatePatient')}}",
        method: "POST",
        dataType: "json",
        data:{'id':patientId},
        success: function(response) {
          if (response.status == 200) {
            $('#updatePatient').html(response.html);
            $('.updatePatient').modal('show');
          } 
        }
      }); 
    });
  </script>
@stop