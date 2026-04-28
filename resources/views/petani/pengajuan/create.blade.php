<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Buat Pengajuan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('petani.pengajuan.store') }}" method="POST" enctype="multipart/form-data" id="pengajuanForm" onsubmit="return confirm('Konfirmasi Pengajuan Baru\n\nApakah Anda yakin ingin mengajukan bantuan? Data yang sudah dikirim tidak dapat diubah.')">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                                <strong class="font-bold">Terjadi Kesalahan!</strong>
                                <ul class="list-disc mt-2 ml-4">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="mb-6 border-b border-emerald-100 pb-6">
                            <h4 class="text-lg font-semibold text-emerald-800 mb-4 flex items-center"><span class="bg-emerald-600 text-white rounded-full w-6 h-6 inline-flex items-center justify-center text-sm mr-2">1</span> Data Administratif Surat</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nomor_surat">Nomor Surat Pengajuan <span class="text-red-500">*</span></label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-emerald-500" id="nomor_surat" type="text" name="nomor_surat" required placeholder="Contoh: 015/KT-SM/IV/2026">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="perihal">Perihal (Judul Bantuan) <span class="text-red-500">*</span></label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-emerald-500" id="perihal" type="text" name="perihal" required placeholder="Contoh: Permohonan Bantuan Traktor">
                                </div>
                            </div>
                        </div>

                        <div class="mb-6 border-b border-emerald-100 pb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-semibold text-emerald-800 flex items-center"><span class="bg-emerald-600 text-white rounded-full w-6 h-6 inline-flex items-center justify-center text-sm mr-2">2</span> Profil Kebun / Pekebun</h4>
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2 py-1 rounded">Otomatis dari Sistem Pusat</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-md border border-gray-200">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kebun / Pekebun</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['nama'] ?? Auth::user()->name }}" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Kode Kelompok</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['kode_kelompok'] ?? '-' }}" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Ketua</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['nama_ketua'] ?? '-' }}" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat (Desa/Kelurahan)</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['alamat'] ?? '-' }}" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Kabupaten/Kota</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['kabupaten'] ?? '-' }}" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Kecamatan</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['kecamatan'] ?? '-' }}" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Desa/Kelurahan</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['kelurahan'] ?? '-' }}" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Komoditas (Jenis Komoditi)</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['komoditas_utama'] ?? '-' }}" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Luas Lahan (Ha)</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['luas_lahan_ha'] ?? '-' }}" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Kelas Kelompok</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['jenis_kelas'] ?? '-' }}" disabled>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Tahun Berdiri</label>
                                    <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['tahun_berdiri'] ?? '-' }}" disabled>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Jml Anggota</label>
                                        <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['jumlah_anggota'] ?? '-' }}" disabled>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="block text-gray-700 text-xs font-bold mb-2">Laki-Laki</label>
                                            <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['anggota_laki_laki'] ?? '-' }}" disabled>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 text-xs font-bold mb-2">Perempuan</label>
                                            <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-500 bg-gray-100 leading-tight cursor-not-allowed" type="text" value="{{ $apiData['anggota_perempuan'] ?? '-' }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2"><svg class="w-4 h-4 inline text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Data profil tidak dapat diubah secara manual demi menjaga integritas data.</p>
                        </div>

                        <div class="mb-6 border-b border-emerald-100 pb-6">
                            <h4 class="text-lg font-semibold text-emerald-800 mb-4 flex items-center"><span class="bg-emerald-600 text-white rounded-full w-6 h-6 inline-flex items-center justify-center text-sm mr-2">3</span> Dokumen Lampiran</h4>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="file_surat_pengajuan">
                                    Scan Surat Pengajuan / Proposal Resmi (PDF/JPG) <span class="text-red-500">*</span>
                                </label>
                                <input class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white" id="file_surat_pengajuan" type="file" name="file_surat_pengajuan" accept="image/*,application/pdf" required>
                                <p class="text-xs text-emerald-600 mt-2"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Silakan unggah satu file yang memuat surat permohonan resmi Anda.</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-emerald-800 mb-4 flex items-center"><span class="bg-emerald-600 text-white rounded-full w-6 h-6 inline-flex items-center justify-center text-sm mr-2">4</span> Rincian Bantuan yang Diajukan</h4>
                            <div id="items-container">
                                <div class="flex items-center space-x-2 mb-2 item-row">
                                    <input type="text" name="nama_barang[]" placeholder="Nama Barang (contoh: Traktor)" class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <select name="jenis_barang[]" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Bibit">Bibit</option>
                                        <option value="Pupuk">Pupuk</option>
                                        <option value="Alsintan">Alat Mesin Pertanian (Alsintan)</option>
                                        <option value="Obat-obatan">Obat-obatan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <input type="number" name="jumlah_diminta[]" placeholder="Jumlah" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="1">
                                </div>
                            </div>
                            <button type="button" id="add-item" class="mt-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-1 px-3 rounded text-sm">
                                + Tambah Barang
                            </button>
                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <button type="submit" id="btnSubmit" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-2 px-6 rounded shadow-md transform transition hover:-translate-y-0.5 focus:outline-none focus:shadow-outline">
                                Ajukan & Verifikasi
                            </button>
                            <a href="{{ route('petani.pengajuan.index') }}" class="inline-block align-baseline font-bold text-sm text-emerald-600 hover:text-emerald-800">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmSubmit() {
            const nomorSurat = document.querySelector('input[name="nomor_surat"]').value || '-';
            const namaKebun = {!! json_encode($apiData['nama'] ?? Auth::user()->name) !!};

            const msg = 'Konfirmasi Pengajuan Baru:\n\n' +
                '• Nomor Surat: ' + nomorSurat + '\n' +
                '• Kebun / Pekebun: ' + namaKebun + '\n\n' +
                'Apakah Anda yakin ingin mengajukan bantuan? Data yang sudah dikirim tidak dapat diubah.';

            if (!confirm(msg)) {
                return false;
            }

            const btn = document.getElementById('btnSubmit');
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengirim Data...';
            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.getElementById('add-item');
            if (addBtn) {
                addBtn.addEventListener('click', function() {
                    const container = document.getElementById('items-container');
                    const row = document.createElement('div');
                    row.className = 'flex items-center space-x-2 mb-2 item-row';
                    row.innerHTML = '<input type="text" name="nama_barang[]" placeholder="Nama Barang" class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required><select name="jenis_barang[]" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required><option value="">-- Pilih Jenis --</option><option value="Bibit">Bibit</option><option value="Pupuk">Pupuk</option><option value="Alsintan">Alat Mesin Pertanian (Alsintan)</option><option value="Obat-obatan">Obat-obatan</option><option value="Lainnya">Lainnya</option></select><input type="number" name="jumlah_diminta[]" placeholder="Jumlah" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="1"><button type="button" class="bg-red-500 hover:bg-red-700 text-white py-2 px-3 rounded remove-item" style="padding: 0.5rem 0.75rem;">X</button>';
                    container.appendChild(row);

                    row.querySelector('.remove-item').addEventListener('click', function() {
                        row.remove();
                    });
                });
            }
        });
    </script>
</x-app-layout>
