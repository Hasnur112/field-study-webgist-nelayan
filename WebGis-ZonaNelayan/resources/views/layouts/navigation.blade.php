<aside 
    x-show="true"
    class="fixed inset-y-0 left-0 z-[110] w-72 bg-white border-r border-slate-100 flex flex-col transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shadow-2xl lg:shadow-none"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <!-- Sidebar Header (Logo) -->
    <div class="h-20 flex items-center px-8 shrink-0 border-b border-slate-50">
        <a href="/" class="flex items-center gap-3 group">
            <div class="bg-blue-600 p-2 rounded-xl shadow-lg shadow-blue-200 transition group-hover:scale-110">
                <span class="text-white text-xl">🌊</span>
            </div>
            <span class="font-black text-xl text-slate-800 tracking-tighter">WebGIS <span class="text-blue-600">Nelayan</span></span>
        </a>
    </div>

    <!-- Sidebar Links -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        <div class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Menu Utama</div>
        
        <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all duration-200 {{ request()->is('/') ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
            <span class="text-lg">🏠</span>
            Beranda
        </a>

        <a href="/peta" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all duration-200 {{ request()->is('peta') ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
            <span class="text-lg">🗺️</span>
            Peta Interaktif
        </a>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
            <span class="text-lg">📊</span>
            Log Laporan
        </a>

        <div class="pt-8 px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Bantuan</div>
        
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all duration-200">
            <span class="text-lg">📖</span>
            Panduan Pengguna
        </a>
    </nav>

    <!-- Sidebar Footer (User Profile) -->
    <div class="p-4 border-t border-slate-50 bg-slate-50/30">
        <div class="p-4 bg-white rounded-[1.5rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-2xl flex items-center justify-center text-lg shadow-inner">👤</div>
                <div class="overflow-hidden">
                    <p class="font-black text-sm text-slate-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-center py-2 bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 rounded-xl transition text-[10px] font-black uppercase tracking-wider border border-slate-100">
                    Profil
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="flex">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl transition text-[10px] font-black uppercase tracking-wider border border-rose-100">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Overlay Toggle -->
    <button 
        @click="sidebarOpen = false" 
        class="lg:hidden absolute top-6 -right-12 bg-white p-2 rounded-xl shadow-xl text-slate-600"
        x-show="sidebarOpen"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</aside>

<!-- Backdrop for mobile -->
<div 
    x-show="sidebarOpen" 
    @click="sidebarOpen = false" 
    class="fixed inset-0 z-[105] bg-slate-900/40 backdrop-blur-sm lg:hidden"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
></div>

