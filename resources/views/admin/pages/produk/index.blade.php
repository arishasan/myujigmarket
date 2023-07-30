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
              Master Produk
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item active">Produk</li>
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
                        <th width="5%"></th>
                        <th width="10%">Image</th>
                        <th width="15%">Kategori</th>
                        <th width="10%">Kode Produk</th>
                        <th>Nama Produk</th>
                        <th width="10%" class="text-right">Harga Jual</th>
                        <th width="5%" class="text-right">Stok</th>
                        <th width="5%" class="text-right">Terjual</th>
                        <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    
                        @foreach($data_produk as $val)
                            <tr>
                                <td><center><i class="fas fa-box"></i></center></td>
                                <td>
                                  <center>
                                    <a href="{{ asset('') }}/{{ $val->image }}" target="_blank">
                                      <img src="{{ asset('') }}/{{ $val->image }}" class="img-responsive" style="max-height: 100px; max-width: 100px" alt="NONE" />
                                    </a>
                                  </center>
                                </td>
                                <td>{{ $val->nama_kategori }}</td>
                                <td><b>{{ $val->kode_produk }}</b></td>
                                <td>{{ $val->nama_produk }} <br/> <b class="text-primary">({{ $val->is_new == 1 ? 'Baru' : 'Bekas' }})</b></td>
                                <td class="text-right"><b>Rp. {{ number_format($val->harga_jual) }}</b></td>
                                <td class="text-right"><b>{{ $val->stok }}</b></td>
                                <td class="text-right"><b>0</b></td>
                                <td><center>
                                    <b class="{{ $val->status == 1 ? 'text-success' : 'text-danger' }}">{{ $val->status == 1 ? 'Aktif' : 'Non-Aktif' }}</b>
                                    <br/>
                                    <button class="btn btn-outline-info btn-sm detail" data-id="{{ md5($val->id) }}" data-nama="{{ $val->kode_produk }}"><i class="fas fa-eye"></i></button>
                                    <a href="{{ url('master/produk/edit/') }}/{{ md5($val->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                                    <button class="btn btn-outline-danger btn-sm delete" data-id="{{ md5($val->id) }}" data-nama="{{ $val->nama_produk }}"><i class="fas fa-trash"></i></button>
                                </center></td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th width="5%"></th>
                        <th width="10%">Image</th>
                        <th width="15%">Kategori</th>
                        <th width="10%">Kode Produk</th>
                        <th>Nama Produk</th>
                        <th width="10%" class="text-right">Harga Jual</th>
                        <th width="10%" class="text-right">Stok</th>
                        <th width="5%" class="text-right">Terjual</th>
                        <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </tfoot>
                  </table>

                </div>
                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                  
                  <form action="{{ route('simpan-produk') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                      <div class="col-lg-3">

                        <div class="form-group">
                          <label for="nama">Image <sub class="text-danger">Max 2MB</sub></label>
                          <small></small>
                          <center style="margin-bottom:10px;border:dashed 1px #ccc;padding:15px;background:#FFF"><img src="{{ asset('assets') }}/noimage.png" class="preview_gambar" style="width:200px;max-height:200px;" alt="NONE" /></center>
                          <input type="file" class="form-control" id="upload_gambar" name="foto" accept="image/x-png,image/jpeg">
                          <hr>
                          <label for="nama">Extra Image <sub class="text-danger">Max 2MB each</sub></label>
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
                              <input type="text" class="form-control" id="nama" name="nama" placeholder="Required" value="{{ old('nama') }}" required>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label for="kategori">Kategori <sup class="text-danger">*</sup></label>
                              <select name="kategori" id="kategori" class="form-control" required>
                                <option value="">[ Silahkan Pilih ]</option>
                                @foreach($data_kategori as $val)
                                    <option value="{{ $val->id }}">{{ $val->nama }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label for="stok">Stok <sup class="text-danger">*</sup></label>
                              <input type="number" min="0" class="form-control" id="stok" name="stok" placeholder="Required" value="{{ old('stok') ?? 0 }}" required>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label for="harga_beli">Harga Beli <sup class="text-danger">*</sup></label>
                              <input type="text" class="form-control text-right currency" id="harga_beli" name="harga_beli" placeholder="Required" value="{{ old('harga_beli') ?? 0 }}" required>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label for="harga_jual">Harga Jual <sup class="text-danger">*</sup></label>
                              <input type="text" class="form-control text-right currency" id="harga_jual" name="harga_jual" placeholder="Required" value="{{ old('harga_jual') ?? 0 }}" required>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-lg"><label for="promo">Promo Potongan (%)</label></div>
                                <div class="col-lg-3 text-right">
                                  <input type="checkbox" value="1" id="is_promo" name="is_promo" {{ null !== old('is_promo') ? 'checked' : '' }}>
                                </div>
                              </div>
                              <input type="number" min="0" max="100" class="form-control text-right" id="promo" name="promo" value="{{ old('promo') ?? 0 }}" readonly>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-8">
                            <div class="form-group">
                              <label for="deskripsi">Deskripsi</label>
                              <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3"></textarea>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label for="status">Status</label>
                              <select name="status" id="status" class="form-control">
                                  <option value="1">Aktif</option>
                                  <option value="0">Non-Aktif</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="is_new">Kondisi Barang</label>
                              <select name="is_new" id="is_new" class="form-control">
                                  <option value="1">Baru</option>
                                  <option value="0">Second/Bekas</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="berat_gram">Berat Barang (Gram)</label>
                              <input type="number" min="0" class="form-control text-right" id="berat_gram" name="berat_gram" value="{{ old('berat_gram') ?? 0 }}">
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="float-right">
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
    $("#table").DataTable({
      "responsive": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

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

    $('#table').on('click', '.delete', function(){
      let id = $(this).attr('data-id');
      let nama = $(this).attr('data-nama');

      Swal.fire({
        title: 'Hapus produk '+nama+'?',
        showCancelButton: true,
        icon: 'warning',
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          let link = "{{ url('master/produk/delete') }}/"+id;
          $.get(link, function(res){
            location.reload();
          });

        } else if (result.isDenied) {
        }
      })

    });

    $('#table').on('click', '.detail', function(){
      let id = $(this).attr('data-id');
      let nama = $(this).attr('data-nama');

        $('#title_modal').text(nama);
        let link = "{{ url('master/produk/detail') }}/"+id;
        $.get(link, function(res){
            $('#holder_detail').html(res);
            $('#modal_detail').modal('show');
        });

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