<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebGIS Laporan Zona Nelayan</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            overflow-x: hidden;
            overflow-y: hidden; /* Mencegah scrolling keseluruhan layar */
        }

        /* Navbar bergaya Glassmorphism */
        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .nav-title {
            font-size: 20px;
            font-weight: 700;
            color: #0056b3;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-btn {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,86,179,0.3);
            transition: all 0.2s;
        }
        .nav-btn:active {
            transform: scale(0.95);
        }

        /* Sidebar Off-Canvas */
        .sidebar {
            position: fixed;
            top: 0;
            right: -350px;
            width: 320px;
            height: 100%;
            background-color: white;
            box-shadow: -4px 0 15px rgba(0,0,0,0.1);
            z-index: 2000;
            transition: right 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
        }
        .sidebar.active {
            right: 0;
        }
        .sidebar-header {
            padding: 20px;
            background-color: #0056b3;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sidebar-header h3 {
            margin: 0;
            font-size: 18px;
        }
        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }
        .sidebar-content {
            padding: 15px;
            overflow-y: auto;
            flex: 1;
        }

        /* Card Daftar Laporan */
        .report-card {
            background: #ffffff;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .report-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            border-color: #ddd;
            transform: translateY(-2px);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            color: white;
        }
        .badge-aman { background-color: #28a745; }
        .badge-rawan { background-color: #ffc107; color: #333; }
        .badge-larangan { background-color: #dc3545; }
        .card-date {
            font-size: 11px;
            color: #888;
        }
        .card-desc {
            font-size: 14px;
            color: #444;
            margin: 0;
        }

        /* Peta Full-Screen */
        #map {
            height: calc(100vh - 58px); /* Kurangi tinggi navbar (sekitar 58px) */
            width: 100%;
            z-index: 1; /* Agar berada di belakang UI melayang */
        }

        /* --- Floating Action Button (FAB) --- */
        .fab-wrapper {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 999;
        }
        .fab-btn {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 30px; /* Bentuk Pill */
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,86,179,0.4);
            transition: transform 0.2s, background-color 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .fab-btn:active {
            transform: translate(-50%, 2px); /* Penyesuaian karena translateX(-50%) */
            background-color: #004494;
        }

        /* --- Compass Button --- */
        .compass-btn {
            position: fixed;
            bottom: 100px; /* Di atas FAB */
            right: 20px;
            width: 50px;
            height: 50px;
            background-color: white;
            border: 2px solid #0056b3;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            z-index: 999;
            transition: all 0.2s;
        }
        .compass-btn:active {
            background-color: #eef5ff;
            transform: scale(0.9);
        }

        /* --- Bottom Sheet --- */
        .bottom-sheet-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1500;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s;
        }
        .bottom-sheet-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .bottom-sheet {
            position: fixed;
            bottom: -100%;
            left: 0;
            width: 100%;
            background: white;
            padding: 20px 20px 30px 20px;
            box-sizing: border-box;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            z-index: 1501;
            transition: bottom 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 -4px 15px rgba(0,0,0,0.1);
        }
        .bottom-sheet.active {
            bottom: 0;
        }
        .sheet-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .sheet-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin: 0;
        }
        .sheet-close {
            background: #f0f0f0;
            border: none;
            border-radius: 50%;
            width: 30px; height: 30px;
            display: flex; justify-content: center; align-items: center;
            cursor: pointer;
            font-weight: bold;
            color: #666;
            transition: background 0.2s;
        }
        .sheet-close:active {
            background: #ddd;
        }

        /* Elemen Form di dalam Bottom Sheet */
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        select, input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
        }
        select:focus, input[type="text"]:focus {
            outline: none;
            border-color: #0056b3;
            background-color: #fff;
        }
        .btn-location {
            background-color: #eef5ff;
            color: #0056b3;
            border: 2px dashed #0056b3;
            padding: 15px;
            font-size: 16px;
            width: 100%;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }
        .btn-location:active {
            background-color: #dbe8ff;
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 15px;
            font-size: 18px;
            width: 100%;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(40,167,69,0.2);
        }
        .btn-submit:active {
            background-color: #218838;
        }

        /* Toast Success Melayang */
        .toast-success {
            position: fixed;
            top: 80px; /* di bawah navbar */
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(40, 167, 69, 0.95);
            backdrop-filter: blur(5px);
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            z-index: 3000;
            font-weight: 600;
            animation: fadeout 4s forwards;
            pointer-events: none; /* Tidak mengganggu klik peta */
        }
        @keyframes fadeout {
            0% { opacity: 0; transform: translate(-50%, -20px); }
            10% { opacity: 1; transform: translate(-50%, 0); }
            80% { opacity: 1; transform: translate(-50%, 0); }
            100% { opacity: 0; transform: translate(-50%, -20px); display: none; }
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
            display: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- Pesan Sukses Toast -->
    @if(session('success'))
        <div class="toast-success" id="toast-msg">
            ✅ {{ session('success') }}
        </div>
        <script>
            setTimeout(() => { document.getElementById('toast-msg').style.display = 'none'; }, 4000);
        </script>
    @endif

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" style="text-decoration: none;">
            <div class="nav-title">
                🏠 Beranda
            </div>
        </a>
        <button class="nav-btn" onclick="toggleSidebar()">📋 Daftar Laporan</button>
    </nav>

    <!-- Sidebar Off-Canvas -->
    <div id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <h3>Riwayat Laporan</h3>
            <button class="close-btn" onclick="toggleSidebar()">✖</button>
        </div>
        <div class="sidebar-content">
            @forelse($data_laporan as $index => $laporan)
                <div class="report-card" onclick="flyToLocation({{ $laporan->latitude }}, {{ $laporan->longitude }}, {{ $index }})">
                    <div class="card-header">
                        @if($laporan->kategori_zona == 1)
                            <span class="badge badge-aman">Zona Aman</span>
                        @elseif($laporan->kategori_zona == 2)
                            <span class="badge badge-rawan">Zona Rawan</span>
                        @elseif($laporan->kategori_zona == 3)
                            <span class="badge badge-larangan">Zona Larangan</span>
                        @endif
                        <span class="card-date">{{ $laporan->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="card-desc">
                        <b>Oleh:</b> {{ $laporan->user ? $laporan->user->name : 'Nelayan Anonim' }} <br>
                        {{ $laporan->keterangan ? $laporan->keterangan : 'Tidak ada keterangan tambahan.' }}
                    </p>
                </div>
            @empty
                <div style="text-align: center; color: #888; padding: 20px 0;">
                    Belum ada laporan dari nelayan.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Peta Leaflet (Kini Full-Screen) -->
    <div id="map"></div>

    <!-- Floating Action Button (FAB) Tengah Bawah -->
    <div class="fab-wrapper">
        @auth
            <button class="fab-btn" onclick="toggleBottomSheet()">
                <span>📍 Tambah Laporan</span>
            </button>
        @else
            <button class="fab-btn" onclick="window.location.href='/login'" style="background-color: #333;">
                <span>🔒 Login untuk Menambah Laporan</span>
            </button>
        @endauth
    </div>

    <!-- Tombol Kompas Peta Utama -->
    <button class="compass-btn" onclick="focusCurrentLocation()" title="Pusatkan ke lokasi saya">
        🎯
    </button>

    <!-- Bottom Sheet & Overlay -->
    <div class="bottom-sheet-overlay" id="sheet-overlay" onclick="toggleBottomSheet()"></div>
    
    <div class="bottom-sheet" id="bottom-sheet">
        <div class="sheet-header">
            <h3 class="sheet-title">Form Laporan Zona</h3>
            <button class="sheet-close" onclick="toggleBottomSheet()">✖</button>
        </div>

        <div class="alert-error" id="error-message"></div>

        <form action="/lapor" method="POST">
            @csrf
            <input type="hidden" id="lat" name="latitude" required>
            <input type="hidden" id="lng" name="longitude" required>

            <button type="button" class="btn-location" onclick="getLocation()">📍 Gunakan Lokasi Saat Ini</button>
            <div id="location-status" style="text-align: center; color: #28a745; font-weight: 700; margin-bottom: 15px; display: none;">
                ✅ Lokasi Berhasil Dideteksi! (Sesuaikan posisi marker jika diperlukan)
            </div>

            <div class="form-group">
                <label for="kategori_zona">Pilih Jenis Zona:</label>
                <select id="kategori_zona" name="kategori_zona" required>
                    <option value="" disabled selected>-- Ketuk untuk Memilih Zona --</option>
                    <option value="1">Zona Aman (Hijau)</option>
                    <option value="2">Zona Rawan (Kuning)</option>
                    <option value="3">Zona Larangan Tangkap (Merah)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan Tambahan (Opsional):</label>
                <input type="text" id="keterangan" name="keterangan" placeholder="Contoh: Banyak karang, ombak besar...">
            </div>

            <button type="submit" class="btn-submit">Simpan Laporan</button>
        </form>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        // Array untuk menyimpan referensi marker
        var markerRefs = [];
        var draftMarker = null;

        // Inisialisasi Layer Peta Dasar
        var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        });
        
        var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: '© Esri'
        });

        // Inisialisasi Peta
        var map = L.map('map', {
            center: [-2.548926, 118.0148634],
            zoom: 5,
            layers: [osmLayer] // Peta default
        });

        // Inisialisasi Layer Group untuk Filter
        var zonaAmanLayer = L.layerGroup().addTo(map);
        var zonaRawanLayer = L.layerGroup().addTo(map);
        var zonaLaranganLayer = L.layerGroup().addTo(map);

        // Custom Icons
        var iconBaseUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-';
        
        var greenIcon = new L.Icon({ iconUrl: iconBaseUrl + 'green.png', shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41] });
        var yellowIcon = new L.Icon({ iconUrl: iconBaseUrl + 'yellow.png', shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41] });
        var redIcon = new L.Icon({ iconUrl: iconBaseUrl + 'red.png', shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41] });
        var blueIcon = new L.Icon({ iconUrl: iconBaseUrl + 'blue.png', shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41] });

        // Data dari Backend
        var laporanData = @json($data_laporan);

        // Render marker
        laporanData.forEach(function(laporan, index) {
            var iconToUse;
            var zonaText;
            
            if (laporan.kategori_zona == 1) {
                iconToUse = greenIcon; zonaText = "Aman";
            } else if (laporan.kategori_zona == 2) {
                iconToUse = yellowIcon; zonaText = "Rawan";
            } else if (laporan.kategori_zona == 3) {
                iconToUse = redIcon; zonaText = "Larangan Tangkap";
            }

            var popupContent = "<div style='font-family: Inter, sans-serif;'>";
            popupContent += "<b style='font-size: 16px;'>Zona " + zonaText + "</b><br>";
            
            // Nama diambil dari relasi User
            var namaPelapor = laporan.user ? laporan.user.name : 'Nelayan Anonim';
            popupContent += "<small style='color: #0056b3; font-weight: bold;'>Oleh: " + namaPelapor + "</small><br>";
            
            // Format Waktu
            var waktu = new Date(laporan.created_at).toLocaleString('id-ID', {day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute:'2-digit'});
            popupContent += "<small style='color: #888; display: block; margin-top: 5px;'>🕒 " + waktu + "</small>";
            popupContent += "<small style='color: #888; display: block;'>📍 " + parseFloat(laporan.latitude).toFixed(5) + ", " + parseFloat(laporan.longitude).toFixed(5) + "</small>";

            if (laporan.keterangan) {
                popupContent += "<p style='margin-top: 10px; color: #555; padding-top: 5px; border-top: 1px solid #eee;'>" + laporan.keterangan + "</p>";
            } else {
                popupContent += "<p style='margin-top: 5px; color: #888; font-style: italic;'>Tanpa keterangan</p>";
            }
            popupContent += "</div>";

            var marker = L.marker([laporan.latitude, laporan.longitude], {icon: iconToUse})
                .bindPopup(popupContent);
                
            // Masukkan marker ke layer yang sesuai
            if (laporan.kategori_zona == 1) {
                zonaAmanLayer.addLayer(marker);
            } else if (laporan.kategori_zona == 2) {
                zonaRawanLayer.addLayer(marker);
            } else if (laporan.kategori_zona == 3) {
                zonaLaranganLayer.addLayer(marker);
            }

            markerRefs[index] = marker;
        });

        // Menambahkan Control Layer (Legenda & Pilihan Satelit)
        var baseMaps = {
            "🗺️ Peta Jalan": osmLayer,
            "🛰️ Peta Satelit": satelliteLayer
        };
        var overlayMaps = {
            "🟢 Zona Aman": zonaAmanLayer,
            "🟡 Zona Rawan": zonaRawanLayer,
            "🔴 Zona Larangan": zonaLaranganLayer
        };
        L.control.layers(baseMaps, overlayMaps, { collapsed: false }).addTo(map);

        // --- Fitur Navbar & Sidebar ---
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle('active');
        }

        function flyToLocation(lat, lng, markerIndex) {
            toggleSidebar();
            map.flyTo([lat, lng], 14, { animate: true, duration: 1.5 });
            setTimeout(function() { markerRefs[markerIndex].openPopup(); }, 1500);
        }

        // --- Fitur Bottom Sheet ---
        function toggleBottomSheet() {
            document.getElementById('bottom-sheet').classList.toggle('active');
            document.getElementById('sheet-overlay').classList.toggle('active');
        }

        // --- Fitur Form Geolocation ---
        function getLocation() {
            var errorMessageDiv = document.getElementById("error-message");
            var statusDiv = document.getElementById("location-status");
            var btnLocation = document.querySelector(".btn-location");
            
            errorMessageDiv.style.display = "none";
            statusDiv.style.display = "none";
            btnLocation.innerText = "⏳ Mencari Lokasi...";

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                errorMessageDiv.innerText = "Browser Anda tidak mendukung Geolocation.";
                errorMessageDiv.style.display = "block";
                btnLocation.innerText = "📍 Gunakan Lokasi Saya Saat Ini";
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            var btnLocation = document.querySelector(".btn-location");
            
            document.getElementById("lat").value = lat;
            document.getElementById("lng").value = lng;
            
            btnLocation.innerText = "📍 Perbarui Lokasi";
            document.getElementById("location-status").style.display = "block";
            
            map.flyTo([lat, lng], 15, {
                animate: true,
                duration: 1.5
            });

            // Logika Draggable Draft Marker (Pin Biru)
            if (draftMarker) {
                draftMarker.setLatLng([lat, lng]);
            } else {
                draftMarker = L.marker([lat, lng], {icon: blueIcon, draggable: true}).addTo(map)
                    .bindPopup("<b style='font-family: Inter, sans-serif;'>Lokasi Laporan Baru</b><br><span style='font-family: Inter, sans-serif;'>Geser pin ini jika titik kurang pas.</span>");
                
                // Buka popup setelah animasi selesai
                setTimeout(function() { draftMarker.openPopup(); }, 1500);
                
                draftMarker.on('dragend', function(e) {
                    var newPos = e.target.getLatLng();
                    document.getElementById("lat").value = newPos.lat;
                    document.getElementById("lng").value = newPos.lng;
                });
            }
        }

        function showError(error) {
            var btnLocation = document.querySelector(".btn-location");
            var msg = "";
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    msg = "Sinyal GPS gagal ditangkap atau izin ditolak. Pastikan GPS HP Anda aktif.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    msg = "Informasi lokasi tidak tersedia.";
                    break;
                case error.TIMEOUT:
                    msg = "Waktu permintaan lokasi habis (timeout).";
                    break;
                case error.UNKNOWN_ERROR:
                    msg = "Terjadi kesalahan yang tidak diketahui.";
                    break;
            }
            alert(msg);
            var errorMessageDiv = document.getElementById("error-message");
            errorMessageDiv.innerText = msg;
            errorMessageDiv.style.display = "block";
            btnLocation.innerText = "📍 Coba Lagi Temukan Lokasi";
        }

        // --- Fitur Kompas Peta Utama & Auto-Locate ---
        var userLocationMarker = null;
        var userLocationCircle = null;

        function focusCurrentLocation() {
            // Minta browser mencari lokasi & otomatis menggeser peta
            map.locate({setView: true, maxZoom: 15});
        }

        // Jika lokasi berhasil ditemukan oleh map.locate()
        map.on('locationfound', function(e) {
            var radius = e.accuracy / 2;

            if (userLocationMarker) {
                userLocationMarker.setLatLng(e.latlng);
                userLocationCircle.setLatLng(e.latlng);
                userLocationCircle.setRadius(radius);
            } else {
                userLocationMarker = L.circleMarker(e.latlng, {
                    radius: 8,
                    fillColor: "#007bff",
                    color: "#ffffff",
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.8
                }).addTo(map).bindPopup("<b style='font-family:Inter,sans-serif;'>Lokasi Anda</b>");

                userLocationCircle = L.circle(e.latlng, radius, {
                    color: '#007bff',
                    fillColor: '#007bff',
                    fillOpacity: 0.1
                }).addTo(map);
            }
        });

        // Jika pengguna menolak akses lokasi saat awal buka web
        map.on('locationerror', function(e) {
            console.log("Auto-locate diabaikan: " + e.message);
        });

        // Auto-Locate saat web pertama kali dimuat
        setTimeout(function() {
            map.locate({setView: true, maxZoom: 14});
        }, 800);

    </script>
</body>
</html>
