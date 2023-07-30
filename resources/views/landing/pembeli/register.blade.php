@extends('landing.mainlayout')

@section('content')

<div class="container mt-5 mb-5">
    
    <div class="row">
        <div class="col-lg"></div>
        <div class="col-lg-5">
            
            @include('admin.parts.feedback')

            <div class="card">
                <div class="card-header">
                    <i class="fa fa-lock"></i> Daftar Akun
                </div>
                <div class="card-body">
                    
                    <form action="{{ route('daftar-pembeli') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="nama">Nama <sup class="text-danger">*</sup></label>
                            <input type="text" style="height: 48px; padding-left: 10px; padding-right: 10px" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap.." value="{{ old('nama') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="username">Username <sup class="text-danger">*</sup></label>
                            <input type="text" style="height: 48px; padding-left: 10px; padding-right: 10px" class="form-control" id="username" name="username" placeholder="Tentukan Username.." value="{{ old('username') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email <sup class="text-danger">*</sup></label>
                            <input type="email" style="height: 48px; padding-left: 10px; padding-right: 10px" class="form-control" id="email" name="email" placeholder="Tentukan Email.." value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password <sup class="text-danger">*</sup></label>
                            <input type="password" style="height: 48px; padding-left: 10px; padding-right: 10px" class="form-control" id="password" name="password" placeholder="Buat Password Baru.." required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password <sup class="text-danger">*</sup></label>
                            <input type="password" style="height: 48px; padding-left: 10px; padding-right: 10px" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password Baru.." required>
                        </div>

                        <br/>

                        <button class="btn btn-primary form-control">Daftar <i class="fa fa-sign-in"></i></button>

                    </form>

                </div>
            </div>
        </div>
        <div class="col-lg"></div>
    </div>
    
</div>

@endsection

@section('scriptplus')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(function(){
       
    });
</script>

@endsection