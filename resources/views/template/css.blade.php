   
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendors/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('landing/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/bower_components/font-awesome-free-6/css/all.css') }}">
    <!-- SweetAlert 2 -->
    <script src="{{ asset('dist/sweetalert2/sweetalert2.all.min.js') }}">
    </script>
    <link rel="{{ asset('dist/sweetalert2/sweetalert2.min.css') }}">
    <style>
        .form-control-2 {
            display: block;
            width: 100%;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #6e707e;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        svg.menu-icon{
            width: 1rem;
            height: 1rem;
            font-size: 1.125rem;
            line-height: 1;
            margin-right: 1.125rem;
            color: #ffffff;
        }
    </style>