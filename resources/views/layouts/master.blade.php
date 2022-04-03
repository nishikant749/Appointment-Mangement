<html>
<head>
  <title>
    @yield('title')
  </title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Core stylesheets -->
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
  <style type="text/css">
    .error {
      color: red;
      font-style: italic;
    }
    .required:after {
      content:" *";
      color: red;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
          <li class="nav-item">
            @if(!isset(Auth::user()->id))
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            @endif
          </li>
          <li class="nav-item">
            @if(isset(Auth::user()->id))
              <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
            @endif
          </li>
          <li class="nav-item">
            @if(!isset(Auth::user()->id))
              <a class="nav-link" href="{{ route('register.index') }}">Register</a>
            @endif
          </li>
          <li class="nav-item">
            @if(isset(Auth::user()->id))
              @can('appointment_create')
                <a class="nav-link" href="{{ route('appointment.create') }}">Book Appointment</a>
              @endcan
            @else
              <a class="nav-link" href="{{ route('guestAppointment.create') }}">Book Appointment</a>
            @endif
          </li>
          <li class="nav-item">
            @if(isset(Auth::user()->id))
              @can('patient.show')
                <a class="nav-link" href="{{ route('patient.index') }}">Patients</a>
              @endcan
            @endif
          </li>
           <li class="nav-item">
            @if(isset(Auth::user()->id))
              @can('doctor.show')
                <a class="nav-link" href="{{ route('doctor.index') }}">Doctors</a>
              @endcan
            @endif
          </li>
          <li class="nav-item">
            @if(isset(Auth::user()->id))
              <a class="nav-link" href="{{ route('logout') }}">Logout</a>
            @endif
          </li>
        </ul>
      </div>
    </div>
  </nav>
  @yield('content')
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>  
  <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>  
  <script src="{{asset('assets/js/jquery.validate.js')}}"></script>  
  <script src="{{asset('assets/js/bootstrap-datepicker.js')}}"></script>  
  <script src="{{asset('assets/js/moment.min.js')}}"></script>  
  <script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>  
  <script type="text/javascript">
    $(document).ready(function() {
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
  </script>
  @yield('script')
</body>
</html>