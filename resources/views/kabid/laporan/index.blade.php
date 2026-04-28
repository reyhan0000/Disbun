<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Laporan Pengajuan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan</h3>
                    <form method="GET" action="{{ route('kabid.laporan.filter') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="tanggal_awal" value="{{ __('Tanggal Awal') }}" />
                            <x-text-input id="tanggal_awal" class="block w-full mt-1" type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" />
                        </div>
                        <div>
                            <x-input-label for="tanggal_akhir" value="{{ __('Tanggal Akhir') }}" />
                            <x-text-input id="tanggal_akhir" class="block w-full mt-1" type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" />
                        </div>
                        <div>
                            <x-input-label for="status" value="{{ __('Status') }}" />
                            <select id="status" name="status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="pending_operator" {{ request('status') == 'pending_operator' ? 'selected' : '' }}>Menunggu Operator</option>
                                <option value="pending_kabid" {{ request('status') == 'pending_kabid' ? 'selected' : '' }}>Menunggu Kabid</option>
                                <option value="approved_full" {{ request('status') == 'approved_full' ? 'selected' : '' }}>Disetujui Full</option>
                                <option value="approved_partial" {{ request('status') == 'approved_partial' ? 'selected' : '' }}>Disetujui Sebagian</option>
                                <option value="approved_kabid" {{ request('status') == 'approved_kabid' ? 'selected' : '' }}>Disetujui Kabid</option>
                                <option value="rejected_operator" {{ request('status') == 'rejected_operator' ? 'selected' : '' }}>Ditolak Operator</option>
                                <option value="rejected_kabid" {{ request('status') == 'rejected_kabid' ? 'selected' : '' }}>Ditolak Kabid</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="nama_kelompok" value="{{ __('Nama Kebun / Pekebun') }}" />
                            <x-text-input id="nama_kelompok" class="block w-full mt-1" type="text" name="nama_kelompok" placeholder="Cari..." value="{{ request('nama_kelompok') }}" />
                        </div>
                        <div class="md:col-span-4 flex gap-2">
                            <x-primary-button type="submit">
                                {{ __('Filter') }}
                            </x-primary-button>
                            <a href="{{ route('kabid.laporan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-gray-400 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Reset
                            </a>
                            <a href="{{ route('kabid.laporan.print', request()->query()) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Surat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kebun / Pekebun</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perihal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pengajuans as $index => $pengajuan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pengajuan->nomor_surat }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $pengajuan->nama_kelompok_tani }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $pengajuan->perihal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->translatedFormat('d F Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($pengajuan->status)
                                                @case('pending_operator')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Operator</span>
                                                    @break
                                                @case('pending_kabid')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Menunggu Kabid</span>
                                                    @break
                                                @case('approved_full')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui Full</span>
                                                    @break
                                                @case('approved_partial')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui Sebagian</span>
                                                    @break
                                                @case('approved_kabid')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui Kabid</span>
                                                    @break
                                                @case('rejected_operator')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak Operator</span>
                                                    @break
                                                @case('rejected_kabid')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak Kabid</span>
                                                    @break
                                                @default
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $pengajuan->status }}</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>