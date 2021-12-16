@if(Auth::check() && Auth::user()->user_type==0)
	@include('admin.sidebar.sidebar')
@endif

@if(Auth::check() && Auth::user()->user_type==1)
	@include('admin.sidebar.seller_sidebar')
@endif