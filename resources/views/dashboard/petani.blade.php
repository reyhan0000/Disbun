<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Dasbor Personal') }}
        </h2>
    </x-slot>

<div class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Banner with Glassmorphism -->
            <div class="relative rounded-2xl shadow-lg mb-6 overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-700">
                <div class="px-6 py-6 text-white">
                    <h1 class="text-2xl font-extrabold mb-1">Halo, {{ Auth::user()->name }}</h1>
                    <p class="text-blue-100 text-base max-w-2xl">Selamat datang di Sistem Informasi Bantuan Sarana Prasarana (SIBANSAR).</p>
                </div>
                <div class="absolute right-6 bottom-4 opacity-20">
                    <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </div>
            </div>


            <!-- Stats Grid with Glass Effect -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Stat Card 1 - Total -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="absolute right-0 top-0 mt-4 mr-4 text-gray-100 group-hover:text-gray-200 transition-colors">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pengajuan</p>
                        <p class="text-4xl font-extrabold text-gray-800 mt-2 group-hover:text-blue-600 transition-colors">{{ $stats['total'] }}</p>
                        <p class="text-xs text-gray-400 mt-2">Sepanjang riwayat</p>
                    </div>
                </div>

                <!-- Stat Card 2 - Approved -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="absolute right-0 top-0 mt-4 mr-4 text-emerald-50 group-hover:text-emerald-100 transition-colors">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-emerald-600 uppercase tracking-wider">Bantuan Disetujui</p>
                        <p class="text-4xl font-extrabold text-emerald-600 mt-2 group-hover:text-emerald-700 transition-colors">{{ $stats['disetujui'] }}</p>
                        <p class="text-xs text-emerald-400 mt-2">Menunggu pengiriman</p>
                    </div>
                </div>

                <!-- Stat Card 3 - Pending -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="absolute right-0 top-0 mt-4 mr-4 text-yellow-50 group-hover:text-yellow-100 transition-colors">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-yellow-600 uppercase tracking-wider">Sedang Diproses</p>
                        <p class="text-4xl font-extrabold text-yellow-600 mt-2 group-hover:text-yellow-700 transition-colors">{{ $stats['menunggu'] }}</p>
                        <p class="text-xs text-yellow-400 mt-2">Dalam antrean verifikasi</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity with Glass Effect -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white/50">
                    <h3 class="text-lg font-bold text-gray-800">Riwayat Pengajuan Terbaru</h3>
                    <a href="{{ route('petani.pengajuan.index') }}" class="text-sm text-emerald-600 hover:text-emerald-800 font-medium transition-colors">Lihat Semua &rarr;</a>
                </div>
                
                @if($recent->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($recent as $item)
                        <div class="p-6 flex items-center justify-between hover:bg-emerald-50/30 transition-colors duration-300 group">
                            <div class="flex items-start">
                                <div class="bg-gradient-to-br from-gray-100 to-gray-200 group-hover:from-emerald-100 group-hover:to-teal-100 rounded-full p-3 mr-4 transition-all duration-300">
                                    <svg class="w-5 h-5 text-gray-500 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-md font-bold text-gray-800 group-hover:text-emerald-700 transition-colors">{{ $item->perihal }}</h4>
                                    <p class="text-sm text-gray-500">Nomor: {{ $item->nomor_surat }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if(in_array($item->status, ['pending_operator', 'pending_kabid']))
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Menunggu
                                    </span>
                                @elseif(in_array($item->status, ['approved_full', 'approved_partial', 'approved_kabid']))
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        Ditolak
                                    </span>
                                @endif
                                <div class="mt-2">
                                    <a href="{{ route('petani.pengajuan.show', $item) }}" class="text-sm text-blue-600 hover:underline">Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Pengajuan</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai langkah pertama dengan mengajukan bantuan perkebunan.</p>
                    <div class="mt-6">
                        <a href="{{ route('petani.pengajuan.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all hover:scale-105">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Buat Pengajuan Baru
                        </a>
                    </div>
                </div>
                @endif
            </div>
            
        </div>
    </div>
</x-app-layout>