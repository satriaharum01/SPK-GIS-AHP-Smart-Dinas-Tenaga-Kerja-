@extends('template.layout')
@section('css')
<style>
    #petapublic{        
            width: 100%;
            position: absolute;
            height: 100%;
        }
    .gmap_canvas {
            overflow: hidden;
            background: none !important;
            height: 100%;
            width: 100%;
        }
</style>
@endsection
@section('content')

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <div id="petapublic"> 
                <div class="gmap_canvas" id="map">
                </div>
            </div>
        </div>
        <div class="col-lg-6 stretch-card">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary" style="padding: 12px 6px;">{{$title}}</h6>
                </div>
                <div class="card-body">
                    <form action="{{url('/admin/alternatif/update/'.$load->id_alternatif)}}" method="post" id="compose-form">
                        @csrf
                        <div class="modal-body"> 
                            <div class="form-group">
                                <label>Nama Jalan</label>
                                <input type="text" name="id_alternatif" class="form-control" value="{{$load->id_alternatif}}" hidden>
                                <input type="text" name="nama_alternatif" class="form-control" value="{{$load->nama_alternatif}}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Ruas Jalan</label>
                                <input type="number" name="ruas_jalan" class="form-control" value="{{$load->ruas_jalan}}" step="0.001" readonly>
                            </div>
                            <div class="form-group">
                                <label>Cordinat Jalan</label>
                                <input type="text" name="cordinat" class="form-control" value="{{$load->cordinat}}" readonly>
                            </div>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#compose">Lihat Anggaran</button>
                            <button type="button" class="btn btn-primary btn-tambah">Buat Anggaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
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
                        <table class="table table-bordered" id="datawidth" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Tahun</th>
                                    <th style="text-align:center;">Jumlah</th>
                                    <th width="15%" style="text-align:center;">#</th>
                                </tr>
                            </thead>
                            <tbody style="text-align:center;">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- END MODAL DATA ANGGARAN --->
<!-- ============ MODAL DATA TAMBAH =============== -->
<div class="modal fade" id="anggaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <center><b>
                <h4 class="modal-title" id="exampleModalLabel2">Tambah Data Anggaran</h4></b></center>    
            </div>
            <form action="#" method="POST" id="anggaran-form" enctype="multipart/form-data">
              @csrf
                <div class="modal-body"> 
                    <div class="form-group">
                        <label>Nama Jalan</label>
                        <input type="text" name="id_alternatif" class="form-control" value="{{$load->id_alternatif}}" hidden>
                        <input type="text" name="nama_alternatif" class="form-control" value="{{$load->nama_alternatif}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="number" name="tahun" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- END MODAL DATA TAMBAH --->
<!-- /.container-fluid -->
@endSection()
@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDo9HRRCCPaSc56lFFDzT2V0xOYPI8OA9U&callback=initMap&libraries=places&v=weekly&language=id&region=ID" async></script>
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
                    data: 'tahun'
                },
                {
                    data: 'jumlah', render: function(data){
                        return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '" data-dismiss="modal"><i class="fa fa-edit"></i> </button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="anggaran" href="<?= url('/pimpinan/jalan/anggaran/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i> </a> \
					    <form id="delete-form-' + data + '-anggaran" action="<?= url('/pimpinan/jalan/anggaran/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>';
                    }
                },
            ]
        });

    });
    let currentLat;
    let currentLng;
    //Map
    let markers = [];
    
    let geocoder;
    let map;
    //GET Location Function
    const options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };

    function success(pos) {
        const crd = pos.coords;
        currentLat = crd.latitude
        currentLng = crd.longitude
        console.log('Your current position is:');
        console.log(`Latitude : ${crd.latitude}`);
        console.log(`Longitude: ${crd.longitude}`);
        console.log(`More or less ${crd.accuracy} meters.`);
    }

    function error(err) {
        console.warn(`ERROR(${err.code}): ${err.message}`);
    }
    
    //END GET LOCATION
    let infowindow;
    let JalanCoordinates = [];
    @foreach($node as $row)
    JalanCoordinates.push({
            lat: parseFloat('{{$row->latitude}}'), 
            lng: parseFloat('{{$row->longitude}}')
        });
    @endforeach
    let JalanPath;
    let BeforePath;
    let markerPin;

    function initMap() {
        infowindow = new google.maps.InfoWindow();

        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: <?= env('DEFAULT_LAT') ?>,
                lng: <?= env('DEFAULT_LNG') ?>
            },
            zoom: <?= env('DEFAULT_ZOOM') ?>,
        });
        
        BeforePath = new google.maps.Polyline({
          path: JalanCoordinates,
          geodesic: true,
          strokeColor: "#094e89",
          strokeOpacity: 1.0,
          strokeWeight: 2,
        });
    
        BeforePath.setMap(map);
    }
    

    navigator.geolocation.getCurrentPosition(success, error, options);
    
    function draw_line()
    {
        JalanPath = new google.maps.Polyline({
          path: JalanCoordinates,
          geodesic: true,
          strokeColor: "#FF0000",
          strokeOpacity: 1.0,
          strokeWeight: 2,
        });
    
        JalanPath.setMap(map);
    }
</script>
<script>
    $("body").on("click",".btn-tambah",function(){
        kosongkan();
        jQuery("#anggaran-form").attr("action",'<?=url("/pimpinan/jalan/anggaran/save")?>');
        jQuery("#anggaran .modal-title").html("Tambah Data Anggaran");
        jQuery("#anggaran").modal("toggle");  
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
                    jQuery("#anggaran-form input[name=tahun]").val(row.tahun);
                    jQuery("#anggaran-form input[name=jumlah]").val(row.jumlah);
                })
            }
        });
        jQuery("#anggaran-form").attr("action",'<?=url("/pimpinan/jalan/anggaran");?>/update/'+id);
        jQuery("#anggaran .modal-title").html("Update Data Anggaran");
        jQuery("#anggaran").modal("toggle");
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
        jQuery("#anggaran-form input[name=tahun]").val("");
        jQuery("#anggaran-form input[name=jumlah]").val("");
    }
</script>
<script src="<?= asset('/node_modules/axios/dist/axios.min.js') ?>"></script>
</body>
@endSection