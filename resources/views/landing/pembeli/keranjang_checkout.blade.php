@extends('landing.mainlayout')

@section('content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="#">Customer<i class="ti-arrow-right"></i></a></li>
                        <li><a href="#">Keranjang Belanja<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">Checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<div class="shopping-cart section">
    <div class="container">

        @include('admin.parts.feedback')

        <div class="card">
            <div class="card-body">
                
                <div class="row">
                    <div class="col-lg">
                        <div id="holder_alamat">
                            <b>{{ $alamat_utama->label ?? 'Silahkan pilih alamat terlebih dahulu' }}</b><br/>
                            <small>{{ $alamat_utama->alamat ?? '-' }}</small><br/>
                            <small><b>Penerima:</b> {{ $alamat_utama->penerima }}</small> <br/>
                            <small><b>No. HP:</b> {{ $alamat_utama->no_hp ?? '-' }}</small>
                            <br/>
                            <small>
                                <b>Provinsi: </b> {{ @App\Models\HelperModel::getAlamat($alamat_utama->provinsi, 'prov') }}, <b>Kota: </b> {{ @App\Models\HelperModel::getAlamat($alamat_utama->kota, 'kota') }}, <b>Kecamatan: </b> {{ @App\Models\HelperModel::getAlamat($alamat_utama->kecamatan, 'kec') }}, <b>Kode Pos: </b>{{ @$alamat_utama->kode_pos }}
                            </small>
                        </div>
                    </div>
                    <div class="col-lg-3 text-right">
                        {{-- <button type="button" class="form-control btn-outline-primary"><i class="fa fa-map"></i> Ubah Alamat</button> --}}
                        <label>Ubah Alamat</label>
                        <select id="alamat_pilihan" class="form-control">
                            <option 
                            value=""
                            data-prov=""
                            data-kota=""
                            data-kec="">[ Silahkan Pilih ]</option>

                            @foreach($alamat as $v)
                            <option 
                            value="{{ $v->id }}"
                            data-prov="{{ $v->provinsi }}"
                            data-kota="{{ $v->kota }}"
                            data-kec="{{ $v->kecamatan }}"
                            {{ @$v->id == $alamat_utama->id ? 'selected' : '' }}>{{ $v->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <br/>

        <div class="row">
            
            <div class="col-lg-9">
                <!-- Shopping Summery -->
                <table class="table shopping-summery">
                    <thead>
                        <tr class="main-hading">
                            <th></th>
                            <th>Nama</th>
                            <th class="text-center">Summary</th> 
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            $sum = 0;
                            $sum_berat = 0;
                            $jmlItem = 0;
                        ?>
                        @foreach ($produk as $k => $v)

                        <?php
                            $jmlItem++;
                            $finalPrice = App\Models\HelperModel::getFinalPrice($v->is_promo, $v->harga_jual, $v->value_promo);
                            $kalikan = $finalPrice * $v->qty;
                            $sum += $kalikan;
                            $sum_berat += ($v->berat_gram * $v->qty);
                        ?>

                        <tr>
                            <td class="image" data-title="No"><img src="{{ asset('') }}/{{ $v->image }}" alt="#"></td>
                            <td class="product-des" data-title="Description">
                                <p class="product-name"><a href="javascript:void(0)">{{ $v->nama_produk }}</a></p>
                                <p class="product-des"><small>{{ App\Models\HelperModel::truncate($v->deskripsi, 70) }}</small></p>
                                <hr>
                                <small><b>Catatan:</b></small>
                                <p><small>{{ $v->catatan }}</small></p>
                            </td>
                            <td class="" data-title="Total">
                                Harga : <b>Rp. {{ number_format($finalPrice) }}</b> <br/>
                                QTY : <b>{{ $v->qty }}</b> <br/>
                                Berat Satuan : <b>{{ $v->berat_gram }}</b> g <br/>
                                Total Berat : <b>{{ $v->berat_gram * $v->qty }}</b> g
                                <br/> <br/>
                                <div class="card">
                                    <div class="card-body">
                                        <center>Total <br/> <b>Rp. {{ number_format($kalikan) }}</b></center>
                                    </div>
                                </div>
                            </td>
                        </tr>
                            
                        @endforeach
                        
                    </tbody>
                </table>
                <!--/ End Shopping Summery -->
            </div>

            <div class="col-lg-3">
                <!-- Total Amount -->
                <form method="POST" action="{{ route('exec-checkout') }}" id="form_co">
                    @csrf
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
    
                                    {{-- <br/> --}}

                                    <input type="hidden" id="sum_keranjang" name="sum_keranjang" value="{{ $sum }}">
                                    <input type="hidden" id="id_alamat" name="id_alamat" value="{{ @$alamat_utama->id ?? null}}">

                                    <input type="hidden" id="id_prov" name="id_prov" value="{{ @$alamat_utama->provinsi ?? null}}">
                                    <input type="hidden" id="id_kota" name="id_kota" value="{{ @$alamat_utama->kota ?? null}}">
                                    <input type="hidden" id="id_kec" name="id_kec" value="{{ @$alamat_utama->kecamatan ?? null}}">

                                    <div class="input-group">
                                        <input name="kupon" id="kupon" placeholder="Kode Voucher" class="form-control">
                                        <div class="input-group-append">
                                            <button type="button" id="cek_kupon" class="btn-outline-primary" style="height: 50px; width: 50px" type="button"><i class="fa fa-check"></i></button>
                                        </div>
                                    </div>

                                    <br/>

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                Metode Bayar
                                                <select name="metode_bayar" id="metode_bayar" class="form-control" required>
                                                    <option value="">[ Silahkan Pilih ]</option>
                                                    <option value="TRANSFER">Transfer</option>
                                                    <option value="COD">Cash on Delivery (COD)</option>
                                                    <option value="DATANG_LANGSUNG">Datang Langsung</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="holder_kurir">
                                                Pilih Kurir
                                                <select name="kurir_pilihan" id="kurir_pilihan" class="form-control">
                                                    <option value="">[ Silahkan Pilih ]</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-lg">SubTotal Berat <small>(gram)</small></div>
                                        <div class="col-lg text-right"><b>{{ number_format($sum_berat) }} g</b></div>
                                        <input type="hidden" id="berat_total" name="berat_total" value="{{ $sum_berat }}">
                                    </div>
                                    <hr>

                                    <div>
                                        {{-- <div class="card-body"> --}}
                                            <div class="row">
                                                <div class="col-lg">SubTotal Keranjang <small>(<b>{{ number_format($jmlItem) }}</b>)</small></div>
                                                <div class="col-lg text-right"><b>Rp. {{ number_format($sum) }}</b></div>
                                            </div>
                                            {{-- <hr> --}}
                                            <div class="row">
                                                <div class="col-lg">Diskon Voucher</div>
                                                <div class="col-lg text-right"><b id="diskon_voucher_text">Rp. 0</b></div>
                                                <input type="hidden" name="diskon_voucher" id="diskon_voucher" value="0">
                                            </div>
                                            {{-- <hr> --}}
                                            <div class="row">
                                                <div class="col-lg">Total Ongkir</div>
                                                <div class="col-lg text-right"><b id="total_ongkir_text">Rp. 0</b></div>
                                                <input type="hidden" name="total_ongkir" id="total_ongkir" value="0">
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <b>Total Bayar </b>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <b id="total_bayar_all_text">Rp. 0</b>
                                            <input type="hidden" name="total_bayar_all" id="total_bayar_all" value="0">
                                        </div>
                                    </div>
                                    <br/>
                                    <br/>

                                    <div class="button5">
                                        <button type="button" class="btn text-white form-control" id="exec_simpan">Simpan <i class="fa fa-check"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--/ End Total Amount -->
            </div>

        </div>
    </div>
</div>

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

    var globNominal = 0;
    var globalTypePromo = '';
    var globPromo = 0;
    var globOngkir = 0;
    var globPotongan = 0;

    function calculateTotal(){

        $('#total_bayar_all').val(0);
        $('#total_bayar_all_text').text("Rp. 0");
        globNominal = $('#sum_keranjang').val();
        
        let sum = (parseFloat(globNominal) - parseFloat(globPotongan)) + parseFloat(globOngkir);
        $('#total_bayar_all').val(sum);
        $('#total_bayar_all_text').text("Rp. "+sum.toLocaleString());

    }

    function refreshKurir(){

        let prov = $('#id_prov').val();
        let kota = $('#id_kota').val();
        let kec = $('#id_kec').val();
        let berat = $('#berat_total').val();

        globOngkir = 0;
        $('#total_ongkir').val(0);
        $('#total_ongkir_text').text('Rp. 0');

        if(prov == '' || kota == '' || kec == ''){
            $('#kurir_pilihan').html('');
            $('#kurir_pilihan').append('<option value="">[ Silahkan Pilih ]</option>');
        }else{

            $('#kurir_pilihan').html('');
            $('#kurir_pilihan').append('<option value="">[ Silahkan Pilih ]</option>');

            let link = '{{ url("customer/get_kurir") }}/'+prov+'/'+kota+'/'+kec+'/'+berat;
            $.get(link, function(res){
                
                if(res == 'fail'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Terjadi kesalahan, silahkan ulangi lagi ubah alamat untuk refresh list tarif kurir.',
                    });
                }else{
                    let parse = JSON.parse(res);
                    $.each(parse, function(i, v){
                        $('#kurir_pilihan').append('<option value="'+v.channel.toUpperCase()+';'+v.service+'" data-price="'+v.value+'">'+v.channel.toUpperCase()+' - '+v.service+' - Rp. '+v.value.toLocaleString()+' (Est: '+v.est+' hari)</option>');
                    });
                }

            });

        }

    }

    function callMessage(type, message){
        Swal.fire({
            icon: type,
            title: 'Perhatian!',
            text: message,
        });
    }
    
    $(function(){

        refreshKurir();
        calculateTotal();

        $('#exec_simpan').click(function(){

            let alamat = $('#id_alamat').val();
            if(alamat == '' || alamat == null){
                callMessage('error', 'Anda belum menentukan alamat');
                return;
            }

            let metode = $('#metode_bayar').val();
            if(metode == '' || metode == null){
                callMessage('error', 'Anda belum memilih metode bayar');
                return;
            }

            let kurir = $('#kurir_pilihan').val();

            if(metode == 'DATANG_LANGSUNG'){}else{
                
                if(kurir == '' || kurir == null){
                    callMessage('error', 'Anda belum memilih kurir.');
                    return;
                }

            }

            Swal.fire({
            title: 'Perhatian...',
            text: "Apakah anda sudah yakin?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $('#form_co')[0].submit();

                }
            });


        });

        $("#form_co").on("keypress", function (event) {
            var keyPressed = event.keyCode || event.which;
            if (keyPressed === 13) {
                event.preventDefault();
                return false;
            }
        });

        $('#metode_bayar').change(function(){
            let val = $(this).val();
            if(val == 'DATANG_LANGSUNG'){
                $('#holder_kurir').fadeOut();
                $('#kurir_pilihan').val('').trigger('change');
            }else{
                $('#kurir_pilihan').val('').trigger('change');
                $('#holder_kurir').fadeIn();
            }
        });

        $('#kurir_pilihan').change(function(){
            
            let id = $(this).val();
            if(id == '' || id == null){
                globOngkir = 0;
                $('#total_ongkir').val(0);
                $('#total_ongkir_text').text('Rp. 0');
            }else{

                let selected = $('#kurir_pilihan option:selected').attr('data-price');
                globOngkir = selected;
                $('#total_ongkir').val(selected);
                $('#total_ongkir_text').text('Rp. '+parseFloat(selected).toLocaleString());

            }

            calculateTotal();

        });

        $('#alamat_pilihan').change(function(){

            let id = $(this).val();
            
            let prov = $('#alamat_pilihan option:selected').attr('data-prov');
            let kota = $('#alamat_pilihan option:selected').attr('data-kota');
            let kec = $('#alamat_pilihan option:selected').attr('data-kec');

            $('#id_alamat').val(id);
            $('#id_prov').val(prov);
            $('#id_kota').val(kota);
            $('#id_kec').val(kec);

            if(id == '' || id == null){
                $('#holder_alamat').html('<b>Silahkan pilih alamat terlebih dahulu</b>');
                refreshKurir();
                calculateTotal();
            }else{

                let link = '{{ url("customer/get_alamat") }}/'+id;
                $.get(link, function(res){
                    $('#holder_alamat').html(res);
                    refreshKurir();
                    calculateTotal();
                });

            }

        });

        $('#cek_kupon').click(function(){

            let val = $('#kupon').val();
            let nominal = $('#sum_keranjang').val();

            if(val == '' || val == null){
                globalTypePromo = '';
                globPromo = 0;
                $('#diskon_voucher').val(0);
                $('#diskon_voucher_text').text('Rp. 0');
            }else{

                let link = '{{ url("landing/cek_validasi_kupon") }}/'+val+'/'+nominal;
                $.get(link, function(res){

                    let parse = JSON.parse(res);
                    if(parse.valid){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: parse.message,
                        });

                        globalTypePromo = parse.type_promo;
                        globPromo = parse.value_promo;

                        let tempVoucher = 0;
                        if(globalTypePromo == 'Percentage'){
                            tempVoucher = (parseFloat(nominal) * parseFloat(globPromo)) / 100;
                        }else{
                            tempVoucher = globPromo;
                        }

                        globPotongan = tempVoucher;

                        $('#diskon_voucher').val(tempVoucher);
                        $('#diskon_voucher_text').text("Rp. "+tempVoucher.toLocaleString());

                    }else{
                        globalTypePromo = '';
                        globPromo = 0;
                        $('#diskon_voucher').val(0);
                        $('#diskon_voucher_text').text('Rp. 0');
                        Swal.fire({
                            icon: 'info',
                            title: 'Perhatian...',
                            text: parse.message,
                        });
                        $('#kupon').val('');
                    }

                    calculateTotal();

                });

            }

        });
        
    });
</script>

@endsection