@extends('layout.app')

@section('title')
Maps View
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Crud</a></li>
    <li class="breadcrumb-item active" aria-current="page">Maps View</li>
</ol>
@endsection

@section('content')

    <!-- Leaflet.js CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4lKVb0eLSNyhEO-C_8JoHhAvba6aZc3U"></script>

	<style type="text/css">
		.select2 {
		  width: 100%!important; /* overrides computed width, 100px in your demo */
		}
	</style>

	<div class="card card-info card-outline" id="main-box" style="">
  		<div class="card-header">
        	<h3 class="card-title">
          		<i class="fas fa-star"></i> Maps View
        	</h3>
        	<div class="card-tools">
        		<a href="{{url('handson3')}}" class="btn btn-danger btn-sm pull-right" data-toggle="tooltip" data-placement="top" title="Kembali ke daftar data"><i class="fa fa-undo"></i> Kembali</a>
            </div>
      	</div>
        <div class="card-body">
			 <div id="leaflet-map" style="height: 400px; width: 100%;"></div>
    <div id="google-map" style="height: 400px; width: 100%; margin-top: 20px;"></div>
        </div>
  	</div>
@endsection

@section('script')
<script type="text/javascript">
	var token = '{{csrf_token()}}';

	$(document).ready(function () {
        const marker = @json($marker); // Mengirim data marker dari PHP ke JavaScript
        console.log(marker);

        // Leaflet Map
        const leafletMap = L.map('leaflet-map').setView([marker.latitude, marker.longitude], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(leafletMap);

        const leafletMarker = L.marker([marker.latitude, marker.longitude]).addTo(leafletMap);
        leafletMarker.bindPopup(`<b>${marker.name}</b>`).openPopup();

        // Google Maps API Map
        const googleMapDiv = document.getElementById('google-map');
        const googleMap = new google.maps.Map(googleMapDiv, {
            center: { lat: parseFloat(marker.latitude), lng: parseFloat(marker.longitude) },
            zoom: 13,
        });

        new google.maps.Marker({
            position: { lat: parseFloat(marker.latitude), lng: parseFloat(marker.longitude) },
            map: googleMap,
            title: marker.name,
        });
    });
	function goBack() {
       window.history.back();
   }
</script>
@endsection