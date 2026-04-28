<aside x-data="{ collapsed: JSON.parse(localStorage.getItem('sidebarCollapsed') || 'false') }" 
     :class="collapsed ? 'w-16' : 'w-64'"
     class="bg-white text-gray-800 border-r border-emerald-100 flex-shrink-0 hidden md:flex flex-col shadow-lg z-20 transition-all duration-300">
    
    <div class="h-16 flex items-center px-6 border-b border-emerald-100 bg-white" :class="collapsed ? 'justify-center px-2' : ''">
        <!-- Logo & Text - Show when expanded -->
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3" x-show="!collapsed">
            <img src="{{ asset('images/Logo_disbun.png') }}" alt="Logo DISBUN" class="h-8 w-auto object-contain">
            <span class="text-xl font-extrabold tracking-wider text-emerald-800 drop-shadow-sm">SiBANSAR</span>
        </a>
        
        <!-- Toggle Button - Show when expanded (next to SIBANSAR) -->
        <button @click="collapsed = !collapsed; localStorage.setItem('sidebarCollapsed', collapsed)" 
                class="ml-auto text-emerald-800 hover:bg-emerald-50 rounded-lg p-1.5 transition-colors shrink-0"
                x-show="!collapsed">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        
        <!-- Toggle Button - Show when collapsed (centered) -->
        <button @click="collapsed = !collapsed; localStorage.setItem('sidebarCollapsed', collapsed)" 
                class="text-emerald-800 hover:bg-emerald-50 rounded-lg p-1.5 transition-colors"
                x-show="collapsed">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <p x-show="!collapsed" class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
        
        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
            <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span x-show="!collapsed" class="ml-3">Dasbor Utama</span>
        </a>

        @if(Auth::user()->role === 'operator')
            <a href="{{ route('operator.pengajuan.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('operator.pengajuan.*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span x-show="!collapsed" class="ml-3">Antrean Verifikasi</span>
            </a>
            <a href="{{ route('operator.laporan.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('operator.laporan.*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-show="!collapsed" class="ml-3">Laporan</span>
            </a>
            <a href="{{ route('operator.notifikasi.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('operator.notifikasi.*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 5.849 6 7.664 6 9v5.158a2.032 2.032 0 01-.405 1.405L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span x-show="!collapsed" class="ml-3">Notifikasi</span>
                @php $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count(); @endphp
                @if($unreadCount > 0)
                <span x-show="!collapsed" class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm">{{ $unreadCount }}</span>
                @endif
            </a>
        @elseif(Auth::user()->role === 'kabid')
            <a href="{{ route('kabid.persetujuan.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('kabid.persetujuan.*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-show="!collapsed" class="ml-3">Persetujuan Bantuan</span>
            </a>
            <a href="{{ route('kabid.laporan.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('kabid.laporan.*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-show="!collapsed" class="ml-3">Laporan</span>
            </a>
            <a href="{{ route('kabid.notifikasi.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('kabid.notifikasi.*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 5.849 6 7.664 6 9v5.158a2.032 2.032 0 01-.405 1.405L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span x-show="!collapsed" class="ml-3">Notifikasi</span>
                @php $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count(); @endphp
                @if($unreadCount > 0)
                <span x-show="!collapsed" class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm">{{ $unreadCount }}</span>
                @endif
            </a>
        @elseif(Auth::user()->role === 'kelompok_tani')
            <a href="{{ route('petani.profil.index') }}" class="flex items-center px-3 py-2.5 mt-2 rounded-lg transition-colors {{ request()->routeIs('petani.profil.*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-show="!collapsed" class="ml-3">Biodata Kelompok Tani</span>
            </a>
            <a href="{{ route('petani.pengajuan.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('petani.pengajuan.*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-show="!collapsed" class="ml-3">Pengajuan Bantuan</span>
            </a>
            <a href="{{ route('petani.notifikasi.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('petani.notifikasi.*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 5.849 6 7.664 6 9v5.158a2.032 2.032 0 01-.405 1.405L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span x-show="!collapsed" class="ml-3">Notifikasi</span>
                @php $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count(); @endphp
                @if($unreadCount > 0)
                <span x-show="!collapsed" class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm">{{ $unreadCount }}</span>
                @endif
            </a>
        @elseif(Auth::user()->role === 'admin')
            <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <svg :class="collapsed ? 'mx-auto' : 'mr-3'" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span x-show="!collapsed" class="ml-3">Kelola User</span>
            </a>
        @endif
    </nav>
</aside>
