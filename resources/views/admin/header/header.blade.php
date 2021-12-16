<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <button type="button" id="sidebarCollapse" class="btn btn-info">
              <i class="fas fa-align-left"></i>
              <span>Toggle Sidebar</span>
          </button>
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="profile-cover">
                      <img src="{{ Auth::user()->user_photo ? url('public/uploads/'.Config::get('constant.images_dirs.USERS') ).'/'.Auth::user()->user_photo : url('public/images/user.png')}}">
                    </div>
                    <p class="nav-item mr-2 ml-2">{{Auth::user()->name}}</p>
                    <i class="fas fa-chevron-down right-arrow"></i>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                     <a class="dropdown-item ajax_request" @if(Auth::user()->user_type==1) data-slug="seller/profile" href="{{url('seller/profile') }}" @else data-slug="admin/profile" href="{{url('admin/profile') }}" @endif>{{'My Profile'}}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('adminLogout')}}">{{'Logout'}}</a>
                  </div>
              </li>    

            </ul>
            
        </div>
    </div>
</nav>