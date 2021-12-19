@extends('layout.app_with_login')
@section('title', 'Dashboard')
@section('content')	
<!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row text-center equal_height">
            <div class="col-md-3 col-sm-6 col-xs-6 equal_height_container">
                <div class="dash_tile">
                    <a data-slug="admin/products" href="{{url('admin/products')}}">
                        <div class="dash_tile_top">
                        	<img src="{{ url('public/images/product-management.png') }}" class="tile_img">
               				<img src="{{ url('public/images/product-management.png') }}" class="tile_hover_img">
                        </div>
                        <div class="dash_tile_bottom">
                            <p>Total Products</p>
                            <h3>{{ $data['product'] ?? 0 }}</h3>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 equal_height_container">
                <div class="dash_tile">
                    <a href="#">
                        <div class="dash_tile_top">
                            <img src="{{ url('public/images/people.png') }}" class="tile_img">
                            <img src="{{ url('public/images/people.png') }}" class="tile_hover_img">
                        </div>
                        <div class="dash_tile_bottom">
                            <p>Total Customers</p>
                            <h3>{{ $data['customer'] ?? 0 }}</h3>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6 equal_height_container">
                <div class="dash_tile">
                    <a href="#">
                        <div class="dash_tile_top">
                            <img src="{{ url('public/images/bill.png') }}" class="tile_img">
                            <img src="{{ url('public/images/bill.png') }}" class="tile_hover_img">
                        </div>
                        <div class="dash_tile_bottom">
                            <p>Total Bills</p>
                            <h3>{{ $data['bills'] ?? 0 }}</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
	</div>
</div>

@endsection
@push('custom-styles')
   
@endpush
@push('custom-scripts')
@endpush