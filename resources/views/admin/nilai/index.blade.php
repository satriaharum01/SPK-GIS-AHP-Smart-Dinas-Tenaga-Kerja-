@extends('template.layout')
@section('content')



<!-- Page Heading
<h1 class="h3 mb-2 text-gray-800">Tables</h1>
<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>
 -->
<!-- DataTales Example -->
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
                                        <th width="25%" style="text-align:center; vertical-align: middle;">Nama Jalan</th>
                                        @foreach($kriteria as $row)
                                        <th style="text-align:center; vertical-align: middle;">{{$row->nama}}</th>
                                        @endforeach
                                        <th width="15%" style="text-align:center; vertical-align: middle;">#</th>
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
                        <label>Nama Alternatif</label>
                        <input type="text" name="nama" class="form-control" required readonly>
                    </div>
                    @foreach($kriteria as $row)
                    <div class="form-group">
                        <label>{{$row->nama}}</label>
                        <select name="C{{$row->urutan_order}}" id="C{{$row->urutan_order}}" class="form-control">
                            <option value="0" selected disabled>-- Pilih {{$row->nama}} --</option>
                            @foreach(${'C'.$row->urutan_order} as $row)
                            <option value="{{$row->nilai}}">{{$row->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endforeach
                    
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
                    data: 'nama_alt'
                },
                @foreach($kriteria as $row)
                {
                    data: 'C{{$row->urutan_order}}'
                },
                @endforeach
                {
                    data: 'id_alternatif',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> </button>';
                    }
                },
            ]
        });

    });

    //Button Trigger
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
                    jQuery("#compose-form input[name=nama]").val(row.nama_alternatif);
                    @foreach($kriteria as $row)
                    jQuery("#compose-form select[name=C{{$row->urutan_order}}]").val(row.C{{$row->urutan_order}});
                    @endforeach
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
        
</script>
@endSection