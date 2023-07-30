<head>
	<!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- Title Tag  -->
    <title>Nusantara E-Commerce</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="{{ asset('landing') }}/images/favicon.png">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
	<!-- StyleSheet -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="{{ asset('landing') }}/css/bootstrap.css">
	<!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('landing') }}/css/magnific-popup.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('landing') }}/css/font-awesome.css">
	<!-- Fancybox -->
	<link rel="stylesheet" href="{{ asset('landing') }}/css/jquery.fancybox.min.css">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="{{ asset('landing') }}/css/themify-icons.css">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="{{ asset('landing') }}/css/niceselect.css">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('landing') }}/css/animate.css">
	<!-- Flex Slider CSS -->
    <link rel="stylesheet" href="{{ asset('landing') }}/css/flex-slider.min.css">
	<!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('landing') }}/css/owl-carousel.css">
	<!-- Slicknav -->
    <link rel="stylesheet" href="{{ asset('landing') }}/css/slicknav.min.css">

	<link rel="stylesheet" href="{{ asset('landing') }}/css/jquery-ui.css">
	
	<!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="{{ asset('landing') }}/css/reset.css">
	<link rel="stylesheet" href="{{ asset('landing') }}/style.css">
    <link rel="stylesheet" href="{{ asset('landing') }}/css/responsive.css">
	
	@yield('style')

	<style>
		.avatar {
			vertical-align: middle;
			width: 50px;
			height: 50px;
			border-radius: 50%;
		}

		.scrollable{
			overflow-y: scroll; height:200px;
		}
		
		
	</style>
	
</head>