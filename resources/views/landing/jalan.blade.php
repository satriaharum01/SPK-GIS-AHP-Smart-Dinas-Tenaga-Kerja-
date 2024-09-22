@extends('landing.head')
@section('css')
     <link rel="stylesheet" href="{{asset('vendors')}}/css/vendor.bundle.base.css">
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendors/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <style>
    .table-bordered {
      border: 1px solid #f3f3f3;
    }
    
    .table-bordered th,
    .table-bordered td {
      border: 1px solid #f3f3f3;
    }
    
    .table-bordered thead th,
    .table-bordered thead td {
      border-bottom-width: 2px;
    }
    .text-left{
        text-align:left;
    }
    </style>
@endsection
@section('content')
<!-- End of Topbar -->

<nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #13b56a;">
    <div class="container mx-auto">
    </div>
</nav>
<div class="container-fluid page-body-wrapper p-5">
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 stretch-card">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="datawidth" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="8%" style="text-align:center; vertical-align: middle;">No</th>
                                <th width="45%" style="text-align:center!important; vertical-align: middle;">Nama Jalan</th>
                                <th style="text-align:center; vertical-align: middle;">Ruas Jalan</th>
                                <th style="text-align:center; vertical-align: middle;">Keterangan</th>
                                <th width="10%" style="text-align:center; vertical-align: middle;">#</th>
                            </tr>
                        </thead>
                        <tbody style="text-align:center; vertical-align: middle;">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- content-wrapper ends -->
<!-- /.container-fluid -->

<!-- ============ MODAL DATA ANGGARAN =============== -->
<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <center><b>
                <h4 class="modal-title" id="exampleModalLabel">Data Anggaran</h4></b></center>    
            </div>
            <div class="modal-body"> 
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="data-anggaran" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Tahun</th>
                                    <th style="text-align:center;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody style="text-align:center;">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-pill text-white" data-coreui-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- END MODAL DATA ANGGARAN --->
@endsection
@section('custom_script')
<script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
<!-- Page level plugins -->
<script src="{{ asset('vendors/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendors/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('js/dashboard-chart-area.js')}}"></script>
<script>
    let stat = '';
    $(function() {
        table = $('#datawidth').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{url("/get/jalan/json")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_alternatif', className: 'text-left'
                },
                {
                    data: 'ruas_jalan', render: function(data){
                        return data + ' Km';
                    }
                },
                {
                    data: 'keterangan', render: function(data)
                    {
                        if(data != 'Anggaran sudah dibuat')
                        {
                            stat = 'disabled';
                        }else{
                            stat = '';
                        }
                        return data;
                    }
                },
                {
                    data: 'id_alternatif',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-primary btn-eye text-white" data-id="' + data + '" '+stat+'><i class="fa fa-eye"></i> </button>';
                    }
                },
            ]
        });

        table1 = $('#data-anggaran').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: '{{url("/get/anggaran/0/json")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tahun'
                },
                {
                    data: 'jumlah', render: function(data){
                        return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
                    }
                }
            ]
        });
    });
    $("body").on("click",".btn-eye",function(){
        var id = jQuery(this).attr("data-id");

        table1.ajax.url('/get/anggaran/'+id+'/json').load();

        jQuery("#compose").modal("toggle");
    });
</script>
</body>
</html>
@endsection