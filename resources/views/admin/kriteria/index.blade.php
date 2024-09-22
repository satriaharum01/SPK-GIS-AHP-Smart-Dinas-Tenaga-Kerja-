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
                                <th width="25%" style="text-align:center; vertical-align: middle;">Nama Kriteria</th>
                                <th style="text-align:center; vertical-align: middle;">Bobot</th>
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
                    <label>Urutan Kriteria</label>
                    <input type="number" name="urutan_order" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Nama Kriteria</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Bobot</label>
                    <input type="number" name="bobot" step="0.00001" class="form-control" required>
                </div>
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
            </div>
          </form>
      </div>
  </div>
</div>
<!--- END MODAL DATA JADWAL--->

<!-- /.container-fluid -->
@endSection()
@section('js')
<script>
    $(function() {
        table = $('#datawidth').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
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
                    data: 'nama'
                },
                {
                    data: 'bobot'
                },
                {
                    data: 'id_kriteria',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<a href="<?= url('admin/kriteria/subkriteria/get') ?>/' + data + '" type="button" class="btn btn-primary btn-eye" data-id="' + data + '"><i class="fa fa-eye"></i> </a>\
                        <button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> </button>';
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
                    jQuery("#compose-form input[name=nama]").val(row.nama);
                    jQuery("#compose-form input[name=bobot]").val(row.bobot);
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
        jQuery("#compose-form input[name=nama]").val("");
        jQuery("#compose-form input[name=bobot]").val("");
    }
</script>
@endSection