<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebGIS Laporan Zona Nelayan</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <!-- Scripts & Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            overflow: hidden; /* Mencegah scrolling keseluruhan layar */
        }

        #map {
            height: calc(100vh - 80px); /* Kurangi tinggi navbar (80px) */
            width: 100%;
            z-index: 1; /* Agar berada di belakang UI melayang */
        }

        /* Leaflet popup overrides */
        .leaflet-popup-content-wrapper {
            border-radius: 1.25rem !important;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1) !important;
            border: 1px solid #f1f5f9 !important;
            padding: 2px !important;
        }
        .leaflet-popup-tip {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important;
        }
        .leaflet-popup-content {
            margin: 12px 16px !important;
        }
        .leaflet-container a.leaflet-popup-close-button {
            color: #94a3b8 !important;
            top: 10px !important;
            right: 10px !important;
            font-size: 16px !important;
            font-weight: bold !important;
        }

        /* Leaflet Layer Control overrides */
        .leaflet-control-layers {
            border-radius: 1rem !important;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important;
            border: 1px solid #f1f5f9 !important;
            padding: 8px 12px !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 700 !important;
            font-size: 11px !important;
            color: #334155 !important;
        }
        .leaflet-control-layers-list label {
            margin-bottom: 4px;
            cursor: pointer;
        }

        /* Animation for Toast Alert */
        @keyframes bounce-subtle {
            0%, 100% { transform: translate(-50%, 0); }
            50% { transform: translate(-50%, -6px); }
        }
        .animate-bounce-subtle {
            animation: bounce-subtle 4s infinite ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-screen flex flex-col">

    <!-- Pesan Sukses Toast -->
    @if(session('success'))
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-[3000] bg-emerald-600/95 backdrop-blur-md text-white font-bold px-6 py-3.5 rounded-full shadow-2xl flex items-center gap-2 animate-bounce-subtle pointer-events-none text-sm transition-opacity duration-300" id="toast-msg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => { 
                var toast = document.getElementById('toast-msg');
                if(toast) {
                    toast.style.opacity = '0';
                    setTimeout(() => { toast.style.display = 'none'; }, 300);
                }
            }, 4000);
        </script>
    @endif

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="bg-blue-600 text-white p-2.5 rounded-xl shadow-lg shadow-blue-200 transition group-hover:scale-105 duration-300">
                        <!-- SVG Wave Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M3 14h18m-9-8v12M3 6h18m-9 0v12"></path>
                        </svg>
                    </div>
                    <span class="font-extrabold text-xl sm:text-2xl text-slate-900 tracking-tight">
                        WebGIS <span class="text-blue-600">Nelayan</span>
                    </span>
                </a>

                <!-- Nav Auth Links -->
                <div class="flex items-center gap-3">
                    <a href="/" class="group inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-blue-600 transition px-3 py-2">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-500 transition-transform group-hover:scale-110 duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Beranda
                    </a>
                    <button onclick="toggleSidebar()" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-5 py-2.5 rounded-full transition shadow-lg shadow-blue-100 flex items-center gap-2 shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Daftar Laporan
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Off-Canvas (Tailwind Slide-over) -->
    <div id="sidebar" class="fixed top-0 right-0 z-[2000] h-full w-full max-w-sm bg-white shadow-2xl transition-transform duration-300 transform translate-x-full flex flex-col border-l border-slate-100">
        <div class="h-20 flex items-center justify-between px-6 shrink-0 border-b border-slate-50 bg-slate-50/50">
            <h3 class="font-black text-lg text-slate-800 tracking-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Riwayat Laporan
            </h3>
            <button class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition" onclick="toggleSidebar()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-4 space-y-3.5">
            @forelse($data_laporan as $index => $laporan)
                <div class="group bg-white rounded-2xl border border-slate-100 p-4 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-200 cursor-pointer flex gap-3.5" onclick="flyToLocation({{ $laporan->latitude }}, {{ $laporan->longitude }}, {{ $index }})">
                    <!-- Indikator Warna Samping -->
                    <div class="w-1.5 shrink-0 rounded-full {{ $laporan->kategori_zona == 1 ? 'bg-emerald-500 shadow-sm shadow-emerald-200' : ($laporan->kategori_zona == 2 ? 'bg-amber-500 shadow-sm shadow-amber-200' : 'bg-rose-500 shadow-sm shadow-rose-200') }}"></div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2 mb-2 flex-wrap">
                            @if($laporan->kategori_zona == 1)
                                <span class="bg-emerald-50 text-emerald-700 text-[9px] font-black px-2 py-1 rounded-lg border border-emerald-100 uppercase tracking-tight flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Zona Aman
                                </span>
                            @elseif($laporan->kategori_zona == 2)
                                <span class="bg-amber-50 text-amber-700 text-[9px] font-black px-2 py-1 rounded-lg border border-amber-100 uppercase tracking-tight flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Zona Rawan
                                </span>
                            @elseif($laporan->kategori_zona == 3)
                                <span class="bg-rose-50 text-rose-700 text-[9px] font-black px-2 py-1 rounded-lg border border-rose-100 uppercase tracking-tight flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Zona Larangan
                                </span>
                            @endif
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $laporan->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-slate-700 leading-relaxed break-words font-medium">
                            <span class="text-slate-400 font-bold uppercase text-[9px] block mb-0.5">Oleh: {{ $laporan->user ? $laporan->user->name : 'Nelayan Anonim' }}</span>
                            {{ $laporan->keterangan ? $laporan->keterangan : 'Tidak ada keterangan tambahan.' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center text-slate-400 py-10 font-medium">
                    Belum ada laporan dari nelayan.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Peta Leaflet (Full-Screen) -->
    <div id="map"></div>

    <!-- Floating Action Button (FAB) Tengah Bawah -->
    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[1000]">
        @auth
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-8 rounded-full shadow-2xl shadow-blue-500/30 transform transition duration-200 hover:-translate-y-0.5 active:scale-95 text-sm sm:text-base flex items-center gap-2.5 whitespace-nowrap" onclick="toggleBottomSheet()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Tambah Laporan
            </button>
        @else
            <button class="bg-slate-900 hover:bg-black text-white font-black py-4 px-8 rounded-full shadow-2xl transform transition duration-200 hover:-translate-y-0.5 active:scale-95 text-sm sm:text-base flex items-center gap-2.5 whitespace-nowrap" onclick="window.location.href='/login'">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Login untuk Menambah Laporan
            </button>
        @endauth
    </div>

    <!-- Tombol Kompas Peta Utama -->
    <button class="fixed bottom-24 right-6 w-12 h-12 bg-white hover:bg-slate-50 text-blue-600 hover:text-blue-700 border border-slate-200 rounded-full flex justify-center items-center shadow-lg transition transform active:scale-90 z-[1000]" onclick="focusCurrentLocation()" title="Pusatkan ke lokasi saya">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
        </svg>
    </button>

    <!-- Bottom Sheet & Overlay -->
    <div id="sheet-overlay" class="fixed inset-0 z-[1500] bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none" onclick="toggleBottomSheet()"></div>
    
    <div id="bottom-sheet" class="fixed bottom-0 left-0 md:left-1/2 md:-translate-x-1/2 z-[1501] w-full max-w-lg bg-white rounded-t-[2rem] md:rounded-[2rem] shadow-2xl p-6 transition-transform duration-300 transform translate-y-full md:bottom-6 flex flex-col max-h-[90%] overflow-y-auto border border-slate-100">
        <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4 shrink-0">
            <h3 class="font-black text-xl text-slate-800 tracking-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Form Laporan Zona
            </h3>
            <button class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition" onclick="toggleBottomSheet()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl mb-4 font-semibold text-sm hidden" id="error-message"></div>

        <form action="/lapor" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" id="lat" name="latitude" required>
            <input type="hidden" id="lng" name="longitude" required>

            <button type="button" class="w-full flex items-center justify-center gap-2 bg-blue-50 text-blue-600 hover:bg-blue-100 border-2 border-dashed border-blue-300 font-bold p-4 rounded-2xl transition duration-200 text-sm sm:text-base shrink-0" onclick="getLocation()">
                <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="btn-location-text">Gunakan Lokasi Saat Ini</span>
            </button>
            <div id="location-status" class="bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs sm:text-sm font-bold p-4 rounded-2xl text-center hidden shrink-0">
                ✅ Lokasi Berhasil Dideteksi! (Geser pin biru pada peta jika posisi kurang pas)
            </div>

            <div class="space-y-2">
                <label for="kategori_zona" class="block text-slate-700 font-black text-xs tracking-widest uppercase opacity-60">Pilih Jenis Zona</label>
                <div class="relative">
                    <select id="kategori_zona" name="kategori_zona" required class="bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm sm:text-base rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full p-4 font-bold appearance-none transition shadow-sm">
                        <option value="" disabled selected>-- Pilih Kategori Zonasi Laut --</option>
                        <option value="1">Zona Aman (Hijau)</option>
                        <option value="2">Zona Rawan (Kuning)</option>
                        <option value="3">Zona Larangan Tangkap (Merah)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-5 pointer-events-none text-slate-400 font-bold">
                        ↓
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label for="keterangan" class="block text-slate-700 font-black text-xs tracking-widest uppercase opacity-60">Keterangan Tambahan (Opsional)</label>
                <input type="text" id="keterangan" name="keterangan" placeholder="Contoh: Terumbu karang indah, ombak besar di sore hari..." class="bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm sm:text-base rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full p-4 transition shadow-sm">
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black p-4 rounded-2xl shadow-xl shadow-emerald-200 transition duration-200 text-base sm:text-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                Simpan Laporan
            </button>
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

            var categoryClass = "";
            var dotClass = "";
            if (laporan.kategori_zona == 1) {
                categoryClass = "bg-emerald-50 text-emerald-700 border-emerald-100";
                dotClass = "bg-emerald-500";
            } else if (laporan.kategori_zona == 2) {
                categoryClass = "bg-amber-50 text-amber-700 border-amber-100";
                dotClass = "bg-amber-500";
            } else {
                categoryClass = "bg-rose-50 text-rose-700 border-rose-100";
                dotClass = "bg-rose-500";
            }

            var waktu = new Date(laporan.created_at).toLocaleString('id-ID', {day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute:'2-digit'});
            var namaPelapor = laporan.user ? laporan.user.name : 'Nelayan Anonim';

            var popupContent = `
                <div class="font-sans text-slate-800 p-1 min-w-[200px]">
                    <div class="flex items-center gap-1.5 mb-2.5">
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-tight border flex items-center gap-1.5 ${categoryClass}">
                            <span class="w-1.5 h-1.5 rounded-full ${dotClass}"></span>
                            Zona ${zonaText}
                        </span>
                    </div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                        Oleh: ${namaPelapor}
                    </div>
                    
                    <p class="text-sm font-semibold text-slate-800 mb-3 border-b border-slate-100 pb-2 leading-relaxed">
                        ${laporan.keterangan ? '"' + laporan.keterangan + '"' : '<span class="text-slate-400 font-medium italic">Tidak ada keterangan</span>'}
                    </p>
                    
                    <div class="space-y-1 text-[10px] font-bold text-slate-500">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>${waktu}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="font-mono">${parseFloat(laporan.latitude).toFixed(5)}, ${parseFloat(laporan.longitude).toFixed(5)}</span>
                        </div>
                    </div>
                </div>
            `;

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
            " Peta Jalan": osmLayer,
            " Peta Satelit": satelliteLayer
        };
        var overlayMaps = {
            " Zona Aman": zonaAmanLayer,
            " Zona Rawan": zonaRawanLayer,
            " Zona Larangan": zonaLaranganLayer
        };
        L.control.layers(baseMaps, overlayMaps, { collapsed: window.innerWidth < 768 }).addTo(map);

        // --- Fitur Navbar & Sidebar ---
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            if (sidebar.classList.contains('translate-x-full')) {
                sidebar.classList.remove('translate-x-full');
                sidebar.classList.add('translate-x-0');
            } else {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('translate-x-full');
            }
        }

        function flyToLocation(lat, lng, markerIndex) {
            toggleSidebar();
            map.flyTo([lat, lng], 14, { animate: true, duration: 1.5 });
            setTimeout(function() { markerRefs[markerIndex].openPopup(); }, 1500);
        }

        // --- Fitur Bottom Sheet ---
        function toggleBottomSheet() {
            var sheet = document.getElementById('bottom-sheet');
            var overlay = document.getElementById('sheet-overlay');
            
            if (sheet.classList.contains('translate-y-full')) {
                sheet.classList.remove('translate-y-full');
                sheet.classList.add('translate-y-0');
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100', 'pointer-events-auto');
            } else {
                sheet.classList.add('translate-y-full');
                sheet.classList.remove('translate-y-0');
                overlay.classList.add('opacity-0', 'pointer-events-none');
                overlay.classList.remove('opacity-100', 'pointer-events-auto');
            }
        }

        // --- Fitur Form Geolocation ---
        function getLocation() {
            var errorMessageDiv = document.getElementById("error-message");
            var statusDiv = document.getElementById("location-status");
            var btnText = document.querySelector(".btn-location-text");
            
            errorMessageDiv.classList.add("hidden");
            statusDiv.classList.add("hidden");
            btnText.innerText = "Mencari Lokasi...";

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                errorMessageDiv.innerText = "Browser Anda tidak mendukung Geolocation.";
                errorMessageDiv.classList.remove("hidden");
                btnText.innerText = "Gunakan Lokasi Saat Ini";
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            var btnText = document.querySelector(".btn-location-text");
            
            document.getElementById("lat").value = lat;
            document.getElementById("lng").value = lng;
            
            btnText.innerText = "Perbarui Lokasi";
            document.getElementById("location-status").classList.remove("hidden");
            
            map.flyTo([lat, lng], 15, {
                animate: true,
                duration: 1.5
            });

            // Logika Draggable Draft Marker (Pin Biru)
            if (draftMarker) {
                draftMarker.setLatLng([lat, lng]);
            } else {
                draftMarker = L.marker([lat, lng], {icon: blueIcon, draggable: true}).addTo(map)
                    .bindPopup("<div class='font-sans text-xs p-1'><b>Lokasi Laporan Baru</b><br>Geser pin ini jika titik kurang pas.</div>");
                
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
            var btnText = document.querySelector(".btn-location-text");
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
            errorMessageDiv.classList.remove("hidden");
            btnText.innerText = "Coba Lagi Temukan Lokasi";
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
                }).addTo(map).bindPopup("<div class='font-sans text-xs p-1'><b>Lokasi Anda</b></div>");

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
