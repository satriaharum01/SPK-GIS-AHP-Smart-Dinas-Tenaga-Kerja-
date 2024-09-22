
    <!-- partial:./partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        @if(Auth::user()->level == 'Admin')
        <li class="nav-item sidebar-category">
          <p>Navigasi</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('admin.dashboard')}}">
            <i class="mdi mdi-view-quilt menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item sidebar-category">
          <p>Master Data</p>
          <span></span>
        </li>
        <li class="nav-item {{ (request()->is('admin/alternatif/')) ? 'active' : '' }}{{ (request()->is('admin/alternatif/*')) ? 'active' : '' }}">
          <a class="nav-link" href="{{route('admin.alternatif')}}">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">Data Jalan</span>
          </a>
        </li>
        <li class="nav-item {{ (request()->is('admin/kriteria/')) ? 'active' : '' }}{{ (request()->is('admin/kriteria/*')) ? 'active' : '' }}">
          <a class="nav-link" href="{{route('admin.kriteria')}}">
            <i class="mdi mdi-label menu-icon"></i>
            <span class="menu-title">Kriteria</span>
          </a>
        </li>
        <li class="nav-item {{ (request()->is('admin/nilai/')) ? 'active' : '' }}">
          <a class="nav-link" href="{{route('admin.nilai_alternatif')}}">
            <i class="mdi mdi-database menu-icon"></i>
            <span class="menu-title">Data Nilai Jalan</span>
          </a>
        </li>
        <li class="nav-item sidebar-category">
          <p>Other</p>
          <span></span>
        </li>
        <li class="nav-item {{ (request()->is('admin/rangking/')) ? 'active' : '' }}">
          <a class="nav-link" href="{{route('admin.rangking')}}">
            <i class="mdi mdi-bell-ring menu-icon"></i>
            <span class="menu-title">Rekomendasi Perbaikan </span>
          </a>
        </li>
        @else
        <li class="nav-item sidebar-category">
          <p>Master Data</p>
          <span></span>
        </li>
        <li class="nav-item {{ (request()->is('pimpinan/jalan')) ? 'active' : '' }}{{ (request()->is('pimpinan/jalan/*')) ? 'active' : '' }}">
          <a class="nav-link" href="{{route('pimpinan.jalan')}}">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">Data Jalan</span>
          </a>
        </li>
        <li class="nav-item {{ (request()->is('pimpinan/pengaduan')) ? 'active' : '' }}{{ (request()->is('pimpinan/pengaduan/*')) ? 'active' : '' }}">
          <a class="nav-link" href="{{route('pimpinan.pengaduan')}}">
            <i class="mdi mdi-flag menu-icon"></i>
            <span class="menu-title">Data Pengaduan</span>
          </a>
        </li>
        @endif
        <li class="nav-item">
          <a class="nav-link" href="{{route('home.page')}}">
          <svg class="menu-icon">
            <use xlink:href="{{asset('vendors')}}/@coreui/icons/svg/free.svg#cil-map"></use>
          </svg>
          <span class="menu-title">Peta</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="mdi mdi-logout menu-icon"></i>
              <span class="menu-title">Logout</span>
          </a>
        </li>
      </ul>
    </nav>