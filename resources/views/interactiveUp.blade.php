@extends('layout.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3 class="my-3">GIS Interactive - Add and View Data</h3>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row">
        <div class="col-md-8">
            <div id="map" style="height: 500px; border: 1px solid #ddd;"></div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Add Data</h5>
                </div>
                <div class="card-body">
                    <!-- Add Marker -->
                    <form id="add-marker-form" action="{{ route('storeMarker') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Marker Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Latitude:</label>
                            <input type="text" name="latitude" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Longitude:</label>
                            <input type="text" name="longitude" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Add Marker</button>
                    </form>
                    <hr>
                    <!-- Add Polygon -->
                    <form id="add-polygon-form" action="{{ route('storePolygon') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Polygon Coordinates (JSON):</label>
                            <textarea name="coordinates" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Add Polygon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Data Table</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Coordinates</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="data-table-body">
                            <!-- Dynamic rows will be added here via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialize Map
    var map = L.map('map').setView([-8.6505, 115.2192], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    async function loadMapData() {
        const response = await fetch('/data');
        const data = await response.json();

        data.markers.forEach(marker => {
            L.marker([marker.latitude, marker.longitude])
                .addTo(map)
                .bindPopup(marker.name);
            
            addToTable('Marker', marker.name, `${marker.latitude}, ${marker.longitude}`);
        });

        data.polygons.forEach(polygon => {
            const latLngs = JSON.parse(polygon.coordinates);
            L.polygon(latLngs)
                .addTo(map)
                .bindPopup(polygon.name || 'Polygon');
            
            addToTable('Polygon', polygon.name || 'Polygon', polygon.coordinates);
        });
    }


    // Add Row to Table
    function addToTable(type, name, coordinates) {
        const tableBody = document.getElementById('data-table-body');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${tableBody.children.length + 1}</td>
            <td>${type}</td>
            <td>${name}</td>
            <td>${coordinates}</td>
            <td><button class="btn btn-danger btn-sm">Delete</button></td>
        `;
        tableBody.appendChild(row);
    }

    // Load Data on Page Load
    loadMapData();
</script>
@endsection
