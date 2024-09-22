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
                    <form action="{{url('/admin/alternatif/save')}}" method="post" id="compose-form">
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
                            <button type="button" class="btn btn-warning btn-reset">Reset Map</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#compose">Detail</button>
                            <button type="button" class="btn btn-primary btn-simpan">Simpan</button>
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
    let JalanCoordinates = [];
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

        map.addListener('click', (e) => {
            infowindow = new google.maps.InfoWindow({
                content: `<div class="d-flex flex-column">
                            <button class="btn btn-primary" onclick="tambah_titik(this)" data-coordinates="${e.latLng.lat()},${e.latLng.lng()}">Tambah Tanda</button>
                        </div>`,
            });
        
            if (markerPin) {
                markerPin.setMap(null);
            }
            markerPin = new google.maps.Marker({
                position: e.latLng,
                map,
                icon: '<?= asset('static/marker-node.svg') ?>'
            });
        
            markerPin.addListener('click', () => {
                infowindow.open({
                    anchor: markerPin,
                    map,
                    shouldFocus: true
                });
            })
        })
    }
    
    function tambah_titik(e) {
        let coordinate = e.getAttribute('data-coordinates');
        let coordinate_split = coordinate.split(",");
        let lat = coordinate_split[0];
        let lng = coordinate_split[1];
        let hasil_path_html = '';
        
        JalanCoordinates.push({
            lat: parseFloat(coordinate_split[0]), 
            lng: parseFloat(coordinate_split[1])
        });
        $.each(JalanCoordinates, function(index, row) {
            hasil_path_html += '[{lat:'+row.lat+'},';
            hasil_path_html += '{lng:'+row.lng+'}]';
        })
        jQuery("#compose-form input[name=cordinat]").val(hasil_path_html);
        draw_line();
        console.log(JalanCoordinates);
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
    $("body").on("click",".btn-reset",function(){
       JalanCoordinates = [];
       initMap();
       JalanPath.setMap(null);
       jQuery("#compose-form input[name=cordinat]").val("");
    });

    $("body").on("click",".btn-simpan",function(){
        var nama_alternatif = jQuery("#compose-form input[name=nama_alternatif]").val();
        var ruas_jalan = jQuery("#compose-form input[name=ruas_jalan]").val();
        var node = JalanCoordinates;
        var url = jQuery("#compose-form").attr("action");
        var CSRF_TOKEN = '{{ csrf_token() }}';
        // Get the selected file
        var fd = new FormData();
        // Append data 
        fd.append('_token', CSRF_TOKEN);
        fd.append('nama_alternatif', nama_alternatif);
        fd.append('ruas_jalan', ruas_jalan);
        fd.append('node', JSON.stringify(node));

        $.ajax({
            url: url,
            method: 'post',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(dataResult) {
                Swal.fire(
                    'Data Disimpan!',
                    '',
                    'success'
                );
                console.log(dataResult);
                window.location.href = '{{route("admin.alternatif")}}';
            }
        });
    });
</script>
<script src="<?= asset('/node_modules/axios/dist/axios.min.js') ?>"></script>
</body>
@endSection