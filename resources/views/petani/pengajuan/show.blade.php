<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $pengajuan->nomor_surat }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-end mb-4">
                <a href="{{ route('petani.pengajuan.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-emerald-700 bg-white border border-gray-300 rounded px-4 py-2 shadow-sm transition">
                    &larr; Kembali ke Daftar
                </a>
            </div>
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
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-emerald-800">1. Data Administratif Surat</h3>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div><p class="text-sm text-gray-500">Nomor Surat</p><p class="font-medium">{{ $pengajuan->nomor_surat ?? '-' }}</p></div>
                        <div><p class="text-sm text-gray-500">Perihal</p><p class="font-medium">{{ $pengajuan->perihal ?? '-' }}</p></div>
                        <div><p class="text-sm text-gray-500">Tanggal Pengajuan</p><p class="font-medium">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y H:i') }}</p></div>
                        <div>
                            <p class="text-sm text-gray-500">Kategori Bantuan</p>
                            <p class="font-medium">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $pengajuan->kategori === 'prasarana' ? 'bg-purple-100 text-purple-800 border-purple-200' : 'bg-blue-100 text-blue-800 border-blue-200' }} border">
                                    {{ strtoupper($pengajuan->kategori ?? 'SARANA') }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status Pengajuan</p>
                            <p class="font-medium">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    {{ str_replace('_', ' ', strtoupper($pengajuan->status)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                            @if($pengajuan->verified_at || $pengajuan->verified_kabid_at)
                            <div class="mt-4 p-4 bg-gray-50 border-l-4 border-gray-400 rounded">
                                <h4 class="font-bold text-gray-700 mb-2">Riwayat Verifikasi</h4>
                                @if($pengajuan->verified_at)
                                <div class="grid grid-cols-2 gap-2 text-sm mb-2">
                                    <div><p class="text-gray-500">Verifikasi Operator:</p><p class="font-medium">{{ $pengajuan->verifiedBy->name ?? '-' }}</p></div>
                                    <div><p class="text-gray-500">Tanggal:</p><p class="font-medium">{{ \Carbon\Carbon::parse($pengajuan->verified_at)->format('d M Y H:i') }}</p></div>
                                </div>
                                @endif
                                @if($pengajuan->verified_kabid_at)
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div><p class="text-gray-500">Persetujuan Kabid:</p><p class="font-medium">{{ $pengajuan->verifiedKabidBy->name ?? '-' }}</p></div>
                                    <div><p class="text-gray-500">Tanggal:</p><p class="font-medium">{{ \Carbon\Carbon::parse($pengajuan->verified_kabid_at)->format('d M Y H:i') }}</p></div>
                                    <div class="col-span-2"><p class="text-gray-500">Keputusan:</p><p class="font-medium">{{ $pengajuan->verification_notes ?? '-' }}</p></div>
                                </div>
                                @endif
                            </div>
                            @endif

                            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-emerald-800">2. Biodata Kebun / Pekebun</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="col-span-2"><p class="text-sm text-gray-500">Nama Kebun / Pekebun</p><p class="font-bold text-lg text-emerald-900">{{ $pengajuan->nama_kelompok_tani }}</p></div>
                        <div><p class="text-sm text-gray-500">No Registrasi (SK)</p><p class="font-medium">{{ $pengajuan->no_kelompok_tani ?? '-' }}</p></div>
                        <div><p class="text-sm text-gray-500">Nama Ketua Kelompok</p><p class="font-medium">{{ $pengajuan->ketua_kelompok ?? '-' }}</p></div>
                        <div><p class="text-sm text-gray-500">Kabupaten/Kota Lokasi</p><p class="font-medium">{{ $pengajuan->kabupaten_kota ?? '-' }}</p></div>
                        <div><p class="text-sm text-gray-500">Komoditas Utama</p><p class="font-medium">{{ $pengajuan->komoditas_utama ?? '-' }}</p></div>
                        <div><p class="text-sm text-gray-500">Luas Lahan Garapan</p><p class="font-medium">{{ $pengajuan->luas_lahan_ha ?? '-' }} Hektar</p></div>
                        <div><p class="text-sm text-gray-500">Jumlah Anggota</p><p class="font-medium">{{ $pengajuan->jumlah_anggota ?? '-' }} Orang</p></div>
                        
                        @if($pengajuan->alasan_penolakan)
                            <div class="col-span-2 mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                                <p class="text-sm text-red-700 font-bold mb-1">Pesan Penolakan dari Operator/Kabid:</p>
                                <p class="font-medium text-red-600">{{ $pengajuan->alasan_penolakan }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Surat Pengajuan (Foto/Scan)</h3>
                    @if($pengajuan->file_surat_pengajuan)
                                @if(Str::endsWith(strtolower($pengajuan->file_surat_pengajuan), ['.pdf']))
                                    <div class="border rounded p-4 text-center bg-gray-50">
                                        <svg class="mx-auto h-12 w-12 text-red-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm text-gray-600 mb-2">Dokumen berformat PDF</p>
                                        <a href="{{ asset('storage/' . $pengajuan->file_surat_pengajuan) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700">
                                            Buka Dokumen PDF
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ asset('storage/' . $pengajuan->file_surat_pengajuan) }}" target="_blank" class="block">
                                        <img src="{{ asset('storage/' . $pengajuan->file_surat_pengajuan) }}" alt="Surat Pengajuan" class="w-full h-auto border rounded shadow-sm hover:opacity-90 transition-opacity">
                                    </a>
                                    <p class="text-xs text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                                @endif
                    @else
                        <p class="text-gray-500 text-sm">Tidak ada foto terlampir.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Daftar Barang Diminta</h3>
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang (Input)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                @if(in_array($pengajuan->status, ['approved_full', 'approved_partial']))
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggaran (Rp)</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Diminta</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Disetujui</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pengajuan->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama_barang }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">{{ $item->jenis_barang ?? '-' }}</span></td>
                                    @if(in_array($pengajuan->status, ['approved_full', 'approved_partial']))
                                    <td class="px-6 py-4 whitespace-nowrap text-green-600 font-medium">Rp {{ number_format($item->anggaran_disetujui ?? 0, 0, ',', '.') }}</td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->jumlah_diminta }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->satuan ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-green-600">
                                        {{ $item->jumlah_disetujui ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($pengajuan->file_bast)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-emerald-800">File BAST (Berita Acara Serah Terima)</h3>
                    @if(Str::endsWith(strtolower($pengajuan->file_bast), ['.pdf']))
                        <div class="border rounded p-4 text-center bg-gray-50">
                            <svg class="mx-auto h-12 w-12 text-red-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-600 mb-2">Dokumen BAST berformat PDF</p>
                            <a href="{{ asset('storage/' . $pengajuan->file_bast) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700">
                                Buka Dokumen BAST
                            </a>
                        </div>
                    @else
                        <a href="{{ asset('storage/' . $pengajuan->file_bast) }}" target="_blank" class="block">
                            <img src="{{ asset('storage/' . $pengajuan->file_bast) }}" alt="File BAST" class="w-full h-auto border rounded shadow-sm hover:opacity-90 transition-opacity">
                        </a>
                        <p class="text-xs text-gray-500 mt-2">Klik gambar BAST untuk memperbesar</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
