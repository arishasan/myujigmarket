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
                        <li><a href="#">Pengaturan<i class="ti-arrow-right"></i></a></li>
                        <li><a href="#">Alamat<i class="ti-arrow-right"></i></a></li>
                        <li><a href="#">Edit<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">{{ $alamat->label }}</a></li>
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
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Data</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="card">
                    <card class="body">
                        <div class="container p-5">
                            <form action="{{ url('customer/akun/update_alamat') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $alamat->id }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg">
                                            Label <sup style="color:red">*</sup>
                                            <input type="text" class="form-control" name="label" value="{{ $alamat->label }}" style="padding-left: 10px; padding-right: 10px" required>
                                        </div>
                                        <div class="col-lg">
                                            Kode Pos <sub style="color:red">(Terisi otomatis ketika memilih kota)</sub>
                                            <input type="text" class="form-control" name="kode_pos" id="kode_pos" value="{{ $alamat->kode_pos }}" style="padding-left: 10px; padding-right: 10px">
                                        </div>
                                        <div class="col-lg">
                                            Gunakan sebagai alamat utama
                                            <select name="alamat_utama" class="form-control">
                                                <option value="0">Tidak</option>
                                                <option value="1" {{ $alamat->is_alamat_utama ? 'selected' : '' }}>Ya</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg">
                                            Penerima <sup style="color:red">*</sup>
                                            <input type="text" class="form-control" name="penerima" value="{{ $alamat->penerima }}" style="padding-left: 10px; padding-right: 10px" required>
                                        </div>
                                        <div class="col-lg">
                                            Nomor HP <sup style="color:red">*</sup>
                                            <input type="text" class="form-control" name="no_hp" value="{{ $alamat->no_hp }}" style="padding-left: 10px; padding-right: 10px" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg">
                                            Provinsi <sup style="color:red">*</sup>
                                            <select name="provinsi" class="form-control" id="prov" required>
                                                <option value="">[ Silahkan Pilih ]</option>
                                                @foreach($prov as $v)
                                                    <option value="{{ $v->province_id }}" {{ $v->province_id == $alamat->provinsi ? 'selected' : '' }}>{{ $v->province_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg">
                                            Kota <sup style="color:red">*</sup>
                                            <select name="kota" class="form-control" id="kota" required>
                                                <option value="">[ Silahkan Pilih ]</option>
                                                @foreach($kota as $v)
                                                    <option value="{{ $v->city_id }}" data-pos="{{ $v->postal_code }}" {{ $v->city_id == $alamat->kota ? 'selected' : '' }}>{{ $v->city_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg">
                                            Kecamatan <sup style="color:red">*</sup>
                                            <select name="kecamatan" class="form-control" id="kec" required>
                                                <option value="">[ Silahkan Pilih ]</option>
                                                @foreach($kecamatan as $v)
                                                    <option value="{{ $v->subdistrict_id }}" {{ $v->subdistrict_id == $alamat->kecamatan ? 'selected' : '' }}>{{ $v->subdistrict_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg">
                                            Alamat Lengkap / Deskripsi <sup style="color:red">*</sup>
                                            <textarea name="alamat" class="form-control" required>{{ $alamat->alamat }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6"><a href="{{ url('customer/akun/pengaturan/alamat') }}" class="btn text-white"><i class="fa fa-arrow-left"></i></a></div>
                                    <div class="col-lg-6 text-right"><button class="btn">Simpan</button></div>
                                </div>

                            </form>
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

        $('#prov').change(function(){

            $('#kota').html('');
            $('#kec').html('');
            $('#kota').append('<option value="">[ Silahkan Pilih ]</option>');
            $('#kec').append('<option value="">[ Silahkan Pilih ]</option>');
            $('#kode_pos').val('');

            let id = $(this).val();
            let link = '{{ url("landing/get_kota") }}/'+id;
            $.get(link, function(res){

                let parse = JSON.parse(res);
                $.each(parse, function(i, e){
                    $('#kota').append('<option value="'+e.city_id+'" data-pos="'+e.postal_code+'">'+e.city_name+'</option>');
                });

            });

        });

        $('#kota').change(function(){

            $('#kec').html('');
            $('#kec').append('<option value="">[ Silahkan Pilih ]</option>');

            let id = $(this).val();
            let pos = $(this).find(':selected').attr('data-pos');
            $('#kode_pos').val(pos);
            let link = '{{ url("landing/get_kecamatan") }}/'+id;
            $.get(link, function(res){

                let parse = JSON.parse(res);
                $.each(parse, function(i, e){
                    $('#kec').append('<option value="'+e.subdistrict_id+'">'+e.subdistrict_name+'</option>');
                });

            });

        });

    });
</script>

@endsection