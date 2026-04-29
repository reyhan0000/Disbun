<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Dasbor Utama') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Banner with Glassmorphism -->
            <div class="relative rounded-2xl shadow-lg mb-6 overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-700">
                <div class="px-6 py-6 text-white">
                    <h1 class="text-2xl font-extrabold mb-1">Selamat Datang, {{ Auth::user()->name }}</h1>
                    <p class="text-blue-100 text-base max-w-2xl">Pantau seluruh pergerakan pengajuan bantuan sarana dan prasarana di wilayah Anda secara real-time.</p>
                </div>
                <div class="absolute right-6 bottom-4 opacity-20">
                    <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
            </div>

            <!-- Stats Grid with Glass Effect -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Stat Card 1 - Total -->
                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Pengajuan</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $stats['total'] }}</p>
                    </div>
                </div>

                <!-- Stat Card 2 - Disetujui -->
                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Disetujui</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-emerald-600 transition-colors">{{ $stats['disetujui'] }}</p>
                    </div>
                </div>

                <!-- Stat Card 3 - Ditolak -->
                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-red-500 to-rose-500 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Ditolak / Batal</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-red-600 transition-colors">{{ $stats['ditolak'] }}</p>
                    </div>
                </div>

                <!-- Stat Card 4 - Menunggu -->
                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Menunggu Verifikasi</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors">{{ $stats['menunggu'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Pengajuan Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow duration-300">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <span class="w-2 h-6 bg-green-500 rounded-full mr-2"></span>
                    Pengajuan Terbaru
                </h3>
                
                @if($recent && $recent->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komoditas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recent as $pengajuan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pengajuan->kode_pengajuan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pengajuan->komoditas_utama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(in_array($pengajuan->status, ['approved_full', 'approved_partial', 'approved_kabid']))
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                            @elseif(in_array($pengajuan->status, ['rejected_operator', 'rejected_kabid']))
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pengajuan->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('petani.pengajuan.show', $pengajuan) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('petani.pengajuan.index') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">Lihat semua →</a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="mt-2 text-gray-500">Belum ada pengajuan. Mulai ajukan bantuan sekarang!</p>
                        <a href="{{ route('petani.pengajuan.create') }}" class="mt-4 inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">Ajukan Bantuan</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
