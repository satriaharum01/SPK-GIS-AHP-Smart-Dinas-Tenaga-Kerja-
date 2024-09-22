@extends('template.layout')

@section('css')
<style type="text/css">
    #direction_details,
    #directions_panel {
        font-size: 12px;
    }
</style>
@endSection()

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 stretch-card">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h3 class="card-title">Data <?= ucfirst($title) ?></h3>
                </div>
                <div class="card-body">
                    <p>Detail Kriteria</p>
                    <div class="row">
                        <div class="modal-body col-lg-6"> 
                            <div class="form-group">
                                <label>Nama Kriteria</label>
                                <input type="text"  value="{{$load->nama}}"  maxlength="5" name="nama_kriteria" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Bobot</label>
                                <input type="number" name="bobot_kriteria" value="{{$load->bobot}}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="modal-body col-lg-12"> 
                            <button type="button" class="btn btn-primary btn-add" style="float: right;" data-toggle="modal" data-target="#compose"><i class="fa fa-plus"></i> Tambah Data 
                            </button>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datawidth" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="8%" style="text-align:center; vertical-align: middle;">No</th>
                                            <th width="45%" style="text-align:center; vertical-align: middle;">Nama Sub Kriteria</th>
                                            <th style="text-align:center; vertical-align: middle;">Nilai</th>
                                            <th style="text-align:center; vertical-align: middle;">#</th>
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

<!-- ============ MODAL DATA JADWAL =============== -->

<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center><b>
                    <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4></b></center>    
                </div>
                <form action="#" method="POST" id="compose-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body"> 
                    <div class="form-group">
                        <label>Nama Sub Kriteria</label>
                        <input type="text" name="id_kriteria" value="{{$load->id_kriteria}}" class="form-control" hidden>
                        <input type="text" name="nama_sub" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nilai</label>
                        <input type="text" name="nilai" class="form-control" required>
                    </div>
                    <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                </div>
                </form>
            </div>
        </div>
</div>
<!--- END MODAL DATA JADWAL--->
@endsection

@section('js')
<script>
    $(function() {
        table = $('#datawidth').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: '{{url("$page/json/$load->id_kriteria")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama'
                },
                {
                    data: 'nilai'
                },
                {
                    data: 'id_pil_kriteria',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> </button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="subkriteria" href="<?= url('admin/kriteria/subkriteria/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i> </a> \
					    <form id="delete-form-' + data + '-subkriteria" action="<?= url('admin/kriteria/subkriteria/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>'
                    }
                },
            ]
        });

    });

    //Button Trigger
    $("body").on("click",".btn-add",function(){
        kosongkan();
        jQuery("#compose-form").attr("action",'<?=url($page);?>/save');
        jQuery("#compose .modal-title").html("Tambah <?=$title;?>");
        jQuery("#compose").modal("toggle");  
    });

    $("body").on("click",".btn-edit",function(){
        var id = jQuery(this).attr("data-id");
                    
        $.ajax({
            url: "<?=url($page);?>/find/"+id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function (dataResult) { 
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData,function(index,row){
                    jQuery("#compose-form input[name=nama_sub]").val(row.nama);
                    jQuery("#compose-form input[name=nilai]").val(row.nilai);
                })
            }
        });
        jQuery("#compose-form").attr("action",'<?=url($page);?>/update/'+id);
        jQuery("#compose .modal-title").html("Update <?=$title?>");
        jQuery("#compose").modal("toggle");
    });
    
    $("body").on("click",".btn-simpan",function(){
        Swal.fire(
            'Data Disimpan!',
            '',
            'success'
            )
    });
        
    function kosongkan()
    {
        jQuery("#compose-form input[name=nama_sub]").val("");
        jQuery("#compose-form input[name=nilai]").val("");
    }
</script>
@endsection