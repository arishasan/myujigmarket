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
              Master Banner
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item active">Banner</li>
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
                      <th><center>Image</center></th>
                      <th width="15%">Title</th>
                      <th width="15%">SubTitle</th>
                      <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data_banner as $val)
                        <tr>
                          <td>
                            <center>
                                <a href="{{ asset('') }}/{{ $val->image }}" target="_blank">
                                    <img src="{{ asset('') }}/{{ $val->image }}" class="img-responsive" style="max-height: 300px; max-width: 300px" alt="NONE" />
                                </a>
                            </center>
                          </td>
                          <td>{{ $val->title }}</td>
                          <td>{{ $val->subtitle }}</td>
                          <td><center>
                            <a href="{{ url('master/banner/edit/') }}/{{ md5($val->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-outline-danger btn-sm delete" data-id="{{ md5($val->id) }}" data-nama="{{ $val->image }}"><i class="fas fa-trash"></i></button>
                          </center></td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                      <th><center>Image</center></th>
                      <th width="15%">Title</th>
                      <th width="15%">SubTitle</th>
                      <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </tfoot>
                  </table>

                </div>
                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                  
                  <form action="{{ route('simpan-banner') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3">
                            <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF"><img src="{{ asset('assets') }}/noimage.png" class="preview_gambar" style="width:200px;max-height:200px;" alt="NONE" /></center>
                            <input type="file" class="form-control" id="upload_gambar" name="foto" accept="image/x-png,image/jpeg" required>
                            <center><small class="text-danger">Max 2 MB</small></center>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Optional">
                            </div>

                            <div class="form-group">
                                <label for="subtitle">Sub Title</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Optional">
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
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

@endsection

@section('scriptplus')

<script>
  $(function () {
    // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    $("#table").DataTable({
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

    function uploadPreviewImageEdit(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
      
        reader.onload = function (e) {
          $(document).find('.preview_gambar').attr('src', e.target.result);
        }
      
        reader.readAsDataURL(input.files[0]);
      }
    }

    $(document).on('change','#upload_gambar',function(){
      $(document).find('.preview_gambar').fadeIn();
      uploadPreviewImageEdit(this);
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

          let link = "{{ url('master/banner/delete') }}/"+id;
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