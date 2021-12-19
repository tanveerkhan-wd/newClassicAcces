<nav id="sidebar" class="">
    <div class="sidebar-header">
        <a href="{{route('adminDashboard')}}">
          <img src="@if(Settings::has('general_setting_admin_logo')) {{ url('public/uploads/'.Settings::get('general_setting_admin_logo')) }} @endif" style="height: 100%;width: auto;" alt="Logo">
        </a>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ (request()->is('admin/dashboard')) || (request()->is('admin/profile')) ? 'active' : '' }}">
            <a href="{{route('adminDashboard')}}">
               <img src="{{ url('public/images/ic_dashoard.png') }}" class="color">
               <img src="{{ url('public/images/ic_dashoard_color.png') }}" class="selected">
                {{'Dashboard'}}
            </a>
        </li>

        <li class="{{ Request::is('admin/product') || Request::is('admin/product/*') ? 'active' : '' }}">
            <a href="{{url('/admin/product')}}">
               <img src="{{ url('public/images/ic_cart.png') }}" class="color">
               <img src="{{ url('public/images/ic_cart_color.png') }}" class="selected">
                {{'Products'}}
            </a>
        </li>

        <li class="{{ Request::is('admin/customer') || Request::is('admin/customer/*') || Request::is('admin/bill') || Request::is('admin/bill/*') ? 'active' : '' }}">
            <a href="{{url('/admin/customer')}}">
               <img src="{{ url('public/images/ic_users.png') }}" class="color">
               <img src="{{ url('public/images/ic_users_color.png') }}" class="selected">
                {{'Customer'}}
            </a>
        </li>

        <li class="{{ Request::is('admin/bills') || Request::is('admin/bills/*') ? 'active' : '' }}">
            <a href="{{url('/admin/bills')}}">
               <img src="{{ url('public/images/ic_monitor.png') }}" class="color">
               <img src="{{ url('public/images/ic_monitor_color.png') }}" class="selected">
                {{'Bills'}}
            </a>
        </li>

        <li class="{{ Request::is('admin/settings') || Request::is('admin/settings/*') ? 'active' : '' }}">
            <a href="{{url('/admin/settings')}}">
               <img src="{{ url('public/images/ic_business.png') }}" class="color">
               <img src="{{ url('public/images/ic_business_color.png') }}" class="selected">
                {{'Settings'}}
            </a>
        </li>

    </ul>
</nav>