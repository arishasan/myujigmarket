@extends('landing.mainlayout')

@section('content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="#">Customer<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">Pengaturan</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<section class="product-area shop-sidebar shop section">
    <div class="container">
        
        <div class="row no-gutters">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 ">
                <!-- Product Slider -->
                    <div class="product-gallery">
                        <div class="single-slider">
                            <img src="{{ asset('assets/avatar.png') }}" alt="#" style="width: 100%; height: 100%; border-radius: 50%;">
                        </div>
                    </div>
                <!-- End Product slider -->
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                
                @include('admin.parts.feedback')

                <div class="quickview-content">
                    <h2 style="color: #F7941D"><i class="fa fa-pencil"></i> &nbsp; Edit Profile</h2>
                    <br/>
                    
                    <form action="{{ route('simpan-customer') }}" method="POST">
                        @csrf
                        <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                        <div class="quickview-peragraph">
                        
                            <div class="row align-items-center">
                                <div class="col-lg-2">
                                    <b>Nama</b>
                                </div>
                                <div class="col-lg">
                                    <input type="text" class="form-control" name="nama" value="{{ $user->name }}" style="padding-left: 10px; padding-right: 10px" required>
                                </div>
                            </div>
    
                            <div class="row mt-3 align-items-center">
                                <div class="col-lg-2">
                                    <b>Username</b>
                                </div>
                                <div class="col-lg">
                                    <input type="text" class="form-control" name="username" value="{{ $user->username }}" style="padding-left: 10px; padding-right: 10px" required>
                                    <small class="text-danger">(Biarkan apabila tidak diubah)</small>
                                </div>
                            </div>
    
                            <div class="row mt-3 align-items-center">
                                <div class="col-lg-2">
                                    <b>Email</b>
                                </div>
                                <div class="col-lg">
                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" style="padding-left: 10px; padding-right: 10px" required>
                                    <small class="text-danger">(Biarkan apabila tidak diubah)</small>
                                </div>
                            </div>
    
                            <div class="row mt-3 align-items-center">
                                <div class="col-lg-2">
                                    <b>Password</b>
                                </div>
                                <div class="col-lg">
                                    <input type="password" class="form-control" name="password" value="" style="padding-left: 10px; padding-right: 10px">
                                    <small class="text-danger">(Kosongkan apabila tidak diubah)</small>
                                </div>
                            </div>
    
                            <div class="row mt-3 align-items-center">
                                <div class="col-lg-2">
                                    <b>Confirm Password</b>
                                </div>
                                <div class="col-lg">
                                    <input type="password_confirmation" class="form-control" name="password_confirmation" value="" style="padding-left: 10px; padding-right: 10px">
                                    <small class="text-danger">(Kosongkan apabila tidak diubah)</small>
                                </div>
                            </div>
    
                        </div>
                        <br/>
                        <div class="add-to-cart">
                            <button class="btn" onclick="addCart()"><i class="fa fa-save"></i> Simpan</button>
                            <a href="{{ route('alamatku') }}" class="btn">Pengaturan Alamat <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

    </div>
</section>

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