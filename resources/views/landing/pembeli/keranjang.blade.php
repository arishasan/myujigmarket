@extends('landing.mainlayout')

@section('content')

<!-- Breadcrumbs -->
<!-- <div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="#">Customer<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">Keranjang Belanja</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- End Breadcrumbs -->

<div class="shopping-cart section">
    <div class="container">
        @include('admin.parts.feedback')
        <h3>Keranjang Belanja</h3>
        <br/>
        <div class="row">
            <div class="col-12">
                <!-- Shopping Summery -->
                <table class="table shopping-summery">
                    <thead>
                        <tr class="main-hading">
                            <th></th>
                            <th>Nama</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">QTY</th>
                            <th class="text-center">Total</th> 
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            $sum = 0;
                            $jmlItem = 0;
                        ?>

                        @if(count($produk) == 0)

                        <tr>
                            <td colspan="6">
                                <center>
                                    Anda belum menambahkan produk kedalam keranjang belanja.
                                </center>
                            </td>
                        </tr>

                        @else

                            @foreach ($produk as $k => $v)

                            <?php
                                $jmlItem++;
                                $finalPrice = App\Models\HelperModel::getFinalPrice($v->is_promo, $v->harga_jual, $v->value_promo);
                                $kalikan = $finalPrice * $v->qty;
                                $sum += $kalikan;
                            ?>

                            <tr>
                                <td class="image" data-title="No"><img src="{{ asset('') }}/{{ $v->image }}" alt="#" style="width: 100px; height: 100px"></td>
                                <td class="product-des" data-title="Description">
                                    <p class="product-name"><a href="{{ url('landing/produk/detail') }}/{{ $v->slug }}/{{ md5($v->id_produk) }}">{{ $v->nama_produk }}</a></p>
                                    <p class="product-des"><small>{{ App\Models\HelperModel::truncate($v->deskripsi, 70) }}</small></p>
                                    <hr>
                                    <small><b>Catatan:</b></small>
                                    <p><small>{{ $v->catatan }}</small></p>
                                </td>
                                <td class="price" data-title="Price"><span>Rp. {{ number_format($finalPrice) }}</span></td>
                                <td class="qty" data-title="Qty">
                                    <!-- Input Order -->
                                    <div class="input-group">
                                        {{-- <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="qty[{{ $k }}]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div> --}}
                                        <input type="text" name="qty[{{ $k }}]" class="input-number form-control"  data-min="1" data-max="{{ $v->stok }}" value="{{ $v->qty }}" readonly>
                                        <div class="">
                                            <button type="button" class="btn btn-primary btn-number edit_keranjang" data-id="{{ $v->id }}">
                                                <i class="ti-pencil"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--/ End Input Order -->
                                </td>
                                <td class="total-amount" data-title="Total"><span>Rp. {{ number_format($kalikan) }}</span></td>
                                <td class="action" data-title="Remove"><a href="javascript:void(0)" data-id="{{ $v->id }}" class="delete_keranjang"><i class="ti-trash remove-icon"></i></a></td>
                            </tr>
                                
                            @endforeach

                        @endif
                        
                    </tbody>
                </table>
                <!--/ End Shopping Summery -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Total Amount -->
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-7 col-md-5 col-12">
                            <div class="left">
                                {{-- <div class="coupon">
                                    <form action="#" target="_blank">
                                        <input name="Coupon" placeholder="Masukkan Kode Promo">
                                        <button class="btn">Apply</button>
                                    </form>
                                </div>
                                <div class="checkbox">
                                    <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox"> Shipping (+10$)</label>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-7 col-12">
                            <div class="right">
                                {{-- <ul>
                                    <li>SubTotal Keranjang<span>Rp. 0</span></li>
                                    <li>Shipping<span>Free</span></li>
                                    <li>You Save<span>$20.00</span></li>
                                    <li class="last">You Pay<span>$310.00</span></li>
                                </ul> --}}
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                SubTotal <small>(<b>{{ number_format($jmlItem) }}</b>) produk</small>
                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <b>Rp. {{ number_format($sum) }}</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div class="button5">
                                    <center>
                                    <a href="{{ route('do-checkout') }}" class="btn btn-success">Checkout</a>
                                    <a href="{{ url('/') }}" class="btn btn-warning">Lanjut Belanja</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ End Total Amount -->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_product" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
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

    function saveCart(){
        let id = $('#detail_pr').find('#preview_id').val();
        let catatan = $('#detail_pr').find('#preview_catatan').val();
        let qty = $('#detail_pr').find('#preview_qty').val();

        $.ajax({
            url: "{{ url('customer/update_keranjang') }}",
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
                        text: 'Keranjang belanja berhasil diupdate.',
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

        $(document).find('.edit_keranjang').click(function(){

            let id = $(this).attr('data-id');
            let link = '{{ url("landing/get_detail_product_keranjang") }}/'+id;
            $.get(link, function(res){
                $('#detail_pr').html(res);
                $('#modal_product').modal('show');
            });

        });

        $(document).on('click', '.delete_keranjang', function(){

            let id = $(this).attr('data-id');
            Swal.fire({
            title: 'Perhatian...',
            text: "Hapus produk dari keranjang belanja?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                        url: "{{ url('customer/del_keranjang') }}",
                        type: "POST",
                        data: {
                            id: id
                        } ,
                        success: function (res) {

                            if(res == 'del'){

                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Produk berhasil dihapus dari keranjang belanja.',
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
            });

        });
       
    });
</script>

@endsection