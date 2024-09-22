@extends('template.layout')
@section('content')

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 stretch-card">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-primary btn-add" style="float: right;" data-toggle="modal" data-target="#compose"><i class="fa fa-plus"></i> Tambah Data 
                </button>
                <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="datawidth" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="8%" style="text-align:center; vertical-align: middle;">No</th>
                                <th width="45%" style="text-align:center; vertical-align: middle;">Nama Jalan</th>
                                <th style="text-align:center; vertical-align: middle;">Ruas Jalan</th>
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
@endSection()
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
                    data: 'nama_alternatif'
                },
                {
                    data: 'ruas_jalan', render: function(data){
                        return data + ' Km';
                    }
                },
                {
                    data: 'id_alternatif',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> </button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="alternatif" href="<?= url('admin/alternatif/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i> </a> \
					    <form id="delete-form-' + data + '-alternatif" action="<?= url('admin/alternatif/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>'
                    }
                },
            ]
        });

    });

    //Button Trigger
    $("body").on("click",".btn-add",function(){
        window.location.href = "{{route('alternatif.baru')}}";
    });

    $("body").on("click",".btn-edit",function(){
        var id = jQuery(this).attr("data-id");
                    
        window.location.href = "{{url('admin/alternatif/edit')}}/"+id;
    });
    
</script>
@endSection