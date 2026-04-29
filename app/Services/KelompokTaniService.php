<?php

namespace App\Services;

class KelompokTaniService
{
    /**
     * Verifikasi Kelompok Tani melalui API Pusat
     * Bisa mencari berdasarkan nama atau kode kelompok
     */
    public function verify($namaKelompokTani = null, $kodeKelompok = null)
    {
        try {
            // Gunakan strategi yang sama dengan getDetails (wilayah-based broad search)
            $queryParams = [
                'start' => 0,
                'limit' => 100,
                'wilayah' => '3278', 
            ];

            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                ])
                ->get('https://dev.disbun.jabarprov.go.id/api/kelompok-tani', $queryParams);

            if ($response->successful()) {
                $result = $response->json();
                
                $dataList = [];
                if (isset($result['data']['result']['data'])) {
                    $dataList = $result['data']['result']['data'];
                } elseif (isset($result['data']) && is_array($result['data'])) {
                    $dataList = $result['data'];
                } elseif (is_array($result)) {
                    $dataList = isset($result[0]) ? $result : [$result];
                }

                if (is_array($dataList) && count($dataList) > 0) {
                    $searchNama = strtoupper($namaKelompokTani ?? '');

                    foreach ($dataList as $item) {
                        $itemNama = strtoupper($item['nama_kelompok'] ?? $item['nama'] ?? '');
                        $itemKode = $item['kode_kelompok'] ?? $item['kode'] ?? '';

                        // Cocokkan berdasarkan kode ATAU nama
                        if (($kodeKelompok && $itemKode === $kodeKelompok) || 
                            ($searchNama && $itemNama === $searchNama)) {
                            return true;
                        }
                    }
                }
                return false;
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('API Kelompok Tani Verify Error: ' . $e->getMessage());
        }

        // Jangan izinkan daftar jika API gagal atau data tidak ditemukan
        return false;
    }

    /**
     * Get details of a Kelompok Tani dari API Pusat
     * Bisa mencari berdasarkan nama atau kode kelompok
     */
    public function getDetails($namaKelompokTani = null, $kodeKelompok = null)
    {
        try {
            // API Disbun error 500 jika mencari dengan nama langsung.
            // Solusi: Cari berdasarkan wilayah (yang terbukti berhasil di browser) lalu filter manual.
            $queryParams = [
                'start' => 0,
                'limit' => 100, // Ambil 100 data sekaligus agar lebih besar peluang ketemunya
                'wilayah' => '3278', 
            ];

            \Illuminate\Support\Facades\Log::info('API Request (Using Wilayah Fallback):', $queryParams);
            
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                ])
                ->get('https://dev.disbun.jabarprov.go.id/api/kelompok-tani', $queryParams);

            \Illuminate\Support\Facades\Log::info('API Response Status: ' . $response->status());
            
            if ($response->successful()) {
                $result = $response->json();
                
                // Coba ambil data dari berbagai kemungkinan struktur
                $dataList = [];
                if (isset($result['data']['result']['data'])) {
                    $dataList = $result['data']['result']['data'];
                } elseif (isset($result['data']) && is_array($result['data'])) {
                    $dataList = $result['data'];
                } elseif (is_array($result)) {
                    $dataList = isset($result[0]) ? $result : [$result];
                }

                if (is_array($dataList) && count($dataList) > 0) {
                    $targetItem = null;

                    // Filter manual mencari yang nama atau kodenya pas
                    foreach ($dataList as $item) {
                        $itemNama = strtoupper($item['nama_kelompok'] ?? $item['nama'] ?? '');
                        $itemKode = $item['kode_kelompok'] ?? $item['kode'] ?? '';
                        
                        $searchNama = strtoupper($namaKelompokTani ?? '');

                        if (($kodeKelompok && $itemKode === $kodeKelompok) || 
                            ($searchNama && $itemNama === $searchNama)) {
                            $targetItem = $item;
                            break;
                        }
                    }

                        // Jika tidak ketemu yang kodenya pas, atau tidak ada kode, ambil yang pertama
                        if (!$targetItem && count($dataList) > 0) {
                            $targetItem = $dataList[0];
                        }

                        if ($targetItem) {
                            $item = $targetItem;
                            \Illuminate\Support\Facades\Log::info('API Data Found:', $item);

                            return [
                                'nama' => $item['nama_kelompok'] ?? $item['nama'] ?? strtoupper($namaKelompokTani ?? ''),
                                'kode_kelompok' => $item['kode_kelompok'] ?? '-',
                                'nama_ketua' => $item['ketua'] ?? $item['nama_ketua'] ?? '-',
                                'alamat' => $item['alamat'] ?? '-',
                                'kabupaten' => $item['kabupaten'] ?? '-',
                                'kecamatan' => $item['kecamatan'] ?? '-',
                                'kelurahan' => $item['kelurahan'] ?? '-',
                                'no_sk_pengukuhan' => $item['kode_kelompok'] ?? '-',
                                'komoditas_utama' => $item['jenis_komoditi'] ?? $item['komoditas_utama'] ?? '-',
                                'luas_lahan_ha' => $item['luas_lahan'] ?? 0,
                                'jumlah_anggota' => $item['jumlah_anggota'] ?? 0,
                                'anggota_laki_laki' => $item['jumlah_anggota_laki_laki'] ?? 0,
                                'anggota_perempuan' => $item['jumlah_anggota_perempuan'] ?? 0,
                                'jenis_kelas' => $item['jenis_kelas'] ?? '-',
                                'tahun_berdiri' => $item['tahun_berdiri'] ?? '-',
                            ];
                        }
                    }
                } else {
                \Illuminate\Support\Facades\Log::error('API Request Failed:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('API Kelompok Tani GetDetails Error: ' . $e->getMessage());
        }

        // Data fallback jika tidak ditemukan atau API bermasalah
        return [
            'nama' => strtoupper($namaKelompokTani ?? ''),
            'kode_kelompok' => '-',
            'nama_ketua' => '-',
            'alamat' => 'Data tidak ditemukan di API Pusat',
            'kabupaten' => '-',
            'kecamatan' => '-',
            'kelurahan' => '-',
            'no_sk_pengukuhan' => '-',
            'komoditas_utama' => '-',
            'luas_lahan_ha' => 0,
            'jumlah_anggota' => 0,
            'anggota_laki_laki' => 0,
            'anggota_perempuan' => 0,
            'jenis_kelas' => '-',
            'tahun_berdiri' => '-',
        ];
    }
}
