<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} - {{$title}}</title>
    <link href="{{ asset('landing/login/img/logo.gif') }}" rel="icon">
    <!-- CSS files -->
    @include('template/css')
    @yield('css')
    <style>
        .new-alert {
            position: relative;
            padding: 0.75rem;
            margin-bottom: 1rem;
            margin-top: 1rem;
            border: 1px solid transparent;
            border-radius: 0.35rem
        }

        .alert-error {
            position: absolute;
            width: 100%;
            top: 0;
            z-index: 100;
        }
    </style>
  <!-- base:css -->
  <link rel="stylesheet" href="{{asset('vendors')}}/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{asset('vendors')}}/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<!-- Validator -->
<?php

use Illuminate\Support\Facades\Auth;

if (isset($validation)) : ?>
    <div class="alert alert-danger alert-error"><?= $validation->listErrors() ?></div>
<?php endif; ?>

<body>
  <div class="container-scroller d-flex">
        <?php if (@!$hide_header) : ?>
            @include('template.header')
        <?php endif; ?>
       <!-- partial:../../partials/_sidebar.html -->
      <div class="container-fluid page-body-wrapper">
        <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="navbar-brand-wrapper mx-2">
          </div>
          <h4 class="font-weight-bold mb-0 d-none d-md-block mt-1 text-primary">Selamat Datang, {{ucwords(Auth::user()->name)}}</h4>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item">
              <h4 class="mb-0 font-weight-bold d-none d-xl-block text-primary">{{date('d F Y')}}</h4>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
          </div>
          <div class="navbar-menu-wrapper navbar-search-wrapper d-none d-lg-flex align-items-center" style="opacity:0;">
            <ul class="navbar-nav mr-lg-2">
              <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="#" aria-label="search" aria-describedby="search">
                </div>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              
            </ul>
          </div>
        </nav>
        <!-- partial -->
            @yield('content')    
            <!-- partial:../../partials/_footer.html -->
            @include('template.footer')
        </div>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- Libs JS -->
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row">
                    <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Akan Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" Untuk Mengakhiri Sesi.</div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                    <a class="btn btn-primary" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </div>
    </div>
    @include('template.js')
    @yield('js')
</body>

</html>