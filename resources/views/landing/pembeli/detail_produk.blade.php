@extends('landing.mainlayout')

@section('content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="#">Produk<i class="ti-arrow-right"></i></a></li>
                        <li><a href="#">Detail<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">{{ $produk->nama_produk }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<section class="product-area shop-sidebar shop section">
    <div class="container">
        
        <div class="row no-gutters">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <!-- Product Slider -->
                    <div class="product-gallery">
                        <div class="quickview-slider-active">
                            <div class="single-slider">
                                <img src="{{ asset('') }}/{{ $produk->image }}" alt="#">
                            </div>
                            <div class="single-slider">
                                <img src="{{ asset('') }}/{{ $produk->image2 }}" alt="#">
                            </div>
                            <div class="single-slider">
                                <img src="{{ asset('') }}/{{ $produk->image3 }}" alt="#">
                            </div>
                        </div>
                    </div>
                <!-- End Product slider -->
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" id="preview_id" name="preview_id" value="{{ $produk->id }}">
                <div class="quickview-content">
                    <h2 style="color: #F7941D">{{ $produk->nama_produk }}</h2>
                    <div class="quickview-ratting-review">
                        <div class="quickview-ratting-wrap">
                            <div class="quickview-ratting">
                                {!! App\Models\HelperModel::getStars(App\Models\HelperModel::getReviewProduk('rate', $produk->id)) !!}
                                {{-- <i class="yellow fa fa-star"></i> --}}
                            </div>
                            <a href="#"> ({{ App\Models\HelperModel::getReviewProduk('count', $produk->id) }} customer review)</a>
                        </div>
                        <div class="quickview-stock">
                            <span>{!! $produk->stok <= 0 ? '<i class="fa fa-times text-danger"></i> Stok Habis' : '<i class="fa fa-check-circle-o"></i> Stok Tersedia' !!} <b>({{ number_format($produk->stok) }})</b></span>
                        </div>
                    </div>
                    {{ $produk->nama_kategori }}
                    @if($produk->is_promo == 1)
                    <?php
                        $potongan = ($produk->harga_jual * $produk->value_promo) / 100;
                    ?>
                    <h3>Rp. {{ number_format($produk->harga_jual - $potongan) }} <small style="color:grey; text-decoration: line-through">Rp. {{ number_format($produk->harga_jual) }}</small></h3>
                    @else
                    <h3>Rp. {{ number_format($produk->harga_jual) }}</h3>
                    @endif
                    <div class="quickview-peragraph">
                        <p>{{ $produk->deskripsi }}</p>
                    </div>
                    <br/>
                    Kondisi Barang : <b>{{ $produk->is_new == 1 ? 'Baru' : 'Bekas' }}</b><br/>
                    Berat Barang (gram) : <b>{{ number_format($produk->berat_gram) }}g</b>
                    <div class="size">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <h5 class="title">Catatan</h5>
                                <textarea name="catatan" id="preview_catatan" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="quantity">
                        <!-- Input Order -->
                        <div class="input-group">
                            <div class="button minus">
                                <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="qty">
                                    <i class="ti-minus"></i>
                                </button>
                            </div>
                            <input type="text" name="qty" id="preview_qty" class="input-number" data-min="1" data-max="{{ $produk->stok }}" value="1">
                            <div class="button plus">
                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="qty">
                                    <i class="ti-plus"></i>
                                </button>
                            </div>
                        </div>
                        <!--/ End Input Order -->
                    </div>
                    <div class="add-to-cart">
                        <a href="javascript:void(0)" class="btn" onclick="addCart()">Add to cart</a>
                        <a href="javascript:void(0)" class="btn min product_wishlist" data-id="{{ $produk->id }}" ><i class="ti-heart {{ App\Models\HelperModel::inWishlist($produk->id) ? 'text-danger' : '' }}"></i></a>
                    </div>
                    <div class="default-social">
                        <h4 class="share-now">Share:</h4>
                        <ul>
                            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                    <br/>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-6">
                                    Review Pembeli
                                </div>
                                <div class="col-lg-6 text-right">
                                    <b>{{ App\Models\HelperModel::getReviewProduk('rate', $produk->id) }}</b>/5
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="overflow-y: scroll; height:200px;">
                        
                            @foreach(App\Models\HelperModel::getReviewProduk('person', $produk->id) as $k => $v)
                            <div class="row">
                                <div class="col-lg-2">
                                    <img src="{{ asset('assets/avatar.png') }}" alt="Avatar" class="avatar">
                                </div>
                                <div class="col-lg-6">
                                    <b>{{ @App\Models\UserModel::find($v->id_user)->name }}</b>
                                    <p><small>{{ $v->catatan }}</small></p>
                                </div>
                                <div class="col-lg-4 text-right">
                                    {!! App\Models\HelperModel::getStars($v->rate) !!} <br/>
                                    <small>{{ date('d/M/Y, H:i:s', strtotime($v->created_at)) }}</small>
                                </div>
                            </div>
                            <hr>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@section('scriptplus')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function addCart(){
        let id = $(document).find('#preview_id').val();
        let catatan = $(document).find('#preview_catatan').val();
        let qty = $(document).find('#preview_qty').val();

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