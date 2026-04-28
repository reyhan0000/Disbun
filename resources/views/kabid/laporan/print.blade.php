<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengajuan - DISBUN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-white p-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-8 border-b-2 border-gray-300 pb-4">
            <h1 class="text-2xl font-bold text-gray-800">LAPORAN PENGAJUAN BANTUAN</h1>
            <h2 class="text-lg font-semibold text-gray-600">SISTEM INFORMASI BANTUAN SARANA PRASARANA (DISBUN)</h2>
            <p class="text-sm text-gray-500 mt-2">
                Periode: {{ $filters['tanggal_awal'] }} s/d {{ $filters['tanggal_akhir'] }} |
                Status: {{ $filters['status'] === 'all' ? 'Semua' : $filters['status'] }}
            </p>
        </div>

        <table class="min-w-full border-collapse border border-gray-300 mb-8">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-2 py-1 text-left text-xs font-bold">No</th>
                    <th class="border border-gray-300 px-2 py-1 text-left text-xs font-bold">Nomor Surat</th>
                    <th class="border border-gray-300 px-2 py-1 text-left text-xs font-bold">Kebun / Pekebun</th>
                    <th class="border border-gray-300 px-2 py-1 text-left text-xs font-bold">Perihal</th>
                    <th class="border border-gray-300 px-2 py-1 text-left text-xs font-bold">Tanggal</th>
                    <th class="border border-gray-300 px-2 py-1 text-left text-xs font-bold">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuans as $index => $pengajuan)
                    <tr>
                        <td class="border border-gray-300 px-2 py-1 text-xs">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-xs">{{ $pengajuan->nomor_surat }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-xs">{{ $pengajuan->nama_kelompok_tani }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-xs">{{ $pengajuan->perihal }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-xs">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->translatedFormat('d/m/Y') }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-xs">{{ $pengajuan->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border border-gray-300 px-2 py-2 text-center text-xs">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-center text-xs text-gray-500 mt-8 no-print">
            <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>
            <button onclick="window.print()" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cetak</button>
            <button onclick="window.close()" class="mt-2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 ml-2">Tutup</button>
        </div>
    </div>
</body>
</html>