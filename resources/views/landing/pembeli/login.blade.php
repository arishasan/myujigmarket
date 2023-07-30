@extends('landing.mainlayout')

@section('content')

<div class="container mt-5 mb-5">
    
    <div class="row">
        <div class="col-lg"></div>
        <div class="col-lg-4">
            @include('admin.parts.feedback')
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-lock"></i> Masuk Akun
                </div>
                <div class="card-body">
                    
                    <form action="{{ route('masuk-pembeli') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" style="height: 48px; padding-left: 10px; padding-right: 10px" class="form-control" id="username" name="username" placeholder="Masukkan Username..">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" style="height: 48px; padding-left: 10px; padding-right: 10px" class="form-control" name="password" placeholder="Masukkan Password..">
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                Belum punya akun?
                            </div>
                            <div class="col-lg-6 text-right">
                                <a href="{{ url('customer/register') }}" class="text-info">Daftar Disini</a>
                            </div>
                        </div>

                        <br/>

                        <button class="btn btn-primary text-white form-control">Masuk <i class="fa fa-sign-in"></i></button>

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