@extends('landing.mainlayout')

@section('content')
<!-- Slider Area -->
<section class="hero-slider">
    <!-- Single Slider -->
    <div class="product-gallery">
        @if(count($banner) > 1)
        <div class="quickview-slider-active">
        @endif
            @foreach($banner as $b)
            <div class="single-slider">
                <img src="{{ asset('') }}/{{ $b->image }}" alt="#" style="width: 100%; height: 100%">
            </div>
            @endforeach
        @if(count($banner) > 1)
        </div>
        @endif
    </div>
    <!--/ End Single Slider -->
</section>
<!--/ End Slider Area -->

<!-- Start Small Banner  -->
{{-- <section class="small-banner section">
    <div class="container-fluid">
        <div class="row">
            <!-- Single Banner  -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="single-banner">
                    <img src="https://via.placeholder.com/600x370" alt="#">
                    <div class="content">
                        <p>Man's Collectons</p>
                        <h3>Summer travel <br> collection</h3>
                        <a href="#">Discover Now</a>
                    </div>
                </div>
            </div>
            <!-- /End Single Banner  -->
            <!-- Single Banner  -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="single-banner">
                    <img src="https://via.placeholder.com/600x370" alt="#">
                    <div class="content">
                        <p>Bag Collectons</p>
                        <h3>Awesome Bag <br> 2020</h3>
                        <a href="#">Shop Now</a>
                    </div>
                </div>
            </div>
            <!-- /End Single Banner  -->
            <!-- Single Banner  -->
            <div class="col-lg-4 col-12">
                <div class="single-banner tab-height">
                    <img src="https://via.placeholder.com/600x370" alt="#">
                    <div class="content">
                        <p>Flash Sale</p>
                        <h3>Mid Season <br> Up to <span>40%</span> Off</h3>
                        <a href="#">Discover Now</a>
                    </div>
                </div>
            </div>
            <!-- /End Single Banner  -->
        </div>
    </div>
</section> --}}
<!-- End Small Banner -->

<!-- Start Product Area -->
<div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Produk Baru Bulan Ini</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="tab-single">
                            <div class="row">
                                
                                @foreach($new_produk as $np => $vnp)
                                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="{{ url('landing/produk/detail') }}/{{ $vnp->slug }}/{{ md5($vnp->id) }}">
                                                <img class="default-img" src="{{ asset('') }}/{{ $vnp->image }}" alt="#">
                                                <img class="hover-img" src="{{ asset('') }}/{{ $vnp->image }}" alt="#">
                                                @if($vnp->stok <= 0)
                                                <span class="out-of-stock">Habis</span>
                                                @else
                                                
                                                    @if($vnp->is_promo == 1)
                                                    <span class="price-dec">Potongan {{ $vnp->value_promo }}%</span>
                                                    @endif

                                                @endif
                                            </a>
                                            <div class="button-head">
                                                <div class="product-action">
                                                    <a title="Wishlist" href="javascript:void(0)" data-id="{{ $vnp->id }}" class="product_wishlist"><i class=" ti-heart {{ App\Models\HelperModel::inWishlist($vnp->id) ? 'text-danger' : '' }} "></i><span>Add to Wishlist</span></a>
                                                </div>
                                                <div class="product-action-2">
                                                    <a title="Add to cart" class="product_detail" data-id="{{ $vnp->id }}" href="javascript:void(0)">Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <small>{{ $vnp->nama_kategori }}</small>
                                            <h3><a href="{{ url('landing/produk/detail') }}/{{ $vnp->slug }}/{{ md5($vnp->id) }}">{{ $vnp->nama_produk }}</a></h3>
                                            {!! App\Models\HelperModel::getStars(App\Models\HelperModel::getReviewProduk('rate', $vnp->id)) !!}
                                            <div class="product-price">
                                                @if($vnp->is_promo == 1)
                                                <?php
                                                    $potongan = ($vnp->harga_jual * $vnp->value_promo) / 100;
                                                ?>
                                                <span class="old">Rp. {{ number_format($vnp->harga_jual) }}</span>
                                                <span>Rp. {{ number_format($vnp->harga_jual - $potongan) }}</span>
                                                @else
                                                <span>Rp. {{ number_format($vnp->harga_jual) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- End Product Area -->

<!-- Start Midium Banner  -->
@if(count($promo) > 0 || count($dilihat) > 0)

<section class="midium-banner">
    <div class="container">
        <div class="row">
            <!-- Single Banner  -->
            @if(count($promo) > 0)
            <div class="col-lg-{{ count($dilihat) == 0 ? 12 : 6 }} col-md-6 col-12">
                <div class="single-banner">
                    <img src="{{ asset('') }}/{{ $promo[0]->image }}" alt="#">
                    <div class="content">
                        <p>Promo Paling Tinggi!</p>
                        <h3>{{ App\Models\HelperModel::truncate($promo[0]->nama_produk, 30) }} <br>Up to<span> {{ $promo[0]->value_promo }}%</span></h3>
                        <a href="{{ url('landing/produk/detail') }}/{{ $promo[0]->slug }}/{{ md5($promo[0]->id) }}">Shop Now</a>
                    </div>
                </div>
            </div>
            @endif
            <!-- /End Single Banner  -->
            <!-- Single Banner  -->
            @if(count($dilihat) > 0)
            <div class="col-lg-{{ count($promo) == 0 ? 12 : 6 }} col-md-6 col-12">
                <div class="single-banner">
                    <img src="{{ asset('') }}/{{ $dilihat[0]->image }}" alt="#">
                    <div class="content">
                        <p>Paling Sering Dilihat!</p>
                        <h3>{{ App\Models\HelperModel::truncate($dilihat[0]->nama_produk, 30) }} <br>Dilihat<span> {{ $dilihat[0]->dilihat }}x</span></h3>
                        <a href="{{ url('landing/produk/detail') }}/{{ $dilihat[0]->slug }}/{{ md5($dilihat[0]->id) }}">Shop Now</a>
                    </div>
                </div>
            </div>
            @endif
            <!-- /End Single Banner  -->
        </div>
    </div>
</section>

@endif
<!-- End Midium Banner -->

<!-- Start Most Popular -->
<div class="product-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Rekomendasi</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    @foreach($rekomendasi as $r => $rnp)

                    <!-- Start Single Product -->
                    <div class="single-product">
                        <div class="product-img">
                            <a href="{{ url('landing/produk/detail') }}/{{ $rnp->slug }}/{{ md5($rnp->id) }}">
                                <img class="default-img" src="{{ asset('') }}/{{ $rnp->image }}" alt="#">
                                <img class="hover-img" src="{{ asset('') }}/{{ $rnp->image }}" alt="#">
                                @if($rnp->stok <= 0)
                                <span class="out-of-stock">Habis</span>
                                @else
                                
                                    @if($rnp->is_promo == 1)
                                    <span class="price-dec">Potongan {{ $rnp->value_promo }}%</span>
                                    @endif

                                @endif
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a title="Wishlist" href="javascript:void(0)" data-id="{{ $rnp->id }}" class="product_wishlist"><i class=" ti-heart {{ App\Models\HelperModel::inWishlist($rnp->id) ? 'text-danger' : '' }} "></i><span>Add to Wishlist</span></a>
                                </div>
                                <div class="product-action-2">
                                    <a title="Add to cart" class="product_detail" data-id="{{ $rnp->id }}" href="javascript:void(0)">Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <small>{{ $rnp->nama_kategori }}</small>
                            <h3><a href="{{ url('landing/produk/detail') }}/{{ $rnp->slug }}/{{ md5($rnp->id) }}">{{ $rnp->nama_produk }}</a></h3>
                            {!! App\Models\HelperModel::getStars(App\Models\HelperModel::getReviewProduk('rate', $rnp->id)) !!}
                            <div class="product-price">
                                @if($rnp->is_promo == 1)
                                <?php
                                    $potongan = ($rnp->harga_jual * $rnp->value_promo) / 100;
                                ?>
                                <span class="old">Rp. {{ number_format($rnp->harga_jual) }}</span>
                                <span>Rp. {{ number_format($rnp->harga_jual - $potongan) }}</span>
                                @else
                                <span>Rp. {{ number_format($rnp->harga_jual) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                    
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->

<!-- Start Shop Services Area -->
<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Gratis Ongkir</h4>
                    <p>Minimal pembelian di atas Rp. 100.000.</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Garansi Pengembalian</h4>
                    <p>Garansi 30 hari dari pembelian.</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Secure Payment</h4>
                    <p>100% pembayaran aman.</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Harga Terbaik</h4>
                    <p>Jaminan harga terbaik dan kompetitif.</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services Area -->


<!-- Modal -->
<div class="modal fade" id="modal_product" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div id="detail_pr"></div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->
@endsection

@section('scriptplus')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function addCart(){
        let id = $('#detail_pr').find('#preview_id').val();
        let catatan = $('#detail_pr').find('#preview_catatan').val();
        let qty = $('#detail_pr').find('#preview_qty').val();

        $.ajax({
            url: "{{ url('customer/add_keranjang') }}",
            type: "POST",
            data: {
                id: id,
                catatan: catatan,
                qty: qty
            } ,
            success: function (res) {

                if(res == 'login'){

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Anda harus login terlebih dahulu sebelum menambahkan ke keranjang.',
                        footer: '<a href="{{ url("customer/login") }}" class="text-info">Login Sekarang</a>'
                    });

                }else if(res == 'yes'){

                    Swal.fire({
                        title: 'Success!',
                        icon: 'success',
                        text: 'Produk berhasil ditambahkan ke keranjang belanja',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        location.reload();
                    });

                }else{

                    Swal.fire({
                        icon: 'info',
                        title: 'Perhatian...',
                        text: res,
                    });

                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            }
        });
    }
    
    $(function(){
       
        $(document).find('.product_detail').click(function(){

            let id = $(this).attr('data-id');
            let link = '{{ url("landing/get_detail_product") }}/'+id;
            $.get(link, function(res){
                $('#preview_qty').val('1');
                $('#preview_catatan').val('');
                $('#detail_pr').html(res);
                $('#modal_product').modal('show');
            });

        });

        $(document).find('.product_wishlist').click(function(){

            let id = $(this).attr('data-id');
            let heart = $(this).find('.ti-heart');

            // console.log(heart.attr('class'));

            Swal.fire({
            title: 'Perhatian...',
            text: heart.hasClass('text-danger') ? "Hapus produk dari wishlist?" : "Tambahkan produk kedalam wishlist?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                        url: "{{ url('customer/add_wishlist') }}",
                        type: "POST",
                        data: {
                            id: id
                        } ,
                        success: function (res) {

                            if(res == 'login'){

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Anda harus login terlebih dahulu sebelum menambahkan ke keranjang.',
                                    footer: '<a href="{{ url("customer/login") }}" class="text-info">Login Sekarang</a>'
                                });

                            }else if(res == 'yes'){

                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Produk berhasil ditambahkan kedalam wishlist.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    heart.addClass('text-danger');
                                });

                            }else if(res == 'del'){

                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Produk berhasil dihapus dari wishlist.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    heart.removeClass('text-danger');
                                });

                            }else{

                                Swal.fire({
                                    icon: 'info',
                                    title: 'Perhatian...',
                                    text: res,
                                });

                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        }
                    });

                }
            });

        });
        
    });
</script>

@endsection