<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Detail Pengajuan - {{ $pengajuan->nomor_surat }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            @page { margin: 1.5cm; }
        }
        body { font-family: 'Times New Roman', serif; }
    </style>
</head>
<body class="bg-white p-8 text-gray-900">

    {{-- Tombol Aksi (tidak ikut cetak) --}}
    <div class="no-print flex gap-3 mb-6">
        <button onclick="window.print()" class="px-5 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 font-semibold flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="px-5 py-2 bg-gray-300 text-gray-800 rounded shadow hover:bg-gray-400 font-semibold">
            Tutup
        </button>
    </div>

    <div class="max-w-4xl mx-auto">

        {{-- KOP SURAT --}}
        <div class="text-center mb-6 border-b-2 border-gray-800 pb-4">
            <h1 class="text-lg font-bold uppercase tracking-wide">DINAS PERKEBUNAN</h1>
            <h2 class="text-base font-semibold uppercase">PROVINSI JAWA BARAT</h2>
            <p class="text-sm mt-1">Sistem Informasi Bantuan Sarana dan Prasarana (SIBANSAR)</p>
            <p class="text-xs text-gray-500 mt-1">Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>

        {{-- JUDUL --}}
        <div class="text-center mb-6">
            <h2 class="text-base font-bold uppercase underline">DETAIL PENGAJUAN BANTUAN</h2>
        </div>

        {{-- 1. DATA ADMINISTRATIF --}}
        <h3 class="font-bold text-sm uppercase border-b border-gray-400 pb-1 mb-3">1. Data Administratif</h3>
        <table class="w-full text-sm mb-5">
            <tbody>
                <tr>
                    <td class="py-1 w-40 text-gray-600">Nomor Surat</td>
                    <td class="py-1 w-4">:</td>
                    <td class="py-1 font-medium">{{ $pengajuan->nomor_surat ?? '-' }}</td>
                    <td class="py-1 w-40 text-gray-600">Perihal</td>
                    <td class="py-1 w-4">:</td>
                    <td class="py-1 font-medium">{{ $pengajuan->perihal ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-600">Tanggal Pengajuan</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-medium">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->translatedFormat('d F Y') }}</td>
                    <td class="py-1 text-gray-600">Kategori Bantuan</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-medium">{{ strtoupper($pengajuan->kategori ?? 'SARANA') }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-600">Status</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-medium" colspan="4">
                        @switch($pengajuan->status)
                            @case('pending_operator') Menunggu Verifikasi Operator @break
                            @case('pending_kabid') Menunggu Persetujuan Kabid @break
                            @case('approved_full_kabid') Disetujui Penuh oleh Kabid — Menunggu BAST @break
                            @case('approved_partial_kabid') Disetujui Sebagian oleh Kabid — Menunggu BAST @break
                            @case('approved_full') Selesai — Disetujui Penuh @break
                            @case('approved_partial') Selesai — Disetujui Sebagian @break
                            @case('rejected_operator') Ditolak oleh Operator @break
                            @case('rejected_kabid') Ditolak oleh Kabid @break
                            @case('rejected_full') Selesai — Ditolak @break
                            @default {{ str_replace('_', ' ', strtoupper($pengajuan->status)) }}
                        @endswitch
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- 2. PROFIL KELOMPOK TANI --}}
        <h3 class="font-bold text-sm uppercase border-b border-gray-400 pb-1 mb-3">2. Profil Kelompok Tani</h3>
        <table class="w-full text-sm mb-5">
            <tbody>
                <tr>
                    <td class="py-1 w-40 text-gray-600">Nama Kelompok Tani</td>
                    <td class="py-1 w-4">:</td>
                    <td class="py-1 font-bold text-base" colspan="4">{{ $pengajuan->nama_kelompok_tani }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-600">No. Registrasi (SK)</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-medium">{{ $pengajuan->no_kelompok_tani ?? '-' }}</td>
                    <td class="py-1 w-40 text-gray-600">Ketua Kelompok</td>
                    <td class="py-1 w-4">:</td>
                    <td class="py-1 font-medium">{{ $pengajuan->ketua_kelompok ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-600">Kabupaten/Kota</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-medium">{{ $pengajuan->kabupaten_kota ?? '-' }}</td>
                    <td class="py-1 text-gray-600">Komoditas Utama</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-medium">{{ $pengajuan->komoditas_utama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-600">Luas Lahan</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-medium">{{ $pengajuan->luas_lahan_ha ?? '-' }} Ha</td>
                    <td class="py-1 text-gray-600">Jumlah Anggota</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-medium">{{ $pengajuan->jumlah_anggota ?? '-' }} Orang</td>
                </tr>
            </tbody>
        </table>

        {{-- 3. RINCIAN BARANG --}}
        <h3 class="font-bold text-sm uppercase border-b border-gray-400 pb-1 mb-3">3. Rincian Bantuan yang Diajukan</h3>
        <table class="w-full text-sm border-collapse border border-gray-400 mb-5">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-400 px-3 py-2 text-left text-xs font-bold">No</th>
                    <th class="border border-gray-400 px-3 py-2 text-left text-xs font-bold">Nama Barang</th>
                    <th class="border border-gray-400 px-3 py-2 text-left text-xs font-bold">Jenis</th>
                    <th class="border border-gray-400 px-3 py-2 text-center text-xs font-bold">Jml Diminta</th>
                    <th class="border border-gray-400 px-3 py-2 text-center text-xs font-bold">Satuan</th>
                    <th class="border border-gray-400 px-3 py-2 text-center text-xs font-bold">Jml Disetujui</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuan->items as $item)
                    <tr>
                        <td class="border border-gray-400 px-3 py-2 text-xs">{{ $loop->iteration }}</td>
                        <td class="border border-gray-400 px-3 py-2 text-xs">{{ $item->nama_barang }}</td>
                        <td class="border border-gray-400 px-3 py-2 text-xs">{{ $item->jenis_barang ?? '-' }}</td>
                        <td class="border border-gray-400 px-3 py-2 text-xs text-center">{{ $item->jumlah_diminta }}</td>
                        <td class="border border-gray-400 px-3 py-2 text-xs text-center">{{ $item->satuan ?? '-' }}</td>
                        <td class="border border-gray-400 px-3 py-2 text-xs text-center font-bold">
                            {{ $item->jumlah_disetujui !== null ? $item->jumlah_disetujui : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- 4. RIWAYAT KEPUTUSAN --}}
        @if($pengajuan->verified_at || $pengajuan->verified_kabid_at)
        <h3 class="font-bold text-sm uppercase border-b border-gray-400 pb-1 mb-3">4. Riwayat Keputusan</h3>
        <table class="w-full text-sm mb-5">
            <tbody>
                @if($pengajuan->verified_at)
                <tr>
                    <td class="py-1 w-40 text-gray-600">Diverifikasi Operator</td>
                    <td class="py-1 w-4">:</td>
                    <td class="py-1">{{ $pengajuan->verifiedBy->name ?? 'Operator' }} — {{ \Carbon\Carbon::parse($pengajuan->verified_at)->translatedFormat('d F Y, H:i') }}</td>
                </tr>
                @endif
                @if($pengajuan->verified_kabid_at)
                <tr>
                    <td class="py-1 text-gray-600">Disetujui Kabid</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $pengajuan->verifiedKabidBy->name ?? 'Kabid' }} — {{ \Carbon\Carbon::parse($pengajuan->verified_kabid_at)->translatedFormat('d F Y, H:i') }}</td>
                </tr>
                @endif
                @if($pengajuan->verification_notes)
                <tr>
                    <td class="py-1 text-gray-600 align-top">Catatan</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $pengajuan->verification_notes }}</td>
                </tr>
                @endif
                @if($pengajuan->alasan_penolakan)
                <tr>
                    <td class="py-1 text-gray-600 align-top">Alasan Penolakan</td>
                    <td class="py-1">:</td>
                    <td class="py-1 text-red-700 font-medium">{{ $pengajuan->alasan_penolakan }}</td>
                </tr>
                @endif
            </tbody>
        </table>
        @endif

        {{-- TANDA TANGAN --}}
        <div class="mt-10">
            <div class="flex justify-end">
                <div class="text-center text-sm w-64">
                    <p>{{ now()->translatedFormat('d F Y') }}</p>
                    <p class="mt-1">Kepala Bidang Perkebunan</p>
                    <div class="mt-16 border-b border-gray-700"></div>
                    <p class="mt-1 font-medium">( ______________________ )</p>
                    <p class="text-xs text-gray-500">NIP. ________________________</p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-8 pt-4 border-t border-gray-300 text-center text-xs text-gray-400">
            <p>Dokumen ini dicetak secara otomatis dari Sistem Informasi Bantuan Sarana dan Prasarana (SIBANSAR) — Dinas Perkebunan Provinsi Jawa Barat</p>
        </div>

    </div>

    <script>
        // Auto print jika ada query ?autoprint=1
        const params = new URLSearchParams(window.location.search);
        if (params.get('autoprint') === '1') {
            window.onload = () => window.print();
        }
    </script>
</body>
</html>
