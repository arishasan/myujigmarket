@extends('landing.mainlayout')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')

<!-- Breadcrumbs -->
<!-- <div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="#">Customer<i class="ti-arrow-right"></i></a></li>
                        <li><a href="#">Pengaturan<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">Alamat</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- End Breadcrumbs -->

<div class="shopping-cart section">
    
    <div class="container">
        @include('admin.parts.feedback')

        <h3>Pengaturan Alamat</h3>
        <hr>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Data</a>
                <a class="nav-item nav-link" id="nav-tambah" data-toggle="tab" href="#nav-tambah1" role="tab" aria-controls="nav-tambah" aria-selected="false">Tambah Data</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="card">
                    <card class="body">
                        <div class="container p-5">
                            <table class="table" style="width: 100%" id="table">
                                <thead>
                                    <tr>
                                        <th width="5%"><center>No.</center></th>
                                        <th width="20%">Label</th>
                                        <th>Alamat</th>
                                        <th width="15%">Aksi</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alamat as $key => $item)
                                        
                                        <tr class="{{ $item->is_alamat_utama ? 'bg-success text-white' : '' }}">
                                            <td><center>{{ $key+1 }}.</center></td>
                                            <td>
                                                {{ $item->label }}
                                                @if($item->is_alamat_utama == false)
                                                <button style="padding: 5px;" class="bg-success text-white jadikan_utama" data-id="{{ $item->id }}" type="button">Jadikan Alamat Utama<i class="fa fa-check"></i></button>
                                                @endif
                                            </td>
                                            <td>

                                                <b>Penerima</b> : {{ $item->penerima }} <br/>
                                                <b>No. HP</b> : {{ $item->no_hp }} <br/>
                                                <b>Provinsi</b> : {{ App\Models\HelperModel::getAlamat($item->provinsi, 'prov') }} <br/>
                                                <b>Kota</b> : {{ App\Models\HelperModel::getAlamat($item->kota, 'kota') }} <br/>
                                                <b>Kecamatan</b> : {{ App\Models\HelperModel::getAlamat($item->kecamatan, 'kec') }} <br/>
                                                {{ $item->alamat }}
                                                
                                            </td>
                                            <td>
                                                
                                                <a href="{{ url('customer/akun/pengaturan/alamat/edit') }}/{{ md5($item->id) }}" style="padding: 10px;" class="bg-primary text-white"><i class="fa fa-edit"></i></a>
                                                @if($item->is_alamat_utama == false)
                                                <a href="javascript:void(0)" style="padding: 10px;" class="bg-danger text-white delete_alamat" data-id="{{ $item->id }}"><i class="fa fa-trash"></i></a>
                                                @endif

                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </card>
                </div>

            </div>
            <div class="tab-pane fade" id="nav-tambah1" role="tabpanel" aria-labelledby="nav-tambah">

                <div class="card">
                    <card class="body">
                        <div class="container p-5">
                            <form action="{{ url('customer/akun/simpan_alamat') }}" method="POST">
                                @csrf
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg">
                                            Label <sup style="color:red">*</sup>
                                            <input type="text" class="form-control" name="label" value="{{ old('label') }}" style="padding-left: 10px; padding-right: 10px" required>
                                        </div>
                                        <div class="col-lg">
                                            Kode Pos <sub style="color:red">(Terisi otomatis ketika memilih kota)</sub>
                                            <input type="text" class="form-control" name="kode_pos" id="kode_pos" value="{{ old('kode_pos') }}" style="padding-left: 10px; padding-right: 10px">
                                        </div>
                                        <div class="col-lg">
                                            Gunakan sebagai alamat utama
                                            <select name="alamat_utama" class="form-control">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg">
                                            Penerima <sup style="color:red">*</sup>
                                            <input type="text" class="form-control" name="penerima" value="{{ old('penerima') }}" style="padding-left: 10px; padding-right: 10px" required>
                                        </div>
                                        <div class="col-lg">
                                            Nomor HP <sup style="color:red">*</sup>
                                            <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp') }}" style="padding-left: 10px; padding-right: 10px" required>
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
                                                    <option value="{{ $v->province_id }}">{{ $v->province_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg">
                                            Kota <sup style="color:red">*</sup>
                                            <select name="kota" class="form-control" id="kota" required>
                                                <option value="">[ Silahkan Pilih ]</option>
                                            </select>
                                        </div>
                                        <div class="col-lg">
                                            Kecamatan <sup style="color:red">*</sup>
                                            <select name="kecamatan" class="form-control" id="kec" required>
                                                <option value="">[ Silahkan Pilih ]</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg">
                                            Alamat Lengkap / Deskripsi <sup style="color:red">*</sup>
                                            <textarea name="alamat" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button class="btn btn-success">Simpan</button>
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

        $(document).on('click', '.jadikan_utama', function(){

            let id = $(this).attr('data-id');
            Swal.fire({
            title: 'Perhatian...',
            text: "Jadikan alamat utama?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                        url: "{{ url('customer/akun/alamat/ganti_utama') }}",
                        type: "POST",
                        data: {
                            id: id
                        } ,
                        success: function (res) {

                            if(res == 'yes'){

                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Alamat utama berhasil diubah.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    location.reload();
                                });

                            }else{

                                Swal.fire({
                                    icon: 'info',
                                    title: 'Perhatian...',
                                    text: res,
                                });

                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        }
                    });

                }
            });

        });

        $(document).on('click', '.delete_alamat', function(){

            let id = $(this).attr('data-id');
            Swal.fire({
            title: 'Perhatian...',
            text: "Anda yakin akan menghapus alamat ini?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $.ajax({
                        url: "{{ url('customer/akun/alamat/hapus_alamat') }}",
                        type: "POST",
                        data: {
                            id: id
                        } ,
                        success: function (res) {

                            if(res == 'yes'){

                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Berhasil menghapus data alamat.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    location.reload();
                                });

                            }else{

                                Swal.fire({
                                    icon: 'info',
                                    title: 'Perhatian...',
                                    text: res,
                                });

                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        }
                    });

                }
            });

        });
        
        $('#table').DataTable();
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