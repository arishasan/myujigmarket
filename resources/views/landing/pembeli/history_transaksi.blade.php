@extends('landing.mainlayout')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="#">Customer<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">History Transaksi</a></li>
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

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active text-primary" id="nav-wait-payment" data-toggle="tab" href="#nav-wait" role="tab" aria-controls="nav-wait" aria-selected="true"><i class="fa fa-money"></i> Menunggu Pembayaran <span class="badge badge-dark">{{ App\Models\HelperModel::getCountTrx('MENUNGGU_PEMBAYARAN') }}</span></a>
                <a class="nav-item nav-link text-info" id="nav-wait-confirm" data-toggle="tab" href="#nav-confirm" role="tab" aria-controls="nav-confirm" aria-selected="true"><i class="fa fa-info"></i> Menunggu Konfirmasi <span class="badge badge-dark">{{ App\Models\HelperModel::getCountTrx('MENUNGGU_KONFIRMASI') }}</span></a>
                <a class="nav-item nav-link text-warning" id="nav-in-process" data-toggle="tab" href="#nav-process" role="tab" aria-controls="nav-process" aria-selected="true"><i class="fa fa-history"></i> Diproses <span class="badge badge-dark">{{ App\Models\HelperModel::getCountTrx('DIPROSES') }}</span></a>
                <a class="nav-item nav-link text-primary" id="nav-in-sent" data-toggle="tab" href="#nav-sent" role="tab" aria-controls="nav-sent" aria-selected="true"><i class="fa fa-truck"></i> <b>Dikirim</b> <span class="badge badge-dark">{{ App\Models\HelperModel::getCountTrx('DIKIRIM') }}</span></a>
                <a class="nav-item nav-link text-success" id="nav-is-done" data-toggle="tab" href="#nav-done" role="tab" aria-controls="nav-done" aria-selected="true"><i class="fa fa-check"></i> Selesai <span class="badge badge-dark">{{ App\Models\HelperModel::getCountTrx('SELESAI') }}</span></a>
                <a class="nav-item nav-link text-danger" id="nav-is-cancel" data-toggle="tab" href="#nav-cancel" role="tab" aria-controls="nav-cancel" aria-selected="true"><i class="fa fa-times"></i> Cancel <span class="badge badge-dark">{{ App\Models\HelperModel::getCountTrx('CANCEL') }}</span></a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-wait" role="tabpanel" aria-labelledby="nav-wait-payment">

                <div class="card">
                    <card class="body">
                        <div class="container p-5">
                            <table class="table table-striped table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="5%"><center>No.</center></th>
                                        <th width="15%"><center>Tgl. Transaksi</center></th>
                                        <th>Ringkasan</th>
                                        <th width="10%"><center>Metode Bayar</center></th>
                                        <th width="15%"><center>Aksi</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menunggu_pembayaran as $k => $v)
                                        <tr>
                                            <td><center><b>{{ $k+1 }}.</b></center></td>
                                            <td><center>{{ date('d M Y', strtotime($v->tgl_transaksi)) }}</center></td>
                                            <td>
                                                <h6 class="text-primary">{{ $v->kode_transaksi }}</h6>
                                                Total Transaksi : <b>Rp. {{ number_format($v->total_transaksi) }}</b> 

                                                @if($v->bukti_tf == null || $v->bukti_tf == '')
                                                <br/>
                                                <br/>
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>Informasi!</strong> Anda belum mengupload bukti bayar, segera upload sebelum tanggal <b>{{ date('d M Y, H:i:s', strtotime($v->limit_datetime)) }}</b>.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                @endif
                                            </td>
                                            <td><center><b>{{ $v->metode_bayar }}</b></center></td>
                                            <td>
                                                <center>

                                                    <a href="{{ url('customer/akun/history_transaksi') }}/{{ md5($v->id) }}" class="btn-primary text-white" style="padding: 10px; border-radius: 10%" title="Detail Pesanan"><i class="fa fa-eye"></i></a>
                                                    
                                                    @if($v->status == 'MENUNGGU_PEMBAYARAN' || $v->status == 'MENUNGGU_KONFIRMASI')
                                                        <a href="javascript:void(0)" class="btn-danger text-white cancel_transaksi" data-kode="{{ $v->kode_transaksi }}" data-id="{{ $v->id }}" style="padding: 10px; border-radius: 10%" title="Batalkan Pesanan"><i class="fa fa-times"></i></a>
                                                    @endif

                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </card>
                </div>

            </div>
            
            <div class="tab-pane fade" id="nav-confirm" role="tabpanel" aria-labelledby="nav-wait-confirm">
                
                <div class="card">
                    <card class="body">
                        <div class="container p-5">
                            <table class="table table-striped table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="5%"><center>No.</center></th>
                                        <th width="15%"><center>Tgl. Transaksi</center></th>
                                        <th>Ringkasan</th>
                                        <th width="10%"><center>Metode Bayar</center></th>
                                        <th width="15%"><center>Aksi</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menunggu_konfirmasi as $k => $v)
                                        <tr>
                                            <td><center><b>{{ $k+1 }}.</b></center></td>
                                            <td><center>{{ date('d M Y', strtotime($v->tgl_transaksi)) }}</center></td>
                                            <td>
                                                <h6 class="text-primary">{{ $v->kode_transaksi }}</h6>
                                                Total Transaksi : <b>Rp. {{ number_format($v->total_transaksi) }}</b> 
                                            </td>
                                            <td><center><b>{{ $v->metode_bayar }}</b></center></td>
                                            <td>
                                                <center>

                                                    <a href="{{ url('customer/akun/history_transaksi') }}/{{ md5($v->id) }}" class="btn-primary text-white" style="padding: 10px; border-radius: 10%" title="Detail Pesanan"><i class="fa fa-eye"></i></a>
                                                    
                                                    @if($v->status == 'MENUNGGU_PEMBAYARAN' || $v->status == 'MENUNGGU_KONFIRMASI')
                                                        <a href="javascript:void(0)" class="btn-danger text-white cancel_transaksi" data-kode="{{ $v->kode_transaksi }}" data-id="{{ $v->id }}" style="padding: 10px; border-radius: 10%" title="Batalkan Pesanan"><i class="fa fa-times"></i></a>
                                                    @endif

                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </card>
                </div>

            </div>

            <div class="tab-pane fade" id="nav-process" role="tabpanel" aria-labelledby="nav-in-process">
                
                <div class="card">
                    <card class="body">
                        <div class="container p-5">
                            <table class="table table-striped table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="5%"><center>No.</center></th>
                                        <th width="15%"><center>Tgl. Transaksi</center></th>
                                        <th>Ringkasan</th>
                                        <th width="10%"><center>Metode Bayar</center></th>
                                        <th width="15%"><center>Aksi</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diproses as $k => $v)
                                        <tr>
                                            <td><center><b>{{ $k+1 }}.</b></center></td>
                                            <td><center>{{ date('d M Y', strtotime($v->tgl_transaksi)) }}</center></td>
                                            <td>
                                                <h6 class="text-primary">{{ $v->kode_transaksi }}</h6>
                                                Total Transaksi : <b>Rp. {{ number_format($v->total_transaksi) }}</b> 
                                            </td>
                                            <td><center><b>{{ $v->metode_bayar }}</b></center></td>
                                            <td>
                                                <center>

                                                    <a href="{{ url('customer/akun/history_transaksi') }}/{{ md5($v->id) }}" class="btn-primary text-white" style="padding: 10px; border-radius: 10%" title="Detail Pesanan"><i class="fa fa-eye"></i></a>

                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </card>
                </div>

            </div>

            <div class="tab-pane fade" id="nav-sent" role="tabpanel" aria-labelledby="nav-in-sent">
                
                <div class="card">
                    <card class="body">
                        <div class="container p-5">
                            <table class="table table-striped table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="5%"><center>No.</center></th>
                                        <th width="15%"><center>Tgl. Transaksi</center></th>
                                        <th>Ringkasan</th>
                                        <th width="10%"><center>Metode Bayar</center></th>
                                        <th width="15%"><center>Aksi</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dikirim as $k => $v)
                                        <tr>
                                            <td><center><b>{{ $k+1 }}.</b></center></td>
                                            <td><center>{{ date('d M Y', strtotime($v->tgl_transaksi)) }}</center></td>
                                            <td>
                                                <h6 class="text-primary">{{ $v->kode_transaksi }}</h6>
                                                Total Transaksi : <b>Rp. {{ number_format($v->total_transaksi) }}</b> <br/><br/>
                                                <button class="btn-success form-control selesaikan_pesanan" data-id="{{ $v->id }}" data-kode="{{ $v->kode_transaksi }}"><i class="fa fa-check"></i> Selesaikan Pesanan</button>
                                            </td>
                                            <td><center><b>{{ $v->metode_bayar }}</b></center></td>
                                            <td>
                                                <center>

                                                    <a href="{{ url('customer/akun/history_transaksi') }}/{{ md5($v->id) }}" class="btn-primary text-white" style="padding: 10px; border-radius: 10%" title="Detail Pesanan"><i class="fa fa-eye"></i></a>

                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </card>
                </div>

            </div>

            <div class="tab-pane fade" id="nav-done" role="tabpanel" aria-labelledby="nav-is-done">
                
                <div class="card">
                    <card class="body">
                        <div class="container p-5">
                            <table class="table table-striped table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="5%"><center>No.</center></th>
                                        <th width="15%"><center>Tgl. Transaksi</center></th>
                                        <th>Ringkasan</th>
                                        <th width="10%"><center>Metode Bayar</center></th>
                                        <th width="15%"><center>Aksi</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($selesai as $k => $v)
                                        <tr>
                                            <td><center><b>{{ $k+1 }}.</b></center></td>
                                            <td><center>{{ date('d M Y', strtotime($v->tgl_transaksi)) }}</center></td>
                                            <td>
                                                <h6 class="text-primary">{{ $v->kode_transaksi }}</h6>
                                                Total Transaksi : <b>Rp. {{ number_format($v->total_transaksi) }}</b> 
                                            </td>
                                            <td><center><b>{{ $v->metode_bayar }}</b></center></td>
                                            <td>
                                                <center>

                                                    <a href="{{ url('customer/akun/history_transaksi') }}/{{ md5($v->id) }}" class="btn-primary text-white" style="padding: 10px; border-radius: 10%" title="Detail Pesanan"><i class="fa fa-eye"></i></a>

                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </card>
                </div>

            </div>

            <div class="tab-pane fade" id="nav-cancel" role="tabpanel" aria-labelledby="nav-is-cancel">
                
                <div class="card">
                    <card class="body">
                        <div class="container p-5">
                            <table class="table table-striped table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="5%"><center>No.</center></th>
                                        <th width="15%"><center>Tgl. Transaksi</center></th>
                                        <th>Ringkasan</th>
                                        <th width="10%"><center>Metode Bayar</center></th>
                                        <th width="15%"><center>Aksi</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cancel as $k => $v)
                                        <tr>
                                            <td><center><b>{{ $k+1 }}.</b></center></td>
                                            <td><center>{{ date('d M Y', strtotime($v->tgl_transaksi)) }}</center></td>
                                            <td>
                                                <h6 class="text-primary">{{ $v->kode_transaksi }}</h6>
                                                Total Transaksi : <b>Rp. {{ number_format($v->total_transaksi) }}</b> 
                                            </td>
                                            <td><center><b>{{ $v->metode_bayar }}</b></center></td>
                                            <td>
                                                <center>

                                                    <a href="{{ url('customer/akun/history_transaksi') }}/{{ md5($v->id) }}" class="btn-primary text-white" style="padding: 10px; border-radius: 10%" title="Detail Pesanan"><i class="fa fa-eye"></i></a>

                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </card>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@section('scriptplus')

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(function(){

        $('.table').DataTable();

        $(document).on('click', '.cancel_transaksi', function(){
            let id = $(this).attr('data-id');
            let kode = $(this).attr('data-kode');
            Swal.fire({
            title: 'Perhatian...',
            text: "Anda yakin akan membatalkan pesanan dengan kode transaksi "+kode+"?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                        url: "{{ url('customer/akun/history_transaksi/cancel_transaksi') }}",
                        type: "POST",
                        data: {
                            id: id
                        } ,
                        success: function (res) {

                            location.reload();

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        }
                    });

                }
            });
        });

        $(document).on('click', '.selesaikan_pesanan', function(){
            let id = $(this).attr('data-id');
            let kode = $(this).attr('data-kode');
            Swal.fire({
            title: 'Perhatian...',
            text: "Anda yakin akan menyelesaikan pesanan dengan kode transaksi "+kode+"?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                        url: "{{ url('customer/akun/history_transaksi/selesaikan_transaksi') }}",
                        type: "POST",
                        data: {
                            id: id
                        } ,
                        success: function (res) {

                            location.reload();

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