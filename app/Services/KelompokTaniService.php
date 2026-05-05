<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KelompokTaniService
{
    private const API_URL  = 'https://dev.disbun.jabarprov.go.id/api/kelompok-tani';
    private const PAGE_SIZE = 100;
    private const MAX_PAGES = 15;

    /**
     * Ekstrak kode wilayah (4 digit pertama) dari kode_kelompok.
     * Contoh: '3278041007-004' -> '3278' (Kota Tasikmalaya)
     *         '3201041007-001' -> '3201' (Kabupaten Bogor)
     * Jika tidak ada kode kelompok, return null (cari tanpa filter wilayah).
     */
    private function extractWilayah(?string $kodeKelompok): ?string
    {
        if ($kodeKelompok && strlen($kodeKelompok) >= 4 && ctype_digit(substr($kodeKelompok, 0, 4))) {
            return substr($kodeKelompok, 0, 4);
        }
        return null;
    }

    /**
     * Bangun query params untuk API.
     * Jika wilayah tersedia, gunakan sebagai filter agar lebih cepat dan akurat.
     */
    private function buildQueryParams(int $start, ?string $wilayah): array
    {
        $params = [
            'start' => $start,
            'limit' => self::PAGE_SIZE,
        ];

        if ($wilayah) {
            $params['wilayah'] = $wilayah;
        }

        return $params;
    }

    /**
     * Parse response JSON ke array data list.
     */
    private function parseDataList(array $result): array
    {
        if (isset($result['data']['result']['data']) && is_array($result['data']['result']['data'])) {
            return $result['data']['result']['data'];
        }
        if (isset($result['data']) && is_array($result['data'])) {
            return $result['data'];
        }
        if (is_array($result) && isset($result[0])) {
            return $result;
        }
        return [];
    }

    /**
     * Lakukan HTTP GET ke API dengan paginasi.
     * Callback $matchFn dipanggil per-item; jika return non-null, loop berhenti.
     *
     * @param  string|null  $wilayah   Kode wilayah BPS (4 digit), atau null untuk semua wilayah
     * @param  callable     $matchFn   fn($item): mixed — return nilai jika cocok, null jika tidak
     * @return mixed  Nilai dari $matchFn jika ditemukan, false jika tidak ditemukan, null jika API error
     */
    private function paginate(?string $wilayah, callable $matchFn): mixed
    {
        $start = 0;

        try {
            for ($page = 0; $page < self::MAX_PAGES; $page++) {
                $params = $this->buildQueryParams($start, $wilayah);

                Log::info('KelompokTaniService API Request:', $params);

                $response = Http::withoutVerifying()
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    ])
                    ->timeout(15)
                    ->get(self::API_URL, $params);

                Log::info('KelompokTaniService API Response Status: ' . $response->status());

                if (! $response->successful()) {
                    Log::error('KelompokTaniService API HTTP Error:', [
                        'status' => $response->status(),
                        'body'   => substr($response->body(), 0, 300),
                    ]);
                    return null; // API error
                }

                $dataList = $this->parseDataList($response->json() ?? []);

                if (empty($dataList)) {
                    break; // Tidak ada data lagi
                }

                foreach ($dataList as $item) {
                    $result = $matchFn($item);
                    if ($result !== null) {
                        return $result; // Ditemukan
                    }
                }

                // Jika halaman kurang dari PAGE_SIZE, sudah habis
                if (count($dataList) < self::PAGE_SIZE) {
                    break;
                }

                $start += self::PAGE_SIZE;
            }

            return false; // API OK tapi tidak ditemukan

        } catch (\Exception $e) {
            Log::error('KelompokTaniService Exception: ' . $e->getMessage());
            return null; // Koneksi gagal
        }
    }

    /**
     * Verifikasi Kelompok Tani melalui API Pusat.
     *
     * @return true   — Data ditemukan dan cocok
     * @return false  — API berhasil, data tidak ditemukan
     * @return null   — API tidak dapat dijangkau
     */
    public function verify(?string $namaKelompokTani = null, ?string $kodeKelompok = null): ?bool
    {
        $searchKode = $kodeKelompok ?? '';
        $searchNama = strtoupper($namaKelompokTani ?? '');
        $wilayah    = $this->extractWilayah($kodeKelompok);

        $result = $this->paginate($wilayah, function (array $item) use ($searchKode, $searchNama) {
            $itemKode = $item['kode_kelompok'] ?? $item['kode'] ?? '';
            $itemNama = strtoupper($item['nama_kelompok'] ?? $item['nama'] ?? '');

            if (($searchKode && $itemKode === $searchKode) ||
                ($searchNama && $itemNama === $searchNama)) {
                return true; // ditemukan
            }
            return null; // lanjut
        });

        // $result: true=ditemukan, false=tidak ada, null=API error
        return $result; // true|false|null
    }

    /**
     * Ambil detail Kelompok Tani dari API Pusat.
     * Otomatis menentukan wilayah dari kode_kelompok.
     *
     * @return array|null  Data array jika ditemukan, null jika tidak atau API error
     */
    public function getDetails(?string $namaKelompokTani = null, ?string $kodeKelompok = null): ?array
    {
        $searchKode = $kodeKelompok ?? '';
        $searchNama = strtoupper($namaKelompokTani ?? '');
        $wilayah    = $this->extractWilayah($kodeKelompok);

        $result = $this->paginate($wilayah, function (array $item) use ($searchKode, $searchNama, $kodeKelompok) {
            $itemKode = $item['kode_kelompok'] ?? $item['kode'] ?? '';
            $itemNama = strtoupper($item['nama_kelompok'] ?? $item['nama'] ?? '');

            $kodeMatch = $searchKode && ($itemKode === $searchKode);
            $namaMatch = $searchNama && ($itemNama === $searchNama);

            if ($kodeMatch || $namaMatch) {
                Log::info('KelompokTaniService Data Found: kode=' . $itemKode . ' nama=' . $itemNama);
                return [
                    'nama'              => $item['nama_kelompok'] ?? $item['nama'] ?? $searchNama,
                    'kode_kelompok'     => $item['kode_kelompok'] ?? '-',
                    'nama_ketua'        => $item['ketua'] ?? $item['nama_ketua'] ?? '-',
                    'alamat'            => $item['alamat'] ?? '-',
                    'kabupaten'         => $item['kabupaten'] ?? '-',
                    'kecamatan'         => $item['kecamatan'] ?? '-',
                    'kelurahan'         => $item['kelurahan'] ?? '-',
                    'no_sk_pengukuhan'  => $item['kode_kelompok'] ?? '-',
                    'komoditas_utama'   => $item['jenis_komoditi'] ?? $item['komoditas_utama'] ?? '-',
                    'luas_lahan_ha'     => $item['luas_lahan'] ?? 0,
                    'jumlah_anggota'    => $item['jumlah_anggota'] ?? 0,
                    'anggota_laki_laki' => $item['jumlah_anggota_laki_laki'] ?? 0,
                    'anggota_perempuan' => $item['jumlah_anggota_perempuan'] ?? 0,
                    'jenis_kelas'       => $item['jenis_kelas'] ?? '-',
                    'tahun_berdiri'     => $item['tahun_berdiri'] ?? '-',
                ];
            }
            return null; // lanjut
        });

        // Jika false (tidak ditemukan) atau null (API error), kembalikan null
        if ($result === false || $result === null) {
            Log::warning('KelompokTaniService: Data tidak ditemukan.', [
                'kode'    => $searchKode,
                'nama'    => $searchNama,
                'wilayah' => $wilayah,
            ]);
            return null;
        }

        return $result; // array data
    }
}
