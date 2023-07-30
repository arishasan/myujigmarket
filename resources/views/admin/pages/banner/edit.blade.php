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
              Edit Master Banner
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item">Banner</li>
              <li class="breadcrumb-item">Edit</li>
              <li class="breadcrumb-item active"><a href="#">{{ $data_banner->image }}</a></li>
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
                  <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Edit Data</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                  
                 <form action="{{ route('update-banner') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data_banner->id }}">
                    <div class="row">
                        <div class="col-lg-3">
                            <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF"><img src="{{ asset('') }}/{{ $data_banner->image }}" class="preview_gambar" style="width:200px;max-height:200px;" alt="NONE" /></center>
                            <input type="file" class="form-control" id="upload_gambar" name="foto" accept="image/x-png,image/jpeg">
                            <center><small class="text-danger">Max 2 MB</small></center>
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $data_banner->title }}" placeholder="Optional">
                            </div>

                            <div class="form-group">
                                <label for="subtitle">Sub Title</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ $data_banner->subtitle }}" placeholder="Optional">
                            </div>

                            <div class="form-group text-right">
                                <a href="{{ route('banner') }}" class="btn btn-outline-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
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
  });
</script>

@endsection