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
              Master Kode Promo
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item active">Kode Promo</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        @include('admin.parts.feedback')
        
        <div>
          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Data</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Tambah Data Baru</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                  
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Kode Promo</th>
                      <th width="15%">Periode Mulai</th>
                      <th width="15%">Periode Berakhir</th>
                      <th width="5%"><center>Quota</center></th>
                      <th width="5%"><center>Digunakan</center></th>
                      <th width="5%"><center>Status</center></th>
                      <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data_promo as $val)
                        <tr>
                          <td>{{ $val->kode_promo }}</td>
                          <td>{{ date('d M Y', strtotime($val->periode_mulai)) }}</td>
                          <td>{{ date('d M Y', strtotime($val->periode_berakhir)) }}</td>
                          <td><center><b>{{ $val->quota }}</b></center></td>
                          <td><center><b>0</b></center></td>
                          <td><center><b class="{{ $val->status == 1 ? 'text-success' : 'text-danger' }}">{{ $val->status == 1 ? 'Aktif' : 'Non-Aktif' }}</b></center></td>
                          <td><center>
                            <button class="btn btn-outline-info btn-sm detail" data-id="{{ md5($val->id) }}" data-nama="{{ $val->kode_promo }}"><i class="fas fa-eye"></i></button>
                            <a href="{{ url('master/kode_promo/edit/') }}/{{ md5($val->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-outline-danger btn-sm delete" data-id="{{ md5($val->id) }}" data-nama="{{ $val->kode_promo }}"><i class="fas fa-trash"></i></button>
                          </center></td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Kode Promo</th>
                        <th width="15%">Periode Mulai</th>
                        <th width="15%">Periode Berakhir</th>
                        <th width="5%"><center>Quota</center></th>
                        <th width="5%"><center>Digunakan</center></th>
                        <th width="5%"><center>Status</center></th>
                        <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </tfoot>
                  </table>

                </div>
                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                  
                  <form action="{{ route('simpan-kode-promo') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="kode_promo">Kode Promo <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="kode_promo" name="kode_promo" placeholder="Required" value="{{ old('kode_promo') }}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="minimal_belanja">Minimal Belanja (Rp.) <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control text-right currency" id="minimal_belanja" name="minimal_belanja" placeholder="Required" value="{{ old('minimal_belanja') ?? 0 }}" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <label for="type_promo">Type Potongan <sup class="text-danger">*</sup></label>
                            <select name="type_promo" id="type_promo" class="form-control">
                                <option value="Fixed">Fixed</option>
                                <option value="Percentage">Percentage</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="value_promo">Value Potongan <sub class="text-danger">(Fixed = Rp, Percentage = %)</sub></label>
                            <input type="number" min="0" class="form-control text-right" id="value_promo" name="value_promo" placeholder="Silahkan Masukkan Nilai.." value="{{ old('value_promo') ?? 0 }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <label for="periode_mulai">Periode Mulai <sup class="text-danger">*</sup></label>
                            <input type="date" class="form-control" id="periode_mulai" name="periode_mulai" placeholder="Required" value="{{ old('periode_mulai') ?? date('Y-m-d') }}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="periode_berakhir">Periode Berakhir <sup class="text-danger">*</sup></label>
                            <input type="date" class="form-control" id="periode_berakhir" name="periode_berakhir" placeholder="Required" value="{{ old('periode_berakhir') ?? date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <label for="quota">Quota Claim <sup class="text-danger">*</sup></label>
                            <input type="number" min="0" class="form-control" id="quota" name="quota" placeholder="Required" value="{{ old('quota') ?? 0 }}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                  </form>

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

  <div class="modal fade" id="modal_detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="title_modal"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="holder_detail">
            
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

@endsection

@section('scriptplus')

<script>
  $(function () {
    // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    $("#table").DataTable({
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

    $('#table').on('click', '.detail', function(){
      let id = $(this).attr('data-id');
      let nama = $(this).attr('data-nama');

        $('#title_modal').text(nama);
        let link = "{{ url('master/kode_promo/detail') }}/"+id;
        $.get(link, function(res){
            $('#holder_detail').html(res);
            $('#modal_detail').modal('show');
        });

    });

    $('#table').on('click', '.delete', function(){
      let id = $(this).attr('data-id');
      let nama = $(this).attr('data-nama');

      Swal.fire({
        title: 'Hapus data '+nama+'?',
        showCancelButton: true,
        icon: 'warning',
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          let link = "{{ url('master/kode_promo/delete') }}/"+id;
          $.get(link, function(res){
            location.reload();
          });

        } else if (result.isDenied) {
        }
      })

    });

  });
</script>

@endsection