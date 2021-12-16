@extends('front.layout.app_with_front')
@section('title','Dubai E-Visa')
@section('content')
@php
	$banrImg = Settings::get('general_setting_404_bg_img') ? url('public/uploads/thumbnail/1400x470/'.Settings::get('general_setting_404_bg_img')) :url('public/front_assets/img/hotels_bg.jpg');
@endphp
<section id="hero" class="background-image" data-background="url({{$banrImg}})">
    <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
		<div class="intro_title error">
			<h1 class="animated fadeInDown">404</h1>
			<p class="animated fadeInDown">Oops!! Page not found</p>
			<a href="{{url('/')}}" class="animated fadeInUp button_intro">Back to home</a> <a href="{{ url('hotels')}}" class="animated fadeInUp button_intro outline">View all hotels</a>
		</div>
    </div>
</section>
<!-- End hero -->
@endsection
@push('meta')
   
@endpush
@push('styles')
   
@endpush
@push('scripts')
    
@endpush