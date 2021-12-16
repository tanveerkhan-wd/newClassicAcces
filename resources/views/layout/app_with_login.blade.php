<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ @csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{env('APP_NAME')}} - @yield('title')</title>
  <link rel="icon" type="image/x-icon" href="{{url('public/images/favicon.ico')}}">
  <link rel="stylesheet" href="{{ url('public/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/animate.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/toastr.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('public/css/jquery.dataTables.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/custom.css') }}">
  <link rel="stylesheet" href="{{ url('public/css/custom-rt.css') }}">
  <style type="text/css">
  .alert a{
    text-decoration: none;
  }
  </style>    
  @stack('custom-styles')
</head>
<body class="hold-transition sidebar-mini">
  <div id="preloader">
    <div id="status">
      <div class="spinner"></div>
    </div>
  </div>
  <div class="inner-container" id="contents" style="opacity: 0;">
    @if (Session::has('middleware_error'))
        <input type="hidden" id="error_msg" value="{!! session('middleware_error') !!}">
    @endif
    <!-- Left side column. contains the logo and sidebar -->
    @include('common.sidebar')
    <div id="content">
      <div id="preloader_new" style="opacity: 0; display: none;">
        <div id="status_new">
          <div class="spinner"></div>
        </div>
      </div>
      <div class="overlay" onclick="closeOverlay()"></div>
      @include('common.header')
      @yield('content') 
    </div>  
    
  </div>
<!-- ./wrapper -->
  <input type="hidden" id="previous_txt" value="{{'Previous'}}">
  <input type="hidden" id="next_txt" value="{{'Next'}}">
  <input type="hidden" id="showing_txt" value="{{'Showing'}}">
  <input type="hidden" id="to_txt" value="{{'to'}}">
  <input type="hidden" id="of_txt" value="{{'of'}}">
  <input type="hidden" id="entries_txt" value="{{'entries'}}">
  <input type="hidden" id="show_txt" value="{{'Show'}}">
  <input type="hidden" id="add_txt" value="{{'Add'}}">
  <input type="hidden" id="access_txt" value="{{'Access'}}">
  <input type="hidden" id="delete_txt" value="{{'Delete'}}">
  <input type="hidden" id="select_txt" value="{{'Select'}}">
  <input type="hidden" id="active_txt" value="{{'Active'}}">
  <input type="hidden" id="inactive_txt" value="{{'Inactive'}}">
  <input type="hidden" id="something_wrong_txt" value="{{'Something Wrong Please try again Later'}}">
  <input type="hidden" id="field_required_txt" value="{{'This field is required'}}">
  <input type="hidden" id="email_validate_txt" value="{{'Please enter a valid email address'}}">
  <input type="hidden" id="minlength_validate_txt" value="{{'Please enter at least {0} characters.'}}">
  <input type="hidden" id="maxlength_validate_txt" value="{{'Please enter no more than {0} characters.'}}">
  <input type="hidden" id="max_validate_txt" value="{{'Please enter no more than {0} characters.'}}">
  <input type="hidden" id="min_validate_txt" value="{{'Please enter a value greater than or equal to {0}.'}}">
  <input type="hidden" id="validate_password_txt" value="{{'The password must be a combination of characters, numbers, one uppercase letter and special characters'}}">
  <input type="hidden" id="validate_password_equalto_txt" value="{{'New password and Confirm password does not match'}}">
  <input type="hidden" id="validate_equalto_txt" value="{{'Please enter the same value again'}}">
  <input type="hidden" id="no_result_text" value="{{'No result found'}}">
  <input type="hidden" id="image_validation_msg" value="{{'Select Valid Image'}}">
  <input type="hidden" id="video_validation_msg" value="{{'Select Valid Video'}}">


<script type="text/javascript">
  var web_title = '{{env('APP_NAME')}}';
</script>
<script src="{{url('public/js/jquery-3.5.1.min.js')}}"></script>
<script type="text/javascript" src="{{ url('public/js/all.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/custom.js') }}"></script>  
<script src="{{ url('public/js/toastr.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ url('public/js/jquery.dataTables.js')}}"></script>
<script src="{{ url('public/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ url('public/js/jquery.validate.js') }}"></script>
<script src="{{ url('public/js/custom_validation_msg.js') }}"></script>
<script src="{{ url('public/js/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
  //show middleware authentication error
    if ($('#error_msg').val()) {
        toastr.error($('#error_msg').val());
    }
  //end
  
  var base_url = '{{ url('/') }}';
  
</script>
  <div id="dataTable_script">
    @stack('datatable-scripts')
  </div>
  @stack('custom-scripts')
</body>
</html>
