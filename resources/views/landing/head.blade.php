<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>{{ config('app.name') }} - {{$title}}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/main_logo.gif') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('landing/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/bower_components/font-awesome-free-6/css/all.css') }}">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('map/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('landing/css/style.css') }}" rel="stylesheet">
    <!-- SweetAlert 2 -->
    <script src="{{ asset('dist/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <link rel="{{ asset('dist/sweetalert2/sweetalert2.min.css') }}">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <style>
        .form-group{
            margin: 1rem;
        }

        .nav-link.active {
            background-color: #13b56a;
            color: white !important;
        }

        div .content-side{
            overflow-y: hidden;
        }

        div .content-side:hover{
            overflow-y: scroll;
        }

        .mapouter {
            position: relative;
            text-align: right;
            height: 100%;
            width: 100%;
        }

        .map-box {
            margin: auto;
            height: 73vh;
            width: 100%;
        }

        .gmap_canvas {
            overflow: hidden;
            background: none !important;
            height: 100%;
            width: 100%;
        }

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

        #petapublic{        
            width: 100%;
            position: absolute;
            height: 82%;
        }
    </style>
    @yield('css')
</head>
<!-- Validator -->
<?php if (isset($validation)) : ?>
    <div class="alert alert-danger alert-error"><?= $validation->listErrors() ?></div>
<?php endif; ?>

<body id="page-top">
    <!-- Topbar --><!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container px-5" >
            <a class="navbar-brand fw-bold" href="#page-top"><img src="{{ asset('images/main_logo.gif') }}" class="navbar-brand-img h-100" style="width: 3rem; margin-left:-5rem;" alt="main_logo"><span style="margin-left:2rem;">{{env('APP_NAME')}}</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('peta')) ? 'active' : '' }} me-lg-3 rounded-pill px-3 mb-2 mb-lg-0" href="{{url('/peta')}}">
                            <svg class="icon">
                                <use xlink:href="{{asset('vendors')}}/@coreui/icons/svg/free.svg#cil-map"></use>
                            </svg> Peta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('jalan')) ? 'active' : '' }} me-lg-3 rounded-pill px-3 mb-2 mb-lg-0" href="{{url('/jalan')}}">
                            <i class="fa-solid fa-route"></i> 
                            Jalan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('pengaduan')) ? 'active' : '' }} me-lg-3 rounded-pill px-3 mb-2 mb-lg-0" href="{{route('pengaduan')}}">
                            <i class="fa-solid fa-flag"></i> 
                            Pengaduan
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav my-3 my-lg-0 dropdown" >
                    <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md">
                            <img class="avatar-img" src="{{asset('landing')}}/img/avatars/default.png" alt="Login">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pt-0">
                        <?php if (isset(Auth::user()->id)) { ?>
                            <a class="dropdown-item" href="{{route('admin.dashboard')}}">
                                <i class="fa fa-dashboard"> </i> Beranda</a>
                            <a class="dropdown-item btn-password" href="#" >
                                <i class="fa fa-key icon me-2"></i> Ganti Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                                <i class="fa fa-sign-out-alt"></i> Logout
                            </a>
                        <?php } else { ?>
                            <a class="dropdown-item" href="{{ route('login') }}">
                            <i class="fa fa-sign-in"></i> Login</a>
                        <?php } ?>
                    </div>
                </ul>
            </div>
        </div>
        
    </nav>
    @yield('content')
    <!-- End of Content Wrapper -->
    <!-- End of Page Wrapper -->
    <!-- jQuery 3 -->
    
    <!-- Logout Modal-->
    <div class="modal fade" id="gantipasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                    <button class="close" type="button" data-coreui-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{url('set_password')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger text-white" type="button" data-coreui-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Simpan</a>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('landing/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('landing/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script>
        $("body").on("click",".btn-password",function(){
            jQuery("#gantipasswordModal").modal("toggle");  
        });
    </script>
    @yield('custom_script')
