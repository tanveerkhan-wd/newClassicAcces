 @extends('layout.app_with_login')
@section('title','Settings')
@section('script', url('public/js/dashboard/settings.js'))
@section('content')
 <!-- Page Content  -->
<div class="section">
  <div class="container-fluid">
    <h5 class="title">{{'Settings'}} > {{'General Setting'}}</h5>
        <div class="white_box">
            <div class="theme_tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item tabs">
                      <a class="nav-link active" id="general-setting-tab" data-toggle="tab" href="#general-setting" role="tab" aria-controls="general-setting" aria-selected="true">General Setting</a>
                  </li>
                  <li class="nav-item tabs">
                      <a class="nav-link" id="logo-images-tab" data-toggle="tab" href="#logo-images" role="tab" aria-controls="logo-images" aria-selected="true">Logos</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                      
                      <div class="tab-pane fade show active" id="general-setting" role="tabpanel" aria-labelledby="general-setting-tab">
                        <div class="inner_tab">
                          <form name="general-form">
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>{{'Primary Phone'}} <span class="text-danger">*</span></label>
                                  <input type="text" required="" name="general_setting_pphone" class="form-control icon_control" value="{{ Settings::get('general_setting_pphone') ?? '' }}">
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>{{'Secondary Phone'}} <span class="text-danger">*</span></label>
                                  <input type="text" required="" name="general_setting_sphone" class="form-control icon_control" value="{{ Settings::get('general_setting_sphone') ?? '' }}">
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{'Email'}} <span class="text-danger">*</span></label>
                                    <input type="text" required="" name="general_setting_email" class="form-control icon_control" value="{{ Settings::get('general_setting_email') ?? '' }}">
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{'Our Address'}} <span class="text-danger">*</span></label>
                                    <textarea required="" name="general_setting_address" class="form-control icon_control">{{ Settings::get('general_setting_address') ?? '' }}</textarea>
                                </div>
                              </div>

                              <div class="col-12 text-center">
                                <a class="theme_btn red_btn no_sidebar_active" href="{{ url('admin/settings') }}">{{'Cancel'}}
                                </a><button class="theme_btn">Save</button>
                              </div>

                            </div>
                          </form>
                        </div>
                      </div>

                      <div class="tab-pane fade show" id="logo-images" role="tabpanel" aria-labelledby="logo-images-tab">
                          <div class="inner_tab">
                              <form name="logo-form">
                              <div class="row">
                                  <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                      <div class="">
                                      
                                      <label>{{'Admin Logo'}}</label>
                                      <div class="text-center">
                                        <div class="profile_box">
                                            <div class="square_pic">
                                                <img id="img" src="@if(Settings::has('general_setting_admin_logo')) {{ url('public/uploads/'.Settings::get('general_setting_admin_logo')) }} @else {{ url('public/images/user.png') }} @endif">
                                                <input type="hidden" id="img_tmp" value="{{ url('public/images/user.png') }}">
                                            </div>
                                            <div  class="upload_pic_link">
                                                <a href="javascript:void(0)">
                                                {{'Upload Image'}}<input type="file" id="upload_profile" name="general_setting_admin_logo" accept="image/jpeg,image/png"></a>
                                            </div>
                                        </div>
                                      </div>

                                      <label>{{'Login Page Logo'}}</label>
                                      <div class="text-center">
                                        <div class="profile_box">
                                            <div class="square_pic">
                                                <img id="login_img" src="@if(Settings::has('general_setting_login_logo')) {{ url('public/uploads/'.Settings::get('general_setting_login_logo')) }} @else {{ url('public/images/user.png') }} @endif">
                                                <input type="hidden" id="login_img_tmp" value="{{ url('public/images/user.png') }}">
                                            </div>
                                            <div  class="upload_pic_link">
                                                <a href="javascript:void(0)">
                                                {{'Upload Image'}}<input type="file" id="login_upload_profile" name="general_setting_login_logo" accept="image/jpeg,image/png"></a>
                                            </div>
                                        </div>
                                      </div>
                                        
                                      </div>
                                      <div class="text-center">
                                          <a class="theme_btn red_btn no_sidebar_active" href="{{ url('admin/settings') }}">{{'Cancel'}}
                                          </a><button class="theme_btn">Save</button>
                                      </div>
                                    </div>
                                  <div class="col-lg-3"></div>
                              </div>
                              </form>
                          </div>
                      </div>

                </div>
            </div>
        </div>
      </div>
  </div>
          
   @if ($errors->any())
        <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (\Session::has('success'))
        <div class="alert alert-success">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif

    @php                                     
      $_REQUEST['data'] = (isset($_REQUEST['data']) && !empty($_REQUEST['data']))?$_REQUEST['data']:'profile';
    @endphp

<!-- End Content Body -->
@endsection
@push('custom-styles')
@endpush
@push('datatable-scripts')
<!-- Include this Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/settings.js') }}"></script>

@endpush