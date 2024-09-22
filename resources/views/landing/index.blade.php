@extends('landing.head')
@section('css')
<style>
    .legend {
        text-align: left;
        padding: 6px 8px;
        font: 14px Arial, Helvetica, sans-serif;
        background: white;
        background: rgba(255, 255, 255, 1);
        /*box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);*/
        /*border-radius: 5px;*/
        line-height: 24px;
        color: #555;
        left: 10px;
    }
    .legend h4 {
        text-align: center;
        font-size: 16px;
        margin: 2px 12px 8px;
        color: black;
    }
    .legend span {
        position: relative;
        bottom: 3px;
        color: black;
    }
    .legend i {
        border: 1px solid black;
        width: 18px;
        height: 18px;
        float: left;
        margin: 0 8px 0 0;
        opacity: 1;
    }
    .legend i.icon {
        background-size: 18px;
        background-color: rgba(255, 255, 255, 1);
    }
</style>
@endsection
@section('content')
<nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #13b56a;">
    <div class="container mx-auto">
    </div>
</nav>

<!-- End of Topbar -->
<div id="petapublic" class="service-wrapper">
    <div class="gmap_canvas" id="map">
    </div>
    <div id="legend" class="legend bg-white p-2">
        <h4>Legend</h4>
        <i style="background: #228b22"></i><span>Baik</span><br>
        <i style="background: #f2e640"></i><span>Rusak Ringan</span><br>
        <i style="background: #d2691e"></i><span>Rusak Sedang</span><br>
        <i style="background: #cd1010"></i><span>Rusak Berat</span><br>
    </div>
</div>
@endsection
@section('custom_script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDo9HRRCCPaSc56lFFDzT2V0xOYPI8OA9U&callback=initMap&libraries=places&v=weekly&language=id&region=ID" async></script>
<script>
    let formData;
    let startPoint;
    let endPoint;
    var start;
    var end;

    let currentLat;
    let currentLng;
    //Map

    var klinik_id;
    let markers = [];
    let klinik = [];
    let waypts = [];
    let geocoder;
    let map;
    let segment_point = [];
    let summary = '';
    let inputLat = document.getElementById('lat');
    let inputLng = document.getElementById('lng');
    let inputAlamat = document.getElementById('alamat');
    let markerPin;
    let existingMarkers = [];
    let condition =0;
    let reset;
    let warnalegend = [
        '#228b22',
        '#f2e640',
        '#d2691e',
        '#cd1010'
    ];
    let color;
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
    let klinikwindow;
    const legend = document.getElementById("legend");

    function initMap() {
        infowindow = new google.maps.InfoWindow();
        
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: <?= env('DEFAULT_LAT') ?>,
                lng: <?= env('DEFAULT_LNG') ?>
            },
            zoom: <?= env('DEFAULT_ZOOM') ?>,
        });
        
        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legend);
        load_jalan();
    }

    function addPolyline(data) {

        let contentString = '';

            contentString = `<div class="d-flex flex-column align-items-center">
            <span class="mb-2">${data.nama_alternatif}</span>`;
            contentString += `</div>`;
        

        let JalanCoordinates = [];

        
        var resultData = data.cordinat;
        $.each(resultData,function(index,row){
            JalanCoordinates.push({
                lat: parseFloat(row.latitude), 
                lng: parseFloat(row.longitude)
            });
        })
        
        const infowindow = new google.maps.InfoWindow({
            content: contentString,
        });
        
        console.log(data.status);
        setColor(data.status);
        
        let JalanPath = new google.maps.Polyline({
          path: JalanCoordinates,
          geodesic: true,
          strokeColor: color,
          strokeOpacity: 1.0,
          strokeWeight: 3,
        });
        
        google.maps.event.addListener(JalanPath, 'mouseover', function(e) {
            const marker = new google.maps.Marker({
                position: e.latLng,
                map
            });
            infowindow.open({
                anchor: marker,
                map,
                shouldFocus: true,
            })
            
            deleteMarkers();
            markers.push(marker);
        });
        
        google.maps.event.addListener(JalanPath, 'mouseout', function(e) {
            deleteMarkers();
        })
        JalanPath.setMap(map);
        
    }

    function load_jalan()
    {
        const data = fetch('<?= url('jalan/json') ?>').then(res => res.json()).then(data => {
            data.map(function(e) {
                addPolyline(e);
            })
        });
    }

    function deleteMarkers() {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }
        markers = [];
    }

    function setColor(e)
    {
        if(e === 'Baik')
        {
            color = warnalegend[0];
        }else if(e === 'Rusak Ringan')
        {
            color = warnalegend[1];
        }else if (e === 'Rusak Sedang')
        {
            color = warnalegend[2];
        }else{
            color = warnalegend[3];
        }
    }
    navigator.geolocation.getCurrentPosition(success, error, options);
</script>
<script src="<?= asset('/node_modules/axios/dist/axios.min.js') ?>"></script>

</body>
</html>
@endsection