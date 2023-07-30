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
              Edit Master Kode Promo
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item">Kode Promo</li>
              <li class="breadcrumb-item">Edit</li>
              <li class="breadcrumb-item active"><a href="#">{{ $data_promo->kode_promo }}</a></li>
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
                  
                 <form action="{{ route('update-kode-promo') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data_promo->id }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="kode_promo">Kode Promo <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="kode_promo" name="kode_promo" placeholder="Required" value="{{ $data_promo->kode_promo }}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="minimal_belanja">Minimal Belanja (Rp.) <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control text-right currency" id="minimal_belanja" name="minimal_belanja" placeholder="Required" value="{{ $data_promo->minimal_belanja }}" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <label for="type_promo">Type Potongan <sup class="text-danger">*</sup></label>
                            <select name="type_promo" id="type_promo" class="form-control">
                                <option value="Fixed">Fixed</option>
                                <option value="Percentage" {{ $data_promo->type_promo == 'Percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="value_promo">Value Potongan <sub class="text-danger">(Fixed = Rp, Percentage = %)</sub></label>
                            <input type="number" min="0" class="form-control text-right" id="value_promo" name="value_promo" placeholder="Silahkan Masukkan Nilai.." value="{{ $data_promo->value_promo }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <label for="periode_mulai">Periode Mulai <sup class="text-danger">*</sup></label>
                            <input type="date" class="form-control" id="periode_mulai" name="periode_mulai" placeholder="Required" value="{{ $data_promo->periode_mulai }}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="periode_berakhir">Periode Berakhir <sup class="text-danger">*</sup></label>
                            <input type="date" class="form-control" id="periode_berakhir" name="periode_berakhir" placeholder="Required" value="{{ $data_promo->periode_berakhir }}" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <label for="quota">Quota Claim <sup class="text-danger">*</sup></label>
                            <input type="number" min="0" class="form-control" id="quota" name="quota" placeholder="Required" value="{{ $data_promo->quota }}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="status">Status <sup class="text-danger">*</sup></label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Aktif</option>
                                <option value="0" {{ $data_promo->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <a href="{{ route('kode-promo') }}" class="btn btn-outline-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
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
    
  });
</script>

@endsection