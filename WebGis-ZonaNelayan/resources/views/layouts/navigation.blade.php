<aside 
    x-show="true"
    class="fixed inset-y-0 left-0 z-[110] w-72 bg-white border-r border-slate-100 flex flex-col transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shadow-2xl lg:shadow-none"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <!-- Sidebar Header (Logo) -->
    <div class="h-20 flex items-center px-8 shrink-0 border-b border-slate-50">
        <a href="/" class="flex items-center gap-3 group">
            <div class="bg-blue-600 p-2.5 rounded-xl shadow-lg shadow-blue-200 transition group-hover:scale-110">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-8v12M3 6h18m-9 0v12"></path>
                </svg>
            </div>
            <span class="font-black text-xl text-slate-800 tracking-tighter">WebGIS <span class="text-blue-600">Nelayan</span></span>
        </a>
    </div>

    <!-- Sidebar Links -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        <div class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Menu Utama</div>
        
        <a href="/" class="group flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all duration-200 {{ request()->is('/') ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110 duration-200 {{ request()->is('/') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-500' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Beranda
        </a>

        <a href="/peta" class="group flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all duration-200 {{ request()->is('peta') ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110 duration-200 {{ request()->is('peta') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-500' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
            </svg>
            Peta Interaktif
        </a>

        <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-600' }}">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110 duration-200 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-500' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Log Laporan
        </a>

        <div class="pt-8 px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Bantuan</div>
        
        <a href="#" class="group flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-all duration-200">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-500 transition-transform group-hover:scale-110 duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Panduan Pengguna
        </a>
    </nav>

    <!-- Sidebar Footer (User Profile) -->
    <div class="p-4 border-t border-slate-50 bg-slate-50/30">
        <div class="p-4 bg-white rounded-[1.5rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-2xl flex items-center justify-center shadow-inner shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
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

