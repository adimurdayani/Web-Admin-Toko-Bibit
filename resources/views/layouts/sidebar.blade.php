<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{ asset('dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image"
          style="opacity: .8">
      <span class="brand-text font-weight-light">Toko Bibit</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>
      @if (Auth::user()->user_id == "seller")
<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
          <li class="nav-item has-treeview">
            <a href="{{ route('home') }}" class="nav-link @if (Request::segment(1) == 'home') active @endif">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-header">MODUL</li>

          <li class="nav-item">
            <a href="{{ route('produk.index') }}" class="nav-link  @if (Request::segment(1) == 'produk') active @endif">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Produk
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('transaksi') }}" class="nav-link  @if (Request::segment(1) == 'transaksi') active @endif">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Transaksi
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview @if (Request::segment(1) == 'profile') menu-open @elseif (Request::segment(1) == "user") menu-open @endif">
            <a href="#" class="nav-link @if (Request::segment(1) == 'profile') active @elseif (Request::segment(1) == "user") active @endif">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Setting
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link @if (Request::segment(1) == 'user') active @endif">
                  <i class="fas fa-users-cog nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('profile.index') }}" class="nav-link @if (Request::segment(1) == 'profile') active @endif">
                  <i class="far fa-user nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
            </ul>
          </li>

           <li class="nav-item">
            <a href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();" class="nav-link">
              <i class="nav-icon fa fa-power-off"></i>
              <p>
                {{ __('Logout') }}
              </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
      @endif
      
    </div>
    <!-- /.sidebar -->
  </aside>