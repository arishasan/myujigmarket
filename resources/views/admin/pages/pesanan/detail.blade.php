@extends('admin.mainlayout')



@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              Detail Pesanan
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Data</a></li>
              <li class="breadcrumb-item"><a href="#">Pesanan</a></li>
              <li class="breadcrumb-item"><a href="#">Detail</a></li>
              <li class="breadcrumb-item active">{{ $transaksi->kode_transaksi }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        @include('admin.parts.feedback')

        @if($transaksi->metode_bayar != 'DATANG_LANGSUNG')
        <div class="card">
            <div class="card-body">
                
                <div class="row">
                    <div class="col-lg">
                        <div id="holder_alamat">
                            <b>Alamat Pengiriman</b><br/>
                            <small>{{ $transaksi->alamat_lengkap ?? '-' }}</small><br/>
                            <small><b>Penerima:</b> {{ $transaksi->penerima }}</small> <br/>
                            <small><b>No. HP:</b> {{ $transaksi->no_hp ?? '-' }}</small>
                            <br/>
                            <small>
                                <b>Provinsi: </b> {{ @App\Models\HelperModel::getAlamat($transaksi->provinsi, 'prov') }}, <b>Kota: </b> {{ @App\Models\HelperModel::getAlamat($transaksi->kota, 'kota') }}, <b>Kecamatan: </b> {{ @App\Models\HelperModel::getAlamat($transaksi->kecamatan, 'kec') }}, <b>Kode Pos: </b>{{ @$transaksi->kode_pos }}
                            </small>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <br/>
        @endif

        <div class="row">
            
            <div class="col-lg-9">
                <!-- Shopping Summery -->
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="table" style="width: 100%">
                                <thead>
                                    <tr class="main-hading">
                                        <th width="15%"></th>
                                        <th>Nama</th>
                                        <th class="text-center">Summary</th> 
                                    </tr>
                                </thead>
                                <tbody>
            
                                    <?php
                                        $jmlItem = 0;
                                    ?>
                                    @foreach ($produk as $k => $v)
            
                                    <?php
                                        $jmlItem++;
                                    ?>
            
                                    <tr>
                                        <td class="image" data-title="No"><img src="{{ asset('') }}/{{ $v->image }}" alt="#" style="width: 100%; height: 100%"></td>
                                        <td class="product-des" data-title="Description">
                                            <p class="product-name"><a href="javascript:void(0)">{{ $v->nama_produk }}</a></p>
                                            <p class="product-des"><small>{{ App\Models\HelperModel::truncate($v->deskripsi, 70) }}</small></p>
                                            <hr>
                                            <small><b>Catatan:</b></small>
                                            <p><small>{{ $v->catatan }}</small></p>
                                        </td>
                                        <td class="" data-title="Total">
                                            Harga : <b>Rp. {{ number_format($v->harga_satuan) }}</b> <br/>
                                            QTY : <b>{{ $v->qty }}</b> <br/>
                                            Berat Satuan : <b>{{ $v->berat_satuan }}</b> g <br/>
                                            Total Berat : <b>{{ $v->berat_satuan * $v->qty }}</b> g
                                            <br/> <br/>
                                            <div class="card">
                                                <div class="card-body">
                                                    <center>Total <br/> <b>Rp. {{ number_format($v->total) }}</b></center>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!--/ End Shopping Summery -->
            </div>

            <div class="col-lg-3">
                <!-- Total Amount -->
                <div class="">
                    <div class="row">
                        <div class="col-12">
                            <div class="">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            Kode Transaksi <br/>
                                            <b class="text-primary">{{ $transaksi->kode_transaksi }}</b>
                                        </div>
                                        <div class="form-group">
                                            Tgl. Transaksi <br/>
                                            <b>{{ date('d M Y, H:i:s', strtotime($transaksi->created_at)) }}</b>
                                        </div>
                                    </div>
                                </div>

                                <br/>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            Status Transaksi <br/>
                                            <b>{{ $transaksi->status }}</b>
                                        </div>
                                        @if($transaksi->status == 'DIKIRIM' || $transaksi->status == 'SELESAI')
                                        <div class="form-group">
                                            Nomor Resi <br/>
                                            <b>{{ $transaksi->no_resi }}</b>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            Metode Bayar <br/>
                                            <b>{{ $transaksi->metode_bayar }}</b>
                                        </div>
                                        <div class="form-group" id="holder_kurir">
                                            Kurir Pilihan <br/>
                                            <b>{{ $transaksi->kurir_pilihan }}</b>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-lg">SubTotal Berat <small>(gram)</small></div>
                                    <div class="col-lg text-right"><b>{{ number_format($transaksi->berat_produk_total) }} g</b></div>
                                </div>
                                <hr>

                                <div>
                                    {{-- <div class="card-body"> --}}
                                        <div class="row">
                                            <div class="col-lg">SubTotal Keranjang <small>(<b>{{ number_format($jmlItem) }}</b>)</small></div>
                                            <div class="col-lg text-right"><b>Rp. {{ number_format($transaksi->total_tagihan_produk) }}</b></div>
                                        </div>
                                        {{-- <hr> --}}
                                        <div class="row">
                                            <div class="col-lg">Diskon Voucher <b>({{ $transaksi->kode_promo }})</b></div>
                                            <div class="col-lg text-right"><b id="diskon_voucher_text">Rp. {{ number_format($transaksi->nominal_promo) }}</b></div>
                                        </div>
                                        {{-- <hr> --}}
                                        <div class="row">
                                            <div class="col-lg">Total Ongkir</div>
                                            <div class="col-lg text-right"><b id="total_ongkir_text">Rp. {{ number_format($transaksi->total_ongkir) }}</b></div>
                                        </div>
                                    {{-- </div> --}}
                                </div>
                                
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <b>Total Bayar </b>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <b id="total_bayar_all_text">Rp. {{ number_format($transaksi->total_transaksi) }}</b>
                                    </div>
                                </div>
                                <br/>
                                <br/>

                                @if($transaksi->metode_bayar == 'TRANSFER')
                                <div class="button5">
                                    <div class="card">
                                        <div class="card-body">

                                            <?php
                                                $d1 = new DateTime(date('Y-m-d H:i:s'));
                                                $d2 = new DateTime($transaksi->limit_datetime);
                                            ?>
                                            
                                            @if($transaksi->bukti_tf == '' || $transaksi->bukti_tf == null)
                                                Anda belum mengupload bukti transfer. <br/>
                                                Batas pembayaran hingga tanggal <b class="text-danger">{{ date('d M Y, H:i:s', strtotime($transaksi->limit_datetime)) }}</b>
                                                <br>
                                                <br>
                                                Transfer ke salah satu, <br/>
                                                @foreach ($rekening as $kk => $item)
                                                    {{$kk+1}}. {{ $item->nama_bank }} : <b>{{ $item->no_rekening }}</b><br/>
                                                @endforeach
                                            @else
                                                Anda sudah mengupload bukti transfer. Dengan tujuan rekening, <br/> 
                                                <b>{{ $transaksi->rekening_tf }}</b>
                                                <br/>
                                            @endif

                                            <br/>
                                            <div class="card">
                                                <div class="card-body">
                                                    <center>
                                                        Nominal Bayar <br/>
                                                        <b>Rp. {{ number_format($transaksi->total_transaksi) }}</b>
                                                    </center>
                                                </div>
                                            </div>
                                            <br>

                                            <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF">
                                                <a style="cursor: pointer" target="_blank" href="{{ $transaksi->bukti_tf == '' || $transaksi->bukti_tf == null ? asset('assets').'/noimage.png' : asset('').'/'.$transaksi->bukti_tf }}">
                                                    <img src="{{ $transaksi->bukti_tf == '' || $transaksi->bukti_tf == null ? asset('assets').'/noimage.png' : asset('').'/'.$transaksi->bukti_tf }}" class="preview_gambar" style="width:200px;max-height:200px;" alt="NONE" />
                                                </a>
                                            </center>
                                            
                                            @if($d1 < $d2 && ($transaksi->bukti_tf == '' || $transaksi->bukti_tf == null))
                                                <center><b class="text-danger">Belum melakukan upload bukti transfer.</b></center>
                                            @elseif($transaksi->bukti_tf != '' || $transaksi->bukti_tf != null)
                                            
                                            <b>Bukti Transfer</b>

                                            @else
                                                <center><b class="text-danger">Sudah melewati masa upload bukti transfer.</b></center>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <!--/ End Total Amount -->
            </div>

        </div>


      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('scriptplus')

<script>
  $(function () {

    $("#table").DataTable();

  });
</script>

@endsection