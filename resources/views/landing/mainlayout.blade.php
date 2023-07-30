<!DOCTYPE html>
<html lang="id">

{{-- HEAD --}}
@include('landing.parts.head')
{{-- END OF HEAD --}}

<body>

<!-- LOADER -->
<!-- <div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div> -->
<!-- END LOADER -->

<!-- START HEADER -->
@include('landing.parts.header')
<!-- END HEADER -->

<!-- START SECTION BANNER -->
<div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
    <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-ride="carousel">
        <div class="carousel-inner">

            @foreach(App\Models\BannerModel::all() as $b)
            <div class="carousel-item active background_bg" data-img-src="{{ asset('') }}/{{ $b->image }}">
                <div class="banner_slide_content">
                    <div class="container"><!-- STRART CONTAINER -->
                        <div class="row">
                            <div class="col-lg-7 col-9">
                                <div class="banner_content overflow-hidden">
                                </div>
                            </div>
                        </div>
                    </div><!-- END CONTAINER-->
                </div>
            </div>
            @endforeach
            
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"><i class="ion-chevron-left"></i></a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"><i class="ion-chevron-right"></i></a>
    </div>
</div>
<!-- END SECTION BANNER -->

<!-- END MAIN CONTENT -->
<div class="main_content">

@yield('content')

</div>
<!-- END MAIN CONTENT -->

<!-- START FOOTER -->
@include('landing.parts.footer')
<!-- END FOOTER -->

@include('landing.parts.script')
@yield('scriptplus')

</body>
</html>