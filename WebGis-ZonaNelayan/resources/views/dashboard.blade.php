<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen font-sans text-slate-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Terintegrasi -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10 px-2">
                <div>
                    <h2 class="font-black text-3xl text-slate-800 tracking-tight flex items-center gap-3">
                        <span class="bg-blue-600 text-white p-2.5 rounded-2xl shadow-lg shadow-blue-100">📊</span>
                        {{ __('Log Laporan Zona') }}
                    </h2>
                    <p class="text-slate-500 mt-1 font-medium italic">Manajemen data pemetaan partisipatif nelayan.</p>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-blue-600 bg-blue-50/50 px-4 py-2.5 rounded-full border border-blue-100 self-start md:self-center">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    Status Sistem: Terhubung
                </div>
            </div>
            
            <!-- Pesan Sukses -->
            @if (session('status'))
                <div class="mb-8 bg-emerald-50 border border-emerald-200 text-emerald-800 p-5 rounded-2xl shadow-sm flex items-center gap-4 animate-bounce-subtle" role="alert">
                    <div class="bg-emerald-500 text-white p-2 rounded-full shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="font-bold text-lg">Konfirmasi Berhasil</p>
                        <p class="text-sm opacity-90">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <!-- Statistik Summary -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 text-center transition hover:shadow-md">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Titik</p>
                    <p class="text-3xl font-black text-blue-600">{{ $laporan->count() }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 text-center transition hover:shadow-md">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Zona Aman</p>
                    <p class="text-3xl font-black text-emerald-500">{{ $laporan->where('kategori_zona', 1)->count() }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 text-center transition hover:shadow-md">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Zona Rawan</p>
                    <p class="text-3xl font-black text-amber-500">{{ $laporan->where('kategori_zona', 2)->count() }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 text-center transition hover:shadow-md">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Larangan</p>
                    <p class="text-3xl font-black text-rose-500">{{ $laporan->where('kategori_zona', 3)->count() }}</p>
                </div>
            </div>

            <!-- Banner Aksi Utama -->
            <div class="mb-12 relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-800 rounded-[2rem] p-8 md:p-10 shadow-2xl text-white border-4 border-white">
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl md:text-3xl font-black mb-3 leading-tight tracking-tight text-white shadow-sm">Selamat Datang, {{ Auth::user()->name }}</h3>
                        <p class="text-blue-50 opacity-90 max-w-md text-base leading-relaxed">Kelola laporan zonasi dan pantau titik koordinat untuk mendukung keselamatan navigasi laut bersama.</p>
                    </div>
                    <a href="/peta" class="bg-white text-blue-700 hover:bg-blue-50 font-black py-4 px-10 rounded-2xl shadow-lg transform transition hover:-translate-y-1 hover:scale-105 active:scale-95 text-lg flex items-center gap-3">
                        🧭 Peta Interaktif
                    </a>
                </div>
                <!-- Dekorasi Latar Belakang -->
                <div class="absolute -bottom-6 -right-10 opacity-10 rotate-12 select-none">
                    <span class="text-[12rem]">🌊</span>
                </div>
            </div>

            <div class="flex items-center justify-between mb-8 px-2 border-b border-slate-200 pb-4">
                <h3 class="text-xl font-black text-slate-800 flex items-center gap-3">
                    Riwayat Laporan Saya
                    <span class="px-2 py-1 bg-slate-100 text-slate-500 text-[10px] rounded-md font-bold uppercase tracking-widest">Aktivitas Terbaru</span>
                </h3>
            </div>

            @if($laporan->isEmpty())
                <!-- State Kosong Modern -->
                <div class="bg-white rounded-3xl shadow-sm p-20 text-center border-2 border-dashed border-slate-200">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                        <span class="text-5xl opacity-40">📄</span>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-3">Belum Ada Laporan Terdaftar</h3>
                    <p class="text-slate-500 max-w-sm mx-auto leading-relaxed text-base">Anda belum memiliki riwayat laporan terverifikasi. Silakan mulai menandai lokasi strategis atau area bahaya pada peta interaktif.</p>
                    <a href="/peta" class="mt-8 inline-block bg-blue-50 text-blue-600 font-bold px-6 py-3 rounded-xl hover:bg-blue-100 transition duration-200">Kirim Laporan Baru &rarr;</a>
                </div>
            @else
                <!-- Daftar Card Laporan Modern -->
                <div class="grid gap-8">
                    @foreach($laporan as $lap)
                        <div class="group bg-white rounded-3xl shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <!-- Indikator Warna Samping -->
                                <div class="w-full md:w-4 {{ $lap->kategori_zona == 1 ? 'bg-emerald-500' : ($lap->kategori_zona == 2 ? 'bg-amber-500' : 'bg-rose-500') }}"></div>
                                
                                <div class="flex-1 p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-4 mb-4">
                                            @if($lap->kategori_zona == 1)
                                                <span class="bg-emerald-50 text-emerald-700 text-xs font-black px-4 py-2 rounded-xl border border-emerald-100 uppercase tracking-tighter">🟢 Zona Aman</span>
                                            @elseif($lap->kategori_zona == 2)
                                                <span class="bg-amber-50 text-amber-700 text-xs font-black px-4 py-2 rounded-xl border border-amber-100 uppercase tracking-tighter">🟡 Zona Rawan</span>
                                            @else
                                                <span class="bg-rose-50 text-rose-700 text-xs font-black px-4 py-2 rounded-xl border border-rose-100 uppercase tracking-tighter">🔴 Zona Larangan</span>
                                            @endif
                                            <span class="text-xs text-slate-400 font-bold uppercase tracking-widest">{{ $lap->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <h4 class="text-xl font-bold text-slate-800 mb-3 leading-snug tracking-tight">
                                            {{ $lap->keterangan ? '"'.$lap->keterangan.'"' : 'Tidak ada keterangan tambahan.' }}
                                        </h4>
                                        
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                                                <span class="text-slate-400 text-xs">📍</span>
                                                <span class="text-xs font-mono font-bold text-slate-600">{{ number_format($lap->latitude, 5) }}, {{ number_format($lap->longitude, 5) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 w-full md:w-auto pt-6 md:pt-0 border-t md:border-t-0 border-slate-50">
                                        <button onclick="document.getElementById('edit-modal-{{ $lap->id }}').classList.remove('hidden')" class="flex-1 md:flex-none bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-700 font-black py-3 px-6 rounded-2xl transition duration-200 text-sm flex items-center justify-center gap-2 border border-transparent hover:border-blue-100">
                                            <span>✏️</span> Edit
                                        </button>
                                        
                                        <form action="{{ route('lapor.destroy', $lap->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini secara permanen?');" class="flex-1 md:flex-none">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-slate-50 hover:bg-rose-50 text-slate-600 hover:text-rose-600 font-black py-3 px-6 rounded-2xl transition duration-200 text-sm flex items-center justify-center gap-2 border border-transparent hover:border-rose-100">
                                                <span>🗑️</span> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit Premium (Glassmorphism) -->
                        <div id="edit-modal-{{ $lap->id }}" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-[100] flex items-center justify-center p-4">
                            <div class="relative p-10 w-full max-w-lg shadow-[0_20px_50px_rgba(8,_112,_184,_0.7)] rounded-[2.5rem] bg-white border border-slate-200 animate-in fade-in zoom-in duration-300">
                                <div class="text-center">
                                    <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-8 text-4xl shadow-inner border border-blue-100">
                                        📄
                                    </div>
                                    <h3 class="text-3xl font-black text-slate-900 mb-3 tracking-tighter">Perbarui Data Laporan</h3>
                                    <p class="text-slate-500 mb-10 text-sm px-8 leading-relaxed font-medium">Silakan perbarui detail laporan untuk memastikan akurasi data pada sistem WebGIS Nelayan.</p>
                                    
                                    <form action="{{ route('lapor.update', $lap->id) }}" method="POST" class="text-left">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-8">
                                            <label class="block text-slate-700 font-black mb-3 text-xs tracking-widest uppercase opacity-60">Kategori Zonasi Baru</label>
                                            <div class="relative">
                                                <select name="kategori_zona" class="bg-slate-50 border-2 border-slate-100 text-slate-900 text-base rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full p-4.5 font-bold appearance-none transition-all shadow-sm">
                                                    <option value="1" {{ $lap->kategori_zona == 1 ? 'selected' : '' }}>🟢 Zona Aman (Banyak Ikan)</option>
                                                    <option value="2" {{ $lap->kategori_zona == 2 ? 'selected' : '' }}>🟡 Zona Rawan (Ombak/Karang)</option>
                                                    <option value="3" {{ $lap->kategori_zona == 3 ? 'selected' : '' }}>🔴 Zona Larangan (Bahaya/Adat)</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-5 pointer-events-none text-slate-400 font-black">
                                                    ↓
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-12">
                                            <label class="block text-slate-700 font-black mb-3 text-xs tracking-widest uppercase opacity-60">Detail Keterangan</label>
                                            <textarea name="keterangan" rows="4" class="bg-slate-50 border-2 border-slate-100 text-slate-900 text-base rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 block w-full p-5 transition-all shadow-sm resize-none" placeholder="Contoh: Arus kencang di jam tertentu...">{{ $lap->keterangan }}</textarea>
                                        </div>

                                        <div class="flex gap-4">
                                            <button type="button" onclick="document.getElementById('edit-modal-{{ $lap->id }}').classList.add('hidden')" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-black py-4.5 rounded-2xl transition duration-200 text-base tracking-tight border border-slate-200">Batal</button>
                                            <button type="submit" class="flex-[1.5] bg-blue-600 hover:bg-blue-700 text-white font-black py-4.5 px-8 rounded-2xl transition duration-200 shadow-xl shadow-blue-200 text-base flex items-center justify-center gap-3">
                                                💾 Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    <style>
        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .animate-bounce-subtle {
            animation: bounce-subtle 4s infinite ease-in-out;
        }
        select {
            background-image: none !important;
        }
    </style>
</x-app-layout>
