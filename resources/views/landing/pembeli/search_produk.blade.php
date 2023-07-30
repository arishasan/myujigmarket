@extends('landing.mainlayout')

@section('content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="#">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">Semua Produk</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<section class="product-area shop-sidebar shop section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
                <div class="shop-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget category">
                            <h3 class="title">Categories</h3>
                            <ul class="categor-list scrollable">
                                <li><a href="{{ url('landing/produk') }}/semua" style="{{ $selected_kategori == 'semua' ? 'font-weight: bold; color:orange' : '' }}">Semua</a></li>
                                @foreach($kategori as $v)
                                <li><a href="{{ url('landing/produk') }}/{{ $v->id }}" style="{{ $selected_kategori == $v->id ? 'font-weight: bold; color:orange' : '' }}">{{ $v->nama }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Shop By Price -->
                            <div class="single-widget range">
                                <h3 class="title">Shop by Price</h3>
                                <form method="POST" action="{{ url('landing/produk') }}/{{ $selected_kategori }}">
                                    <input type="hidden" name="cari" value="{{ $search_name }}">
                                    <input type="hidden" name="kondisi" value="{{ $kondisi }}">
                                    <input type="hidden" name="limit" value="{{ $limit }}">
                                    <input type="hidden" name="sort" value="{{ $sort }}">
                                    @csrf
                                    <ul class="check-box-list">
                                        <li>
                                            <label class="checkbox-inline" for="1"><input name="range_harga" value="100" id="1" type="radio" {{ $range_harga == "100" ? 'checked' : '' }}><small>Rp. 0 - Rp. 100.000<span class="count">({{ App\Models\HelperModel::getCountProdukByKategoriNama((@$selected_kategori ?? 'semua'), (@$search_name ?? null), 100, $kondisi) }})</span></small></label>
                                        </li>
                                        <li>
                                            <label class="checkbox-inline" for="2"><input name="range_harga" value="200" id="2" type="radio" {{ $range_harga == "200" ? 'checked' : '' }}><small>Rp. 100.000 - Rp. 200.000<span class="count">({{ App\Models\HelperModel::getCountProdukByKategoriNama((@$selected_kategori ?? 'semua'), (@$search_name ?? null), 200, $kondisi) }})</span></small></label>
                                        </li>
                                        <li>
                                            <label class="checkbox-inline" for="3"><input name="range_harga" value="500" id="3" type="radio" {{ $range_harga == "500" ? 'checked' : '' }}><small>Rp. 200.000 - Rp. 500.000<span class="count">({{ App\Models\HelperModel::getCountProdukByKategoriNama((@$selected_kategori ?? 'semua'), (@$search_name ?? null), 500, $kondisi) }})</span></small></label>
                                        </li>
                                        <li>
                                            <label class="checkbox-inline" for="4"><input name="range_harga" value="1000" id="4" type="radio" {{ $range_harga == "1000" ? 'checked' : '' }}><small>Rp. 500.000 - Rp. 1.000.000<span class="count">({{ App\Models\HelperModel::getCountProdukByKategoriNama((@$selected_kategori ?? 'semua'), (@$search_name ?? null), 1000, $kondisi) }})</span></small></label>
                                        </li>
                                        <li>
                                            <label class="checkbox-inline" for="5"><input name="range_harga" value="-1" id="5" type="radio" {{ $range_harga == "-1" ? 'checked' : '' }}><small>> Rp. 1.000.000<span class="count">({{ App\Models\HelperModel::getCountProdukByKategoriNama((@$selected_kategori ?? 'semua'), (@$search_name ?? null), -1, $kondisi) }})</span></small></label>
                                        </li>
                                    </ul>

                                    <br/>
                                    
                                    <button class="btn form-control">Terapkan</button>
                                </form>
                            </div>
                            <!--/ End Shop By Price -->
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-12">
                <div class="row">
                    <div class="col-12">
                        @if($search_name != null)
                        <label>Menampilkan produk dengan keyword <b>{{ $search_name }}</b></label>
                        @endif
                        <!-- Shop Top -->
                        <div class="shop-top">
                            <div class="shop-shorter">
                                <form method="POST" action="{{ url('landing/produk') }}/{{ $selected_kategori }}" id="form_top">
                                    @csrf
                                    <input type="hidden" name="cari" value="{{ $search_name }}">
                                    <input type="hidden" name="range_harga" value="{{ $range_harga }}">
                                    <div class="single-shorter">
                                        <label>Kondisi Barang :</label>
                                        <select class="selecttop" name="kondisi">
                                            <option value="semua">Semua</option>
                                            <option value="kondisi_baru" {{ $kondisi == 'kondisi_baru' ? 'selected' : '' }}>Baru</option>
                                            <option value="kondisi_lama" {{ $kondisi == 'kondisi_lama' ? 'selected' : '' }}>Bekas/Second</option>
                                        </select>
                                    </div>
                                    <div class="single-shorter">
                                        <label>Tampilkan :</label>
                                        <select class="selecttop" name="limit">
                                            <option>6</option>
                                            <option {{ $limit == 9 ? 'selected' : '' }}>9</option>
                                            <option {{ $limit == 12 ? 'selected' : '' }}>12</option>
                                            <option {{ $limit == 15 ? 'selected' : '' }}>15</option>
                                        </select>
                                    </div>
                                    <div class="single-shorter">
                                        <label>Urut Berdasarkan :</label>
                                        <select class="selecttop" name="sort">
                                            <option value="nama">Nama</option>
                                            <option value="low_price" {{ $sort == 'low_price' ? 'selected' : ''}}>Harga Termurah</option>
                                            <option value="high_price" {{ $sort == 'high_price' ? 'selected' : ''}}>Harga Termahal</option>
                                            <option value="new" {{ $sort == 'new' ? 'selected' : ''}}>Barang Terbaru</option>
                                            <option value="old" {{ $sort == 'old' ? 'selected' : ''}}>Barang Terlama</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            {{-- <ul class="view-mode">
                                <li style="color: orange">Menampilkan Halaman <b>1</b> dari <b>5</b></li>
                            </ul> --}}
                        </div>
                        <!--/ End Shop Top -->
                    </div>
                </div>
                <div class="row">
                    
                    @foreach($produk as $np => $vnp)
                        <div class="col-lg-4 col-md-6 col-12">
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

                <hr>
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        {{ $produk->appends(Request::except('page'))->links('vendor.pagination.custom') }}
                    </div>
                    <div class="col-lg-6 text-right">
                        <b style="color:orange">Halaman</b> : <b>{{ $produk->currentPage() }}</b> dari <b>{{ $produk->lastPage() }}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

        $('select').niceSelect();

        $(document).on('change', '.selecttop', function(){
            $('#form_top').submit();
        });
       
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