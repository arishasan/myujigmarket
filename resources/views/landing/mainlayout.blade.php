<!DOCTYPE html>
<html lang="id">

{{-- HEAD --}}
@include('landing.parts.head')
{{-- END OF HEAD --}}
<body class="js">
	
	<!-- Preloader -->
	{{-- <div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div> --}}
	<!-- End Preloader -->
	
	
	<!-- Header -->
	@include('landing.parts.header')
	<!--/ End Header -->
	
	{{-- CONTENT --}}
    @yield('content')
    {{-- END OF CONTENT --}}
	
	<!-- Start Footer Area -->
	@include('landing.parts.footer')
	<!-- /End Footer Area -->
 
	<!-- SCRIPT -->
    @include('landing.parts.script')
    @yield('scriptplus')
    {{-- END OF SCRIPT --}}
</body>
</html>