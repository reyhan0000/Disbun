<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Daftar Pengajuan Menunggu Persetujuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <a href="{{ route('kabid.persetujuan.index', ['tab' => 'masuk']) }}" class="{{ request('tab', 'masuk') == 'masuk' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Antrean Review
                            </a>
                            <a href="{{ route('kabid.persetujuan.index', ['tab' => 'riwayat']) }}" class="{{ request('tab', 'masuk') == 'riwayat' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Riwayat Persetujuan
                            </a>
                        </nav>
                    </div>
                    <form method="GET" action="{{ route('kabid.persetujuan.index') }}" class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <input type="hidden" name="tab" value="{{ request('tab', 'masuk') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="search" value="Cari (No. Surat/Perihal/Kebun)" />
                                <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" value="{{ request('search') }}" placeholder="Ketik kata kunci..." />
                            </div>
                            <div>
                                <x-input-label for="status" value="Status" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                    <option value="">Semua Status</option>
                                    @if(request('tab', 'masuk') == 'masuk')
                                        <option value="pending_kabid" {{ request('status') == 'pending_kabid' ? 'selected' : '' }}>Pending Kabid</option>
                                    @else
                                        <option value="approved_full_kabid" {{ request('status') == 'approved_full_kabid' ? 'selected' : '' }}>Disetujui Penuh (Menunggu BAST)</option>
                                        <option value="approved_partial_kabid" {{ request('status') == 'approved_partial_kabid' ? 'selected' : '' }}>Disetujui Sebagian (Menunggu BAST)</option>
                                        <option value="approved_full" {{ request('status') == 'approved_full' ? 'selected' : '' }}>Selesai (Disetujui Penuh)</option>
                                        <option value="approved_partial" {{ request('status') == 'approved_partial' ? 'selected' : '' }}>Selesai (Disetujui Sebagian)</option>
                                        <option value="rejected_kabid" {{ request('status') == 'rejected_kabid' ? 'selected' : '' }}>Ditolak (Proses Operator)</option>
                                        <option value="rejected_full" {{ request('status') == 'rejected_full' ? 'selected' : '' }}>Ditolak (Selesai)</option>
                                    @endif
                                </select>
                            </div>
                            <div class="flex items-end space-x-2">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                                    Filter
                                </button>
                                <a href="{{ route('kabid.persetujuan.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded shadow">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelompok Tani</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pengajuans as $pengajuan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ($pengajuans->currentPage() - 1) * $pengajuans->perPage() + $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $pengajuan->nomor_surat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pengajuan->nama_kelompok_tani }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pengajuan->tanggal_pengajuan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($pengajuan->status == 'pending_kabid')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Menunggu Review Anda</span>
                                        @elseif($pengajuan->status == 'approved_full' || $pengajuan->status == 'approved_partial')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Selesai (Disetujui)
                                            </span>
                                        @elseif($pengajuan->status == 'approved_full_kabid')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                                Disetujui Penuh (Menunggu BAST)
                                            </span>
                                        @elseif($pengajuan->status == 'approved_partial_kabid')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                Disetujui Sebagian (Menunggu BAST)
                                            </span>
                                        @elseif($pengajuan->status == 'rejected_kabid')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak (Proses Operator)</span>
                                        @elseif($pengajuan->status == 'rejected_full')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak (Selesai)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('kabid.persetujuan.show', $pengajuan) }}" class="text-emerald-600 hover:text-emerald-900 font-semibold flex items-center">
                                            {{ $pengajuan->status == 'pending_kabid' ? 'Review & Setujui' : 'Lihat Detail' }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Belum ada data pengajuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $pengajuans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
