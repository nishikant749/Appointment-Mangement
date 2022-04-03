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
        <h4>Doctors</h4>
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
            @foreach($doctors as $doctor)
              <tr>
                <td>{{ $doctor->name ?? '' }}</th>
                <td>{{ $doctor->email ?? '' }}</th>
                <td>{{ $doctor->mobile ?? '' }}</td>
                @can('doctor.edit')
                  <td>
                    <a href="#" class="btn btn-sm btn-gradient-primary mb-3" data-id="{{ $doctor->id }}" id="update_doctor">Edit</a>
                    <label class="togglebox toggleStatus ml-1" data-id="{{ $doctor->id ?? ''}}">
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
<div class="modal fade updateDoctor" id="updateDoctor" data-backdrop="static" data-keyboard="false" tabindex="-1" role="updateSplashImage" aria-labelledby="gridSystemModalLabel">
</div>
@endsection
@section('script')
  <script type="text/javascript">
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
    
    //On Edit of Discount
    $('a#update_doctor').on('click', function(e) {
     var doctorId = $(this).attr('data-id');
     $.ajax({
        url: "{{route('updateDoctor')}}",
        method: "POST",
        dataType: "json",
        data:{'id':doctorId},
        success: function(response) {
          if (response.status == 200) {
            $('#updateDoctor').html(response.html);
            $('.updateDoctor').modal('show');
          } 
        }
      }); 
    });
  </script>
@stop