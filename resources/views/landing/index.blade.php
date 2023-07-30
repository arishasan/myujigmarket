@extends('landing.mainlayout')

@section('content')

<!-- START SECTION SHOP -->
<div class="section small_pt pb_70">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
            	<div class="heading_s1 text-center">
                	<h2>Our Products</h2>
                </div>
            </div>
		</div>
        <div class="row shop_container">
            @foreach($new_produk as $np => $vnp)
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product">
                    @if($vnp->stok <= 0)
                    <span class="pr_flash bg-danger">Out of Stock</span>
                    @endif
                    <div class="product_img">
                        <a href="{{ url('landing/produk/detail') }}/{{ $vnp->slug }}/{{ md5($vnp->id) }}">
                            <img src="{{ asset('') }}/{{ $vnp->image }}" alt="product_img1">
                        </a>
                        <!-- <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div> -->
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="{{ url('landing/produk/detail') }}/{{ $vnp->slug }}/{{ md5($vnp->id) }}">{{ $vnp->nama_produk }}</a></h6>
                        <div class="product_price">
                            
                            @if($vnp->is_promo == 1)
                            <?php
                                $potongan = ($vnp->harga_jual * $vnp->value_promo) / 100;
                            ?>

                            <span class="price">Rp. {{ number_format($vnp->harga_jual - $potongan) }}</span>
                            <del>Rp. {{ number_format($vnp->harga_jual) }}</del>
                            <div class="on_sale">
                                <span>{{ $vnp->value_promo }}% Off</span>
                            </div>

                            @else
                            <span class="price">Rp. {{ number_format($vnp->harga_jual) }}</span>
                            @endif
                        </div>
                        <div class="rating_wrap">
                            {!! App\Models\HelperModel::getStars(App\Models\HelperModel::getReviewProduk('rate', $vnp->id)) !!}
                        </div>
                        <div class="pr_desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                        </div>
                        <!-- <div class="pr_switch_wrap">
                            <div class="product_color_switch">
                                <span class="active" data-color="#87554B"></span>
                                <span data-color="#333333"></span>
                                <span data-color="#DA323F"></span>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            @endforeach
            
            
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->


<!-- START SECTION TESTIMONIAL -->
<div class="section bg_redon">
	<div class="container">
    	<div class="row justify-content-center">
        	<div class="col-md-6">
            	<div class="heading_s1 text-center">
                	<h2>Our Client Say!</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9">
            	<div class="testimonial_wrap testimonial_style1 carousel_slider owl-carousel owl-theme nav_style2" data-nav="true" data-dots="false" data-center="true" data-loop="true" data-autoplay="true" data-items='1'>
                	<div class="testimonial_box">
                    	<div class="testimonial_desc">
                        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam amet animi blanditiis consequatur debitis dicta distinctio, enim error eum iste libero modi nam natus perferendis possimus quasi sint sit tempora voluptatem.</p>
                        </div>
                        <div class="author_wrap">
                            <div class="author_img">
                                <img src="{{ asset('new') }}/images/user_img1.jpg" alt="user_img1" />
                            </div>
                            <div class="author_name">
                                <h6>Lissa Castro</h6>
                                <span>Designer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial_box">
                    	<div class="testimonial_desc">
                        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam amet animi blanditiis consequatur debitis dicta distinctio, enim error eum iste libero modi nam natus perferendis possimus quasi sint sit tempora voluptatem.</p>
                        </div>
                        <div class="author_wrap">
                            <div class="author_img">
                                <img src="{{ asset('new') }}/images/user_img2.jpg" alt="user_img2" />
                            </div>
                            <div class="author_name">
                                <h6>Alden Smith</h6>
                                <span>Designer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial_box">
                    	<div class="testimonial_desc">
                        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam amet animi blanditiis consequatur debitis dicta distinctio, enim error eum iste libero modi nam natus perferendis possimus quasi sint sit tempora voluptatem.</p>
                        </div>
                        <div class="author_wrap">
                            <div class="author_img">
                                <img src="{{ asset('new') }}/images/user_img3.jpg" alt="user_img3" />
                            </div>
                            <div class="author_name">
                                <h6>Daisy Lana</h6>
                                <span>Designer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial_box">
                    	<div class="testimonial_desc">
                        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam amet animi blanditiis consequatur debitis dicta distinctio, enim error eum iste libero modi nam natus perferendis possimus quasi sint sit tempora voluptatem.</p>
                        </div>
                        <div class="author_wrap">
                            <div class="author_img">
                                <img src="{{ asset('new') }}/images/user_img4.jpg" alt="user_img4" />
                            </div>
                            <div class="author_name">
                                <h6>John Becker</h6>
                                <span>Designer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION TESTIMONIAL -->

<!-- START SECTION SHOP INFO -->
<div class="section pb_70">
    	<div class="container">
            <div class="row no-gutters">
                <div class="col-lg-4">	
                    <div class="icon_box icon_box_style1">
                        <div class="icon">
                            <i class="flaticon-shipped"></i>
                        </div>
                        <div class="icon_box_content">
                            <h5>Free Delivery</h5>
                            <p>If you are going to use of Lorem, you need to be sure there anything</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">	
                    <div class="icon_box icon_box_style1">
                        <div class="icon">
                            <i class="flaticon-money-back"></i>
                        </div>
                        <div class="icon_box_content">
                            <h5>30 Day Return</h5>
                            <p>If you are going to use of Lorem, you need to be sure there anything</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">	
                    <div class="icon_box icon_box_style1">
                        <div class="icon">
                            <i class="flaticon-support"></i>
                        </div>
                        <div class="icon_box_content">
                            <h5>27/4 Support</h5>
                            <p>If you are going to use of Lorem, you need to be sure there anything</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- END SECTION SHOP INFO -->

<!-- START SECTION SUBSCRIBE NEWSLETTER -->
<div class="section bg_default small_pt small_pb">
	<div class="container">	
    	<div class="row align-items-center">	
            <div class="col-md-6">
                <div class="heading_s1 mb-md-0 heading_light">
                    <h3>Subscribe Our Newsletter</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="newsletter_form">
                    <form>
                        <input type="text" required="" class="form-control rounded-0" placeholder="Enter Email Address">
                        <button type="submit" class="btn btn-dark rounded-0" name="submit" value="Submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- START SECTION SUBSCRIBE NEWSLETTER -->


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