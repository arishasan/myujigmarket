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
              Data Pesanan
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Data</a></li>
              <li class="breadcrumb-item active">Pesanan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        @include('admin.parts.feedback')

        <!-- <form method="POST" action="?">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <label>Tampilkan Dari Tanggal</label>
                            <input type="date" class="form-control" name="dari" value="{{ $dari }}">
                        </div>
                        <div class="col-lg-5">
                            <label>Sampai</label>
                            <input type="date" class="form-control" name="ke" value="{{ $ke }}">
                        </div>
                        <div class="col-lg-2">
                            <label>Aksi</label>
                            <button class="btn btn-primary form-control"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </form> -->
        
        <div>
          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Data Pesanan</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                  
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Tgl. Transaksi</th>
                      <th>Kode Transaksi</th>
                      <th class="text-right">Total Transaksi</th>
                      <th><center>Metode Bayar</center></th>
                      <th width="20%"><center>Status</center></th>
                      <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach($transaksi as $k => $v)
                        <tr class="{{ $v->status == 'CANCEL' ? 'bg-danger text-white' : '' }}">
                            <td>{{ date('d M Y, H:i:s', strtotime($v->created_at)) }}</td>
                            <td><b class="{{ $v->status == 'CANCEL' ? '' : 'text-primary' }}">{{ $v->kode_transaksi }}</b></td>
                            <td class="text-right"><b>Rp. {{ number_format($v->total_transaksi) }}</b></td>
                            <td>
                                <center>
                                    {{ $v->metode_bayar }}
                                    @if($v->metode_bayar == 'TRANSFER')
                                        <br>
                                        @if($v->bukti_tf == '' || $v->bukti_tf == null)
                                            <b class="text-warning">Belum upload bukti transfer.</b>
                                        @else
                                            <b class="text-success">Sudah upload bukti transfer.</b>
                                        @endif
                                    @endif
                                </center>
                            </td>
                            <td>
                                <center>
                                    {{ $v->status  }}
                                    @if($v->status == 'MENUNGGU_KONFIRMASI')
                                        <button class="btn btn-info form-control ubah_status" data-status="DIPROSES" data-id="{{ $v->id }}" data-kode="{{ $v->kode_transaksi }}">Proses Pesanan <i class="fa fa-arrow-right"></i></button>
                                    @elseif($v->status == 'DIPROSES')
                                        
                                        @if($v->metode_bayar == 'DATANG_LANGSUNG')
                                        <button class="btn btn-info form-control ubah_status" data-status="SELESAI" data-id="{{ $v->id }}" data-kode="{{ $v->kode_transaksi }}">Selesaikan Pesanan <i class="fa fa-arrow-right"></i></button>
                                        @else
                                        <button class="btn btn-info form-control ubah_status" data-status="DIKIRIM" data-id="{{ $v->id }}" data-kode="{{ $v->kode_transaksi }}">Kirim Pesanan <i class="fa fa-arrow-right"></i></button>
                                        @endif

                                    @elseif($v->status == 'DIKIRIM')
                                        <button class="btn btn-info form-control ubah_status" data-status="SELESAI" data-id="{{ $v->id }}" data-kode="{{ $v->kode_transaksi }}">Selesaikan Pesanan <i class="fa fa-arrow-right"></i></button>
                                    @endif
                                </center>
                            </td>
                            <td>
                                <center>
                                    <a href="{{ url('pesanan/detail') }}/{{ md5($v->id) }}" target="_blank" class="btn btn-success" title="Detail Pesanan"><i class="fa fa-eye"></i></a>
                                    @if($v->status == 'CANCEL' || $v->status == 'SELESAI')
                                    @else
                                    <button type="button" class="btn btn-warning ubah_status" data-status="CANCEL" data-id="{{ $v->id }}" data-kode="{{ $v->kode_transaksi }}" title="Batalkan Pesanan"><i class="fa fa-times"></i></button>
                                    @endif
                                </center>
                            </td>
                        </tr>
                        @endforeach
                      
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><center>Tgl. Transaksi</center></th>
                            <th>Kode Transaksi</th>
                            <th class="text-right">Total Transaksi</th>
                            <th><center>Metode Bayar</center></th>
                            <th width="20%"><center>Status</center></th>
                            <th width="15%"><center>Aksi</center></th>
                        </tr>
                    </tfoot>
                  </table>

                </div>
              </div>
            </div>
            <!-- /.card -->
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
    // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    $("#table").DataTable({
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

    $(document).on('click', '.ubah_status', function(){

        let id = $(this).attr('data-id');
        let kode = $(this).attr('data-kode');
        let status = $(this).attr('data-status');

        let keterangan = '';
        if(status == 'DIPROSES'){
            keterangan = 'Proses pesanan dengan kode transaksi: '+kode+' ?';
        }else if(status == 'DIKIRIM'){
            keterangan = 'Silahkan masukkan nomor resi untuk pengiriman pesanan dengan kode transaksi: '+kode+'.';
        }else if(status == 'SELESAI'){
            keterangan = 'Selesaikan pesanan dengan kode transaksi: '+kode+' ?';
        }else if(status == 'CANCEL'){
            keterangan = 'Batalkan pesanan dengan kode transaksi: '+kode+' ?';
        }

        let noResi = '0';

        if(status == 'DIKIRIM'){

            Swal.fire({
            title: 'Perhatian...',
            text: keterangan,
            icon: 'info',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proses',
            cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    if(result.value == null || result.value == '' || result.value == '/'){
                        return;
                    }else{
                        noResi = result.value;
                    }
                    // alert(noresi);
                    let link = '{{ url("pesanan/ubah_status") }}/'+id+'/'+status+'/'+noResi;
                    $.get(link, function(){
                        location.reload();
                    });

                }
            });

        }else{
            
            Swal.fire({
            title: 'Perhatian...',
            text: keterangan,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    let link = '{{ url("pesanan/ubah_status") }}/'+id+'/'+status+'/'+noResi;
                    $.get(link, function(){
                        location.reload();
                    });

                }
            });

        }

    });

  });
</script>

@endsection