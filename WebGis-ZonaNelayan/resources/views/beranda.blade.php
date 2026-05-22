<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - WebGIS Zona Nelayan</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Scripts & Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-screen">

    <!-- Header / Navbar Sticky -->
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
                    <a href="/peta" class="hidden sm:inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-blue-600 transition px-3 py-2">
                        🗺️ Peta Interaktif
                    </a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white text-sm font-bold px-5 py-2.5 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center gap-2">
                                Dashboard Saya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-slate-50 hover:bg-slate-100 text-slate-700 text-sm font-bold px-5 py-2.5 rounded-full transition border border-slate-200">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white text-sm font-bold px-5 py-2.5 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                                    Registrasi
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-blue-800 text-white py-24 sm:py-32 overflow-hidden">
        <!-- Background Decorative Elements -->
        <div class="absolute inset-0 opacity-10 pointer-events-none select-none">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-sky-500 rounded-full filter blur-[120px] opacity-20 pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-500 filter blur-[120px] opacity-20 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                <!-- Left: Text & Call to Action -->
                <div class="text-center lg:text-left space-y-6 sm:space-y-8">
                    <div class="inline-flex items-center gap-2 bg-blue-500/10 text-blue-300 text-xs font-bold px-4 py-2 rounded-full border border-blue-400/20 backdrop-blur-sm">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        Sistem Informasi Geospasial Partisipatif Nelayan
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-none text-white">
                        Pemetaan Partisipatif <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-sky-200">Laut Kita Bersama</span>
                    </h1>
                    <p class="text-slate-300 text-base sm:text-lg lg:text-xl max-w-xl mx-auto lg:mx-0 leading-relaxed font-medium">
                        Platform pelaporan kondisi laut secara real-time dari nelayan, untuk nelayan. Bersama-sama memetakan zona aman, zona rawan bahaya, dan zona perlindungan untuk keselamatan navigasi pelayaran.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="/peta" class="w-full sm:w-auto bg-white text-blue-900 font-extrabold px-8 py-4.5 rounded-2xl shadow-xl hover:shadow-white/5 transition hover:-translate-y-0.5 duration-200 text-center flex items-center justify-center gap-3">
                            <!-- Compass icon SVG -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Buka Peta Interaktif
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="w-full sm:w-auto bg-blue-600/30 hover:bg-blue-600/50 text-white font-bold px-8 py-4.5 rounded-2xl border border-blue-400/30 backdrop-blur-sm transition duration-200 text-center">
                                Gabung Jadi Pelapor
                            </a>
                        @endguest
                    </div>
                </div>

                <!-- Right: Map Mockup illustration -->
                <div class="relative w-full max-w-md lg:max-w-none mx-auto group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-500 to-cyan-500 rounded-3xl filter blur-xl opacity-30 group-hover:opacity-40 transition duration-300"></div>
                    <div class="relative bg-slate-950/80 border border-slate-800 rounded-3xl p-6 shadow-2xl backdrop-blur">
                        <!-- Mock Map Header -->
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-4">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                            </div>
                            <span class="text-xs font-mono text-slate-500 font-bold">radar_view_active.sh</span>
                        </div>
                        <!-- Mock Grid -->
                        <div class="relative h-64 bg-slate-900 rounded-2xl overflow-hidden border border-slate-800 flex items-center justify-center">
                            <!-- Circular radar lines -->
                            <div class="absolute w-48 h-48 rounded-full border border-slate-800/80 flex items-center justify-center">
                                <div class="w-32 h-32 rounded-full border border-slate-800/80 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full border border-slate-800/80"></div>
                                </div>
                            </div>
                            <!-- Radar sweep sweep -->
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/0 via-blue-500/0 to-blue-500/10 origin-center animate-spin" style="animation-duration: 6s;"></div>
                            
                            <!-- Floating nodes/markers -->
                            <div class="absolute top-12 left-1/4 flex flex-col items-center">
                                <span class="flex h-3 w-3 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                </span>
                                <span class="text-[9px] font-mono text-emerald-400 mt-1 font-bold">ZONA_AMAN</span>
                            </div>
                            <div class="absolute bottom-16 right-1/4 flex flex-col items-center">
                                <span class="flex h-3 w-3 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                                </span>
                                <span class="text-[9px] font-mono text-rose-400 mt-1 font-bold">BAHAYA_KARANG</span>
                            </div>
                            <div class="absolute top-1/2 right-1/3 flex flex-col items-center">
                                <span class="flex h-3 w-3 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                                </span>
                                <span class="text-[9px] font-mono text-amber-400 mt-1 font-bold">OMBAK_BESAR</span>
                            </div>
                            
                            <!-- Grid lines -->
                            <div class="absolute inset-0 grid grid-cols-4 grid-rows-4 pointer-events-none opacity-10">
                                <div class="border-b border-r border-slate-100"></div>
                                <div class="border-b border-r border-slate-100"></div>
                                <div class="border-b border-r border-slate-100"></div>
                                <div class="border-b border-slate-100"></div>
                                <div class="border-b border-r border-slate-100"></div>
                                <div class="border-b border-r border-slate-100"></div>
                                <div class="border-b border-r border-slate-100"></div>
                                <div class="border-b border-slate-100"></div>
                            </div>
                            
                            <!-- Text overlay -->
                            <div class="absolute bottom-3 left-3 bg-slate-950/80 border border-slate-800 px-3 py-1.5 rounded-lg text-[10px] font-mono text-sky-400 font-bold">
                                GPS: 2.5489 S, 118.0148 E
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Statistik Row (Overlaps Hero) -->
    <section class="-mt-16 relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Laporan -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-xl hover:-translate-y-1 transition duration-300 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 shadow-inner">
                    <!-- Report Icon -->
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <div class="text-3xl font-black text-slate-900 tracking-tight">{{ $total }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Total Laporan</div>
                </div>
            </div>

            <!-- Zona Aman -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-xl hover:-translate-y-1 transition duration-300 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 shadow-inner">
                    <!-- Shield check Icon -->
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <div class="text-3xl font-black text-slate-900 tracking-tight text-emerald-600">{{ $aman }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Zona Aman</div>
                </div>
            </div>

            <!-- Zona Rawan -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-xl hover:-translate-y-1 transition duration-300 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 shadow-inner">
                    <!-- Warning Triangle Icon -->
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <div class="text-3xl font-black text-slate-900 tracking-tight text-amber-600">{{ $rawan }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Zona Rawan</div>
                </div>
            </div>

            <!-- Zona Larangan -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-xl hover:-translate-y-1 transition duration-300 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 shadow-inner">
                    <!-- Ban Icon -->
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                </div>
                <div>
                    <div class="text-3xl font-black text-slate-900 tracking-tight text-rose-600">{{ $larangan }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Zona Larangan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Sistem (Features Section) -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Bagaimana Sistem Bekerja?
            </h2>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed">
                Sistem WebGIS ini merubah data koordinat dari para nelayan di lapangan menjadi visualisasi peta yang sangat mudah dipahami.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-black mb-6 text-xl">
                    1
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Tandai Lokasi</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Nelayan terdaftar dapat dengan mudah mengaktifkan GPS dan menandai wilayah strategis aman tangkapan, area terumbu karang yang dilindungi, atau titik rawan bahaya langsung dari atas kapal.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-black mb-6 text-xl">
                    2
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Visualisasi Real-time</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Laporan koordinat yang disimpan langsung divisualisasikan dalam bentuk pin peta berwarna (hijau, kuning, merah) pada sistem WebGIS untuk memastikan data aktual langsung tersedia.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-black mb-6 text-xl">
                    3
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Navigasi Aman</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Melalui peta interaktif, seluruh pelaut dan komunitas perikanan dapat bersama-sama merencanakan pelayaran yang aman, meminimalisir kecelakaan laut, dan menjaga ekosistem terumbu karang.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <div class="flex items-center justify-center gap-2 text-slate-900 font-extrabold">
                <span>🌊</span> WebGIS Nelayan
            </div>
            <p class="text-slate-400 text-xs font-medium">
                &copy; {{ date('Y') }} WebGIS Zona Nelayan. Dibuat untuk keselamatan navigasi dan kelestarian laut Indonesia.
            </p>
        </div>
    </footer>

</body>
</html>
