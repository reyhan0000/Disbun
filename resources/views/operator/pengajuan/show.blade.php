<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $pengajuan->nomor_surat }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-end mb-4">
                <a href="{{ route('operator.pengajuan.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-emerald-700 bg-white border border-gray-300 rounded px-4 py-2 shadow-sm transition">
                    &larr; Kembali ke Antrean
                </a>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column: Input Data -->
                <div class="space-y-6">
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
                                    <p class="text-sm text-gray-500">Status</p>
                                    <p class="font-medium">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                            {{ str_replace('_', ' ', strtoupper($pengajuan->status)) }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            @if($pengajuan->verified_at)
                            <div class="mt-4 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                                <h4 class="font-bold text-blue-800 mb-2">Riwayat Verifikasi</h4>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div><p class="text-gray-500">Diverifikasi oleh:</p><p class="font-medium">{{ $pengajuan->verifiedBy->name ?? 'Operator' }}</p></div>
                                    <div><p class="text-gray-500">Tanggal:</p><p class="font-medium">{{ \Carbon\Carbon::parse($pengajuan->verified_at)->format('d M Y H:i') }}</p></div>
                                    <div class="col-span-2"><p class="text-gray-500">Catatan:</p><p class="font-medium">{{ $pengajuan->verification_notes ?? '-' }}</p></div>
                                </div>
                            </div>
                            @endif

                            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-emerald-800">2. Profil Kebun / Pekebun</h3>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="col-span-2"><p class="text-sm text-gray-500">Nama Kebun / Pekebun</p><p class="font-bold text-lg text-emerald-900">{{ $pengajuan->nama_kelompok_tani }}</p></div>
                                <div><p class="text-sm text-gray-500">No Registrasi (SK)</p><p class="font-medium">{{ $pengajuan->no_kelompok_tani ?? '-' }}</p></div>
                                <div><p class="text-sm text-gray-500">Nama Ketua Kelompok</p><p class="font-medium">{{ $pengajuan->ketua_kelompok ?? '-' }}</p></div>
                                <div><p class="text-sm text-gray-500">Kabupaten/Kota</p><p class="font-medium">{{ $pengajuan->kabupaten_kota ?? '-' }}</p></div>
                                <div><p class="text-sm text-gray-500">Komoditas Utama</p><p class="font-medium">{{ $pengajuan->komoditas_utama ?? '-' }}</p></div>
                                <div><p class="text-sm text-gray-500">Luas Lahan (Ha)</p><p class="font-medium">{{ $pengajuan->luas_lahan_ha ?? '-' }} Ha</p></div>
                                <div><p class="text-sm text-gray-500">Jumlah Anggota</p><p class="font-medium">{{ $pengajuan->jumlah_anggota ?? '-' }} Orang</p></div>
                            </div>
                            
                            @if($pengajuan->alasan_penolakan)
                                <div class="mt-4 p-3 bg-red-50 border-l-4 border-red-500 text-sm text-red-700">
                                    <p class="font-bold">Alasan Penolakan Sebelumnya</p>
                                    <p>{{ $pengajuan->alasan_penolakan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Dokumen Surat Pengajuan</h3>
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
                </div>

                <!-- Right Column: API Data -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-fit border-2 border-emerald-500">
                    <div class="p-6 text-gray-900 bg-emerald-50/50">
                        <div class="flex items-center justify-between mb-4 border-b border-emerald-200 pb-2">
                            <h3 class="text-lg font-bold text-emerald-800">Data Verifikasi API Pusat</h3>
                            <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2 py-1 rounded">Live Data</span>
                        </div>
                        
                        @if($apiData)
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="col-span-2"><p class="text-sm font-bold text-emerald-700 uppercase tracking-wide">Nama Kebun / Pekebun</p><p class="font-bold text-lg text-gray-900">{{ $apiData['nama'] }}</p></div>
                                <div><p class="text-sm font-bold text-emerald-700 uppercase tracking-wide">Kode Kelompok</p><p class="font-medium text-gray-900">{{ $apiData['kode_kelompok'] }}</p></div>
                                <div><p class="text-sm font-bold text-emerald-700 uppercase tracking-wide">Nama Ketua</p><p class="font-medium text-gray-900">{{ $apiData['nama_ketua'] }}</p></div>
                                <div class="col-span-2"><p class="text-sm font-bold text-emerald-700 uppercase tracking-wide">Alamat Terdaftar</p><p class="font-medium text-gray-900">{{ $apiData['alamat'] }}, {{ $apiData['kelurahan'] }}, {{ $apiData['kecamatan'] }}, {{ $apiData['kabupaten'] }}</p></div>
                                <div><p class="text-sm font-bold text-emerald-700 uppercase tracking-wide">Komoditas (Jenis Komoditi)</p><p class="font-medium text-gray-900">{{ $apiData['komoditas_utama'] }}</p></div>
                                <div><p class="text-sm font-bold text-emerald-700 uppercase tracking-wide">Kelas Kelompok</p><p class="font-medium text-gray-900">{{ $apiData['jenis_kelas'] }}</p></div>
                                <div><p class="text-sm font-bold text-emerald-700 uppercase tracking-wide">Luas Lahan (Ha)</p><p class="font-medium text-gray-900">{{ $apiData['luas_lahan_ha'] }} Ha</p></div>
                                <div><p class="text-sm font-bold text-emerald-700 uppercase tracking-wide">Jumlah Anggota</p><p class="font-medium text-gray-900">{{ $apiData['jumlah_anggota'] }} Orang ({{ $apiData['anggota_laki_laki'] }} Laki-Laki, {{ $apiData['anggota_perempuan'] }} Perempuan)</p></div>
                                <div><p class="text-sm font-bold text-emerald-700 uppercase tracking-wide">Tahun Berdiri</p><p class="font-medium text-gray-900">{{ $apiData['tahun_berdiri'] }}</p></div>
                            </div>
                            
                            @if($pengajuan->status == 'pending_operator')
                            <div class="mt-6 p-4 bg-white border border-emerald-300 rounded shadow-sm text-sm text-emerald-800">
                                <p class="font-bold mb-1">Tugas Operator:</p>
                                <p>Silakan bandingkan <strong>Nama Ketua</strong>, <strong>Nomor SK</strong>, dan cap/tanda tangan pada dokumen surat di sebelah kiri dengan data pusat di atas sebelum meloloskan pengajuan ini.</p>
                            </div>
                            @endif
                        @else
                            <div class="p-4 bg-red-100 border border-red-400 rounded shadow-sm text-sm text-red-800">
                                <p class="font-bold mb-1">Data Tidak Ditemukan!</p>
                                <p>Tidak ada data di database pusat yang cocok dengan nama Kebun / Pekebun ini. Pengajuan sebaiknya <strong>ditolak</strong>.</p>
                            </div>
                        @endif
                    </div>
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
            @if($pengajuan->status == 'pending_operator')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-emerald-700">Aksi Verifikasi Operator</h3>
                    <form action="{{ route('operator.pengajuan.verify', $pengajuan) }}" method="POST">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <button type="submit" name="keputusan" value="terima" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-2 px-6 rounded shadow-md transform transition hover:-translate-y-0.5 focus:outline-none focus:shadow-outline" onclick="return confirm('Apakah Anda yakin ingin meloloskan pengajuan ini ke Kabid? Pastikan dokumen telah sesuai dengan API Pusat.');">
                                Verifikasi (Loloskan ke Kabid)
                            </button>
                            <button type="button" onclick="document.getElementById('modal-reject').classList.remove('hidden')" class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white font-bold py-2 px-6 rounded shadow-md transform transition hover:-translate-y-0.5 focus:outline-none focus:shadow-outline">
                                Tolak Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Tolak -->
            <div id="modal-reject" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form action="{{ route('operator.pengajuan.verify', $pengajuan) }}" method="POST">
                            @csrf
                            <input type="hidden" name="keputusan" value="tolak">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tolak Pengajuan (Operator)</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 mb-2">Silakan masukkan alasan penolakan untuk Kebun / Pekebun.</p>
                                        <textarea name="alasan_penolakan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Konfirmasi Tolak
                                </button>
                                <button type="button" onclick="document.getElementById('modal-reject').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            @if($pengajuan->status == 'approved_kabid')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-emerald-500 mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-emerald-700">Unggah Dokumen BAST</h3>
                    <p class="text-sm text-gray-600 mb-6">Pengajuan telah disetujui oleh Kabid. Silakan unggah dokumen Berita Acara Serah Terima (BAST) untuk menyelesaikan proses ini.</p>
                    
                    <form action="{{ route('operator.pengajuan.uploadBast', $pengajuan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="file_bast">
                                Pilih File BAST (PDF, JPG, PNG) <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white" id="file_bast" type="file" name="file_bast" accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                        <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-2 px-6 rounded shadow-md transform transition hover:-translate-y-0.5 focus:outline-none focus:shadow-outline">
                            Simpan & Selesaikan Pengajuan
                        </button>
                    </form>
                </div>
            </div>
            @endif
            
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
