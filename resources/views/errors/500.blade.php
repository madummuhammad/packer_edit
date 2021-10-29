@extends('errors.app')

@section('title', '500 Internal Server Error')

@section('content')

<!--====== 404 Area Start ======-->
<div class="error-area stars">
	<!-- Error Content -->
	<div class="error-content d-flex flex-column justify-content-center align-items-center text-center">
		<img class="error-thumb" src="{{ asset('assets/frontend/img/error/404.svg') }}" alt="">
		<a href="{{ url('') }}" class="btn btn-bordered-white mt-4">GO BACK HOME</a>
	</div>
	<!-- Error Objects -->
	<div class="error-objects">
		<img class="thumb-1" src="{{ asset('assets/frontend/img/error/rocket.svg') }}" alt="">
		<!-- Earth Moon -->
		<div class="earth-moon">
			<img class="thumb-2" src="{{ asset('assets/frontend/img/error/earth.svg') }}" alt="">
			<img class="thumb-3" src="{{ asset('assets/frontend/img/error/moon.svg') }}" alt="">
		</div>
		<!-- Astronaut -->
		<div class="astronaut">
			<img class="thumb-4" src="{{ asset('assets/frontend/img/error/astronaut.svg') }}" alt="">
		</div>
	</div>
	<!-- Glowing Stars -->
	<div class="glowing-stars">
		<div class="star"></div>
		<div class="star"></div>
		<div class="star"></div>
		<div class="star"></div>
		<div class="star"></div>
	</div>
</div>
<!--====== 404 Area End ======-->

@endsection