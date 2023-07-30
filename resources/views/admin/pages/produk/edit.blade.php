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
              Edit Master Produk
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item">Produk</li>
              <li class="breadcrumb-item">Edit</li>
              <li class="breadcrumb-item active"><a href="#">{{ $data_produk->kode_produk }}</a></li>
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
                  
                    <form action="{{ route('update-produk') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data_produk->id }}">
                        
                        <div class="row">
                          <div class="col-lg-3">
    
                            <div class="form-group">
                              <label for="nama">Image <sub class="text-danger">Max 2MB</sub></label>
                              <small></small>
                              <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF"><img src="{{ asset('') }}/{{ $data_produk->image }}" class="preview_gambar" style="width:200px;max-height:200px;" alt="NONE" /></center>
                              <input type="file" class="form-control" id="upload_gambar" name="foto" accept="image/x-png,image/jpeg">
                              <hr>
                              <label for="nama">Extra Image <sub class="text-danger">Max 2MB each</sub></label>
                              <div class="row">
                                <div class="col-lg-6">
                                    <a href="{{ asset('') }}/{{ $data_produk->image2 }}" target="_blank">
                                        <img src="{{ asset('') }}/{{ $data_produk->image2 }}" class="img-responsive" style="max-height: 100px" alt="NONE" />
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <a href="{{ asset('') }}/{{ $data_produk->image3 }}" target="_blank">
                                        <img src="{{ asset('') }}/{{ $data_produk->image3 }}" class="img-responsive" style="max-height: 100px" alt="NONE" />
                                    </a>
                                </div>
                              </div>
                              <input type="file" class="form-control" id="upload_gambar2" name="foto2" accept="image/x-png,image/jpeg">
                              <hr>
                              <input type="file" class="form-control" id="upload_gambar2" name="foto3" accept="image/x-png,image/jpeg">

                            </div>
    
                          </div>
                          <div class="col-lg-9">
                            
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="nama">Nama <sup class="text-danger">*</sup></label>
                                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Required" value="{{ $data_produk->nama_produk }}" required>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="kategori">Kategori <sup class="text-danger">*</sup></label>
                                  <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="">[ Silahkan Pilih ]</option>
                                    @foreach($data_kategori as $val)
                                        <option value="{{ $val->id }}" {{ $data_produk->id_kategori == $val->id ? 'selected' : '' }}>{{ $val->nama }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="stok">Stok <sup class="text-danger">*</sup></label>
                                  <input type="number" min="0" class="form-control" id="stok" name="stok" placeholder="Required" value="{{ $data_produk->stok ?? 0 }}" required>
                                </div>
                              </div>
                            </div>
    
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="harga_beli">Harga Beli <sup class="text-danger">*</sup></label>
                                  <input type="text" class="form-control text-right currency" id="harga_beli" name="harga_beli" placeholder="Required" value="{{ $data_produk->harga_beli }}" required>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="harga_jual">Harga Jual <sup class="text-danger">*</sup></label>
                                  <input type="text" class="form-control text-right currency" id="harga_jual" name="harga_jual" placeholder="Required" value="{{ $data_produk->harga_jual }}" required>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <div class="row">
                                    <div class="col-lg"><label for="promo">Promo Potongan (%)</label></div>
                                    <div class="col-lg-3 text-right">
                                      <input type="checkbox" value="1" id="is_promo" name="is_promo" {{ $data_produk->is_promo == 1 ? 'checked' : '' }}>
                                    </div>
                                  </div>
                                  <input type="number" min="0" max="100" class="form-control text-right" id="promo" name="promo" value="{{ $data_produk->value_promo }}" {{ $data_produk->is_promo == 1 ? '' : 'readonly' }}>
                                </div>
                              </div>
                            </div>
    
                            <div class="row">
                              <div class="col-lg-8">
                                <div class="form-group">
                                  <label for="deskripsi">Deskripsi</label>
                                  <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3">{{ $data_produk->deskripsi }}</textarea>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label for="status">Status</label>
                                  <select name="status" id="status" class="form-control">
                                      <option value="1">Aktif</option>
                                      <option value="0" {{ $data_produk->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="is_new">Kondisi Barang</label>
                                  <select name="is_new" id="is_new" class="form-control">
                                      <option value="1">Baru</option>
                                      <option value="0" {{ $data_produk->is_new == 0 ? 'selected' : '' }}>Second/Bekas</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="berat_gram">Berat Barang (Gram)</label>
                                  <input type="number" min="0" class="form-control text-right" id="berat_gram" name="berat_gram" value="{{ $data_produk->berat_gram }}">
                                </div>
                              </div>
                            </div>
    
                          </div>
                        </div>

                        <div class="float-right">
                          <a href="{{ route('produk') }}" class="btn btn-outline-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
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

@endsection

@section('scriptplus')

<script>
  $(function () {

    $('#is_promo').change(function(){
      if($(this).is(':checked')){
        $('#promo').val(0);
        $('#promo').removeAttr('readonly');
      }else{
        $('#promo').val(0);
        $('#promo').attr('readonly', true);
      }
    });

    $('#promo').keyup(function(){
      if ($(this).val() > 100){
        $(this).val('100');
      }
    });

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