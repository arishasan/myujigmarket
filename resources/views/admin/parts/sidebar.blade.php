<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin') }}" class="brand-link">
      <img src="{{ asset('new') }}/images/mm.png" alt="AdminLTE Logo" class="brand-image">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets') }}/avatar.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth()->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">Main</li>
          <li class="nav-item">
            <a href="{{ route('admin') }}" class="nav-link {{ Request::is('admin') ? 'active' : '' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item {{ Request::is('master/*') ? 'menu-open' : '' }}"> <!-- menu-open -->
            <a href="#" class="nav-link {{ Request::is('master/*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <!-- <li class="nav-item">
                <a href="{{ route('rekening') }}" class="nav-link {{ Request::is('master/rekening') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rekening</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{ route('banner') }}" class="nav-link {{ Request::is('master/banner') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Banner</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="{{ route('kode-promo') }}" class="nav-link {{ Request::is('master/kode_promo') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kode Promo</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{ route('kategori') }}" class="nav-link {{ Request::is('master/kategori') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('produk') }}" class="nav-link {{ Request::is('master/produk') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produk</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('data-pesanan') }}" class="nav-link {{ Request::is('pesanan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>Pesanan</p>
            </a>
          </li>

          <li class="nav-header">System</li>
          <li class="nav-item">
            <a href="{{ route('data-admin') }}" class="nav-link {{ Request::is('sys/admin') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>User Admin</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('data-pembeli') }}" class="nav-link {{ Request::is('sys/pembeli') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>User Pembeli</p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>