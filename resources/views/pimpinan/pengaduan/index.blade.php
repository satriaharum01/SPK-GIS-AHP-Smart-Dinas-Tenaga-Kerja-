@extends('template.layout')
@section('content')
<!-- partial -->
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
                                <th style="text-align:center; vertical-align: middle;">Tanggal</th>
                                <th style="text-align:center; vertical-align: middle;">Pelapor</th>
                                <th width="45%" style="text-align:center!important; vertical-align: middle;">Nama Jalan</th>
                                <th width="25%" style="text-align:center; vertical-align: middle;">#</th>
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
  <!-- content-wrapper ends -->
<!-- /.container-fluid -->
@endSection
@section('js')
<script>
    $(function() {
        table = $('#datawidth').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{url("$page/json")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'pelapor'
                },
                {
                    data: 'jalan', className: 'text-left'
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-primary btn-eye" data-id="' + data + '"><i class="fa fa-eye"></i> </button>';
                    }
                },
            ]
        });

    });
    
    $("body").on("click",".btn-eye",function(){
        var id = jQuery(this).attr("data-id");
                    
        window.location.href = "{{url('pimpinan/pengaduan/lihat')}}/"+id;
    });
</script>
@endSection