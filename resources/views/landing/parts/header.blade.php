<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            <li><i class="ti-headphone-alt"></i> +62 831 1234 5678</li>
                            <li><i class="ti-email"></i> support@nusantarashop.com</li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-8 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            
                            @if(App\Models\HelperModel::getLoginPembeli())
                            <li><i class="ti-user"></i> <a href="{{ route('akunku') }}">{{ Session::get('sess_nama') }}</a></li>
                            <li><i class="ti-power-off"></i><a href="{{ route('logout-customer') }}">Logout</a></li>
                            @endif

                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('assets') }}/logoa.png" alt="logo"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form" action="{{ url('landing/produk/semua') }}" method="POST">
                                @csrf
                                <input name="cari" placeholder="Cari Produk Di sini....." type="text">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <form method="POST" action="{{ url('landing/produk/semua') }}">
                                @csrf
                                <input name="cari" placeholder="Cari Produk Di sini....." type="text">
                                <button class="btnn"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Search Form -->
                        @if(App\Models\HelperModel::getLoginPembeli())
                        <div class="sinlge-bar">
                            <a href="{{ route('wishlistku') }}" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div>
                        <div class="sinlge-bar">
                            <a href="{{ route('akunku') }}" class="single-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
                        </div>
                        <div class="sinlge-bar">
                            <a href="{{ route('keranjang-belanja') }}" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{ App\Models\HelperModel::getCount('cart') }}</span></a>
                        </div>
                        @else
                        <div class="sinlge-bar">
                            <a href="{{ url('customer/login') }}" class="single-icon"><small>Login <i class="fa fa-sign-in" aria-hidden="true"></i></small></a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    {{-- <div class="col-lg-3">
                        <div class="all-category">
                            <h3 class="cat-heading"><i class="fa fa-bars" aria-hidden="true"></i>CATEGORIES</h3>
                            <ul class="main-category">
                                <li><a href="#">New Arrivals <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                    <ul class="sub-category">
                                        <li><a href="#">accessories</a></li>
                                        <li><a href="#">best selling</a></li>
                                        <li><a href="#">top 100 offer</a></li>
                                        <li><a href="#">sunglass</a></li>
                                        <li><a href="#">watch</a></li>
                                        <li><a href="#">man’s product</a></li>
                                        <li><a href="#">ladies</a></li>
                                        <li><a href="#">westrn dress</a></li>
                                        <li><a href="#">denim </a></li>
                                    </ul>
                                </li>
                                <li class="main-mega"><a href="#">best selling <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                    <ul class="mega-menu">
                                        <li class="single-menu">
                                            <a href="#" class="title-link">Shop Kid's</a>
                                            <div class="image">
                                                <img src="https://via.placeholder.com/225x155" alt="#">
                                            </div>
                                            <div class="inner-link">
                                                <a href="#">Kids Toys</a>
                                                <a href="#">Kids Travel Car</a>
                                                <a href="#">Kids Color Shape</a>
                                                <a href="#">Kids Tent</a>
                                            </div>
                                        </li>
                                        <li class="single-menu">
                                            <a href="#" class="title-link">Shop Men's</a>
                                            <div class="image">
                                                <img src="https://via.placeholder.com/225x155" alt="#">
                                            </div>
                                            <div class="inner-link">
                                                <a href="#">Watch</a>
                                                <a href="#">T-shirt</a>
                                                <a href="#">Hoodies</a>
                                                <a href="#">Formal Pant</a>
                                            </div>
                                        </li>
                                        <li class="single-menu">
                                            <a href="#" class="title-link">Shop Women's</a>
                                            <div class="image">
                                                <img src="https://via.placeholder.com/225x155" alt="#">
                                            </div>
                                            <div class="inner-link">
                                                <a href="#">Ladies Shirt</a>
                                                <a href="#">Ladies Frog</a>
                                                <a href="#">Ladies Sun Glass</a>
                                                <a href="#">Ladies Watch</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="#">accessories</a></li>
                                <li><a href="#">top 100 offer</a></li>
                                <li><a href="#">sunglass</a></li>
                                <li><a href="#">watch</a></li>
                                <li><a href="#">man’s product</a></li>
                                <li><a href="#">ladies</a></li>
                                <li><a href="#">westrn dress</a></li>
                                <li><a href="#">denim </a></li>
                            </ul>
                        </div>
                    </div> --}}
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">	
                                    <div class="nav-inner">	
                                        <ul class="nav main-menu menu navbar-nav">
                                                <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                                                <li class="{{ Request::is('landing/produk') ? 'active' : '' }}"><a href="{{ url('landing/produk/semua') }}">Semua Produk</a></li>												
                                                <li><a href="#">Tentang Kami</a></li>
                                                @if(App\Models\HelperModel::getLoginPembeli())
                                                <li class="{{ Request::is('customer/keranjang') ? 'active' : '' }}"><a href="{{ route('keranjang-belanja') }}">Keranjang Belanja</a></li>									
                                                <li class="{{ Request::is('customer/akun/*') ? 'active' : '' }}"><a href="#">Akun Ku<i class="ti-angle-down"></i></a>
                                                    <ul class="dropdown">
                                                        <li class="{{ Request::is('customer/akun/wishlist') ? 'active' : '' }}"><a href="{{ route('wishlistku') }}">Wishlist</a></li>
                                                        <li class="{{ Request::is('customer/akun/history_transaksi') ? 'active' : '' }}"><a href="{{ route('historyku') }}">History Transaksi</a></li>
                                                        <li class="{{ Request::is('customer/akun/pengaturan') ? 'active' : '' }}"><a href="{{ route('akunku') }}">Pengaturan Akun</a></li>
                                                        <li><a href="{{ route('logout-customer') }}">Logout</a></li>
                                                    </ul>
                                                </li>
                                                @endif
                                            </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>