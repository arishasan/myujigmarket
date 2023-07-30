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
                        <li class="active"><a href="#">Wishlist</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- End Breadcrumbs -->

<div class="shopping-cart section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Shopping Summery -->
                <table class="table shopping-summery">
                    <thead>
                        <tr class="main-hading">
                            <th></th>
                            <th>Nama</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(count($produk) == 0)

                        <tr>
                            <td colspan="4">
                                <center>
                                    Anda belum menambahkan produk kedalam wishlist.
                                </center>
                            </td>
                        </tr>

                        @else

                            <?php
                                $sum = 0;
                            ?>
                            @foreach ($produk as $k => $v)

                            <?php
                                $finalPrice = App\Models\HelperModel::getFinalPrice($v->is_promo, $v->harga_jual, $v->value_promo);
                            ?>

                            <tr>
                                <td class="image" data-title="No"><img src="{{ asset('') }}/{{ $v->image }}" alt="#" style="width: 100px; height: 100px"></td>
                                <td class="product-des" data-title="Description">
                                    <p class="product-name"><a href="{{ url('landing/produk/detail') }}/{{ $v->slug }}/{{ md5($v->id_produk) }}">{{ $v->nama_produk }}</a></p>
                                    <p class="product-des"><small>{{ App\Models\HelperModel::truncate($v->deskripsi, 70) }}</small></p>
                                </td>
                                <td class="price" data-title="Price"><span>Rp. {{ number_format($finalPrice) }}</span></td>
                                <td class="action" data-title="Remove"><a href="javascript:void(0)" data-id="{{ $v->id }}" class="delete_wishlist"><i class="ti-trash remove-icon"></i></a></td>
                            </tr>
                                
                            @endforeach

                        @endif
                        
                    </tbody>
                </table>
                <!--/ End Shopping Summery -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('scriptplus')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(function(){

        $(document).on('click', '.delete_wishlist', function(){

            let id = $(this).attr('data-id');
            Swal.fire({
            title: 'Perhatian...',
            text: "Hapus produk dari wishlist?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                        url: "{{ url('customer/del_wishlist') }}",
                        type: "POST",
                        data: {
                            id: id
                        } ,
                        success: function (res) {

                            if(res == 'del'){

                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Produk berhasil dihapus dari wishlist.',
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