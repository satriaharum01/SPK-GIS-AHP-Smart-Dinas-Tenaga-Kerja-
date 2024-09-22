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
                    <form action="{{url('/admin/alternatif/save')}}" method="post">
                        @csrf
                        <div class="modal-body"> 
                            <div class="form-group">
                                <label>Nama Jalan</label>
                                <input type="text" name="nama_alternatif" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Ruas Jalan</label>
                                <input type="number" name="ruas_jalan" class="form-control" step="0.001" required>
                            </div>
                            <div class="form-group">
                                <label>Cordinat Jalan</label>
                                <input type="text" name="cordinat" class="form-control" required readonly>
                            </div>
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
<!-- /.container-fluid -->
@endSection()
@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDo9HRRCCPaSc56lFFDzT2V0xOYPI8OA9U&callback=initMap&libraries=places&v=weekly&language=id&region=ID" async></script>
<script>
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

    function initMap() {
        infowindow = new google.maps.InfoWindow();

        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: <?= env('DEFAULT_LAT') ?>,
                lng: <?= env('DEFAULT_LNG') ?>
            },
            zoom: <?= env('DEFAULT_ZOOM') ?>,
        });
        
    }

    navigator.geolocation.getCurrentPosition(success, error, options);
</script>
<script src="<?= asset('/node_modules/axios/dist/axios.min.js') ?>"></script>
</body>
@endSection