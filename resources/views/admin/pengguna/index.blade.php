@extends('template.layout');
@section('content')



<!-- Page Heading
<h1 class="h3 mb-2 text-gray-800">Tables</h1>
<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>
 -->
<!-- DataTales Example -->
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
                        <th width="15%" style="text-align:center; vertical-align: middle;">Nama Pengguna</th>
                        <th width="20%" style="text-align:center; vertical-align: middle;">Email</th>
                        <th width="15%" style="text-align:center; vertical-align: middle;">No HP</th>
                        <th width="20%" style="text-align:center; vertical-align: middle;">Sekolah</th>
                        <th style="text-align:center; vertical-align: middle;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="text-align:center; vertical-align: middle;">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============ MODAL DATA JADWAL =============== -->

<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <center><b>
                <h4 class="modal-title" id="exampleModalLabel">Tambah Sekolah</h4></b></center>    
            </div>
            <form action="#" method="POST" id="compose-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body"> 
                    <div class="form-group">
                        <label>Nama Pengguna</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email Pengguna</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>No Hp</label>
                        <input type="number" name="no_hp" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah ...">
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <input type="text" name="level" class="form-control" value="Operator" readonly>
                    </div>
                    <div class="form-group">
                        <label>Sekolah</label>
                        <select name="id_sekolah" id="id_sekolah" class="form-control">
                            <option value="0" selected disabled> -- Pilih Sekolah --</option>
                        </select>
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
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'no_hp'
                },
                {
                    data: 'sekolah'
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> Edit</button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="pengguna" href="<?= url('admin/pengguna/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i> Hapus</a> \
					    <form id="delete-form-' + data + '-pengguna" action="<?= url('admin/pengguna/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>'
                    }
                },
            ]
        });

        $.ajax({
            url: "{{ url('/admin/sekolah/json')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                    $('#id_sekolah').append('<option value="' + row.id_sekolah + '">' + row.nama_sekolah + '</option>');
                })
            }
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
                    jQuery("#compose-form input[name=nama]").val(row.name);
                    jQuery("#compose-form input[name=email]").val(row.email);
                    jQuery("#compose-form input[name=no_hp]").val(row.no_hp);
                    jQuery("#compose-form select[name=id_sekolah]").val(row.id_sekolah);
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
        jQuery("#compose-form input[name=email]").val("");
        jQuery("#compose-form input[name=no_hp]").val("");
        jQuery("#compose-form select[name=id_sekolah]").val(0);
    }
</script>
@endSection