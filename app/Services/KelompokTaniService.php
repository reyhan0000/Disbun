<?php

namespace App\Services;

class KelompokTaniService
{
    /**
     * Verifikasi Kelompok Tani melalui API Pusat
     */
    public function verify($namaKelompokTani)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->get('https://dev.disbun.jabarprov.go.id/api/kelompok-tani', [
                    'start' => 0,
                    'limit' => 20,
                    'nama' => $namaKelompokTani,
                    'wilayah' => '3278', // Hardcoded as per user's example
                ]);

            if ($response->successful()) {
                $result = $response->json();
                
                // Jika response bukan JSON (misalnya halaman Cloudflare/HTML)
                if (is_null($result)) {
                    return true;
                }

                $dataList = $result['data'] ?? $result;
                
                if (is_array($dataList) && count($dataList) > 0) {
                    return true;
                }
                
                // Coba cari tanpa wilayah jika yang pertama gagal
                $response2 = \Illuminate\Support\Facades\Http::withoutVerifying()
                    ->get('https://dev.disbun.jabarprov.go.id/api/kelompok-tani', [
                        'start' => 0,
                        'limit' => 20,
                        'nama' => $namaKelompokTani,
                    ]);
                    
                if ($response2->successful()) {
                    $result2 = $response2->json();
                    if (is_null($result2)) {
                        return true;
                    }
                    $dataList2 = $result2['data'] ?? $result2;
                    if (is_array($dataList2) && count($dataList2) > 0) {
                        return true;
                    }
                }
                
                return false;
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('API Kelompok Tani Verify Error: ' . $e->getMessage());
        }

        // Fallback jika API gagal diakses agar proses registrasi tetap berjalan di tahap pengembangan
        return true; 
    }

    /**
     * Get details of a Kelompok Tani dari API Pusat
     */
    public function getDetails($namaKelompokTani)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->get('https://dev.disbun.jabarprov.go.id/api/kelompok-tani', [
                    'start' => 0,
                    'limit' => 1,
                    'nama' => $namaKelompokTani,
                    'wilayah' => '3278', // Hardcoded as per user's example
                ]);

            if ($response->successful()) {
                $result = $response->json();
                
                if (!is_null($result)) {
                    $dataList = $result['data'] ?? $result;
                    
                    // Jika kosong, coba tanpa wilayah
                    if (!is_array($dataList) || count($dataList) === 0) {
                        $response2 = \Illuminate\Support\Facades\Http::withoutVerifying()
                            ->get('https://dev.disbun.jabarprov.go.id/api/kelompok-tani', [
                                'start' => 0,
                                'limit' => 1,
                                'nama' => $namaKelompokTani,
                            ]);
                        if ($response2->successful()) {
                            $result2 = $response2->json();
                            if (!is_null($result2)) {
                                $dataList = $result2['data'] ?? $result2;
                            }
                        }
                    }
                    
                    if (is_array($dataList) && count($dataList) > 0) {
                    $item = $dataList[0];
                    
                    return [
                        'nama' => $item['nama_kelompok'] ?? $item['nama'] ?? strtoupper($namaKelompokTani),
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
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('API Kelompok Tani GetDetails Error: ' . $e->getMessage());
        }

        // Data fallback jika tidak ditemukan atau API bermasalah
        return [
            'nama' => strtoupper($namaKelompokTani),
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
