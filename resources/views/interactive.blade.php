<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dasar Peta Interaktif</title>
    
    <!-- Leaflet.js CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4lKVb0eLSNyhEO-C_8JoHhAvba6aZc3U"></script>
    <style>
        .form-container {
            margin: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input, textarea {
            display: block;
            margin: 10px 0;
        }
    </style>

</head>
<body>

    <h1>Peta Interaktif dengan Laravel</h1>

    <div class="form-container">
        <h3>Tambahkan Marker</h3>
        <form id="markerForm" method="POST" action="{{ url('api/markers') }}">
            @csrf
            <input type="text" id="markerName" placeholder="Nama Lokasi" required />
            <input type="text" id="markerLat" placeholder="Latitude" required />
            <input type="text" id="markerLng" placeholder="Longitude" required />
            <button type="submit">Tambah Marker</button>
        </form>

        <h3>Tambahkan Poligon</h3>
        <form id="polygonForm" method="POST" action="{{ url('api/polygons') }}">
            <textarea id="polygonCoords" placeholder="Koordinat Poligon (JSON)" required></textarea>
            <button type="submit">Tambah Poligon</button>
        </form>
    </div>


    <script type="text/javascript">
        // Tambahkan event listener untuk marker
        document.getElementById("markerForm").addEventListener("submit", function (e) {
            e.preventDefault();
            const name = document.getElementById("markerName").value;
            const lat = parseFloat(document.getElementById("markerLat").value);
            const lng = parseFloat(document.getElementById("markerLng").value);

            fetch("{{url("api/markers")}}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ name, latitude: lat, longitude: lng }),
            })
            .then((res) => res.json())
            .then((data) => {
                alert("Marker ditambahkan!");
            })
            .catch((error) => {
                console.error("Error:", error);
            });

        });

        // Tambahkan event listener untuk poligon
        document.getElementById("polygonForm").addEventListener("submit", function (e) {
            e.preventDefault();
            const coords = JSON.parse(document.getElementById("polygonCoords").value);

            fetch("{{url("api/polygons")}}", {
                method: "POST",
                 headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ coordinates: coords }),
            })
                .then((res) => res.json())
                .then((data) => {
                    alert("Poligon ditambahkan!");
                });
        });

    </script>

</body>
</html>