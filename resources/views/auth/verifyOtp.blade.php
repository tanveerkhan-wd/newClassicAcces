@extends('layout.app_without_login')
@section('title','verify Otp')
@section('content')
  <!-- /.login-logo -->
  <div class="auth_box">
      @if (\Session::has('success'))
          <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              {{ session()->get('success') }}
          </div>
      @endif
      @if ($errors->any())
      @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ $error }}
        </div>
      @endforeach
      @endif
    <form action="{{ route('verifyOtpPost') }}" method="post" id="loginForm" name="loginForm">
      {{ csrf_field() }}
      <div class="row">
          <input type="hidden" name="user_id" value="{{$user_id->user_id}}">
          <div class="col-lg-1"></div>
          <div class="col-lg-10">
            <h1>{{'Verify OTP'}}</h1>
            <p class="auth_text">{{'Please enter OTP that send to your registered Email address'}}</p>
            <div class="form-group">
              <label>{{'OTP'}}</label>
              <input type="text" name="otp" class="form-control" placeholder="{{'Enter OTP'}}" required>
            </div>
            <div class="text-center">
              <button class="theme_btn auth_btn">{{'Verify OTP'}}</button>
              <button type="button" class="theme_btn auth_btn" id="resendOtp-form">{{'Resend OTP'}}</button>
              <p><a href="{{ route('adminLoginForm') }}" class="auth_link">{{'Login'}}</a></p>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="text-center">© Copyright {{ now()->year }} {{env('APP_NAME')}} | All Rights Reserved</div>
              </div>
            </div>
          </div>
          <div class="col-lg-1"></div>
        </div>
    </form>
    <form class="resendOtp-form" action="{{ route('forgotPasswordPost') }}" method="post">
      {{ csrf_field() }}
        <input type="hidden" name="email" value="{{$user_id->email}}">
    </form>
  </div>
  <!-- /.login-box-body -->
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ url('public/js/login/otp.js') }}"></script>
@endpush