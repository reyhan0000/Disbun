# SIBANSAR — Sistem Informasi Bantuan Sarana dan Prasarana

Sistem informasi berbasis web untuk mengelola pengajuan bantuan sarana dan prasarana perkebunan di Dinas Perkebunan (DISBUN) Provinsi Jawa Barat.

## Fitur Utama

- **Kelompok Tani** — Registrasi & verifikasi otomatis melalui API Data Disbun Jabar
- **Operator** — Verifikasi pengajuan, upload BAST & surat penolakan
- **Kepala Bidang (Kabid)** — Persetujuan/penolakan pengajuan dengan rincian per barang
- **Admin** — Kelola user (operator, kabid, kelompok tani) dengan filter & pencarian
- **Laporan** — Cetak laporan pengajuan per periode
- **Cetak Detail** — Cetak detail pengajuan lengkap dengan kop surat & area tanda tangan
- **Notifikasi** — Sistem notifikasi real-time antar peran

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB
- Web server (Apache/Nginx) atau Laragon

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/<username>/disbun.git
cd disbun
```

### 2. Install Dependensi

```bash
composer install
npm install
npm run build
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` sesuaikan:

```env
APP_NAME=SIBANSAR
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=disbun
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & Seeder Database

```bash
php artisan migrate --seed
```

### 5. Storage Link

```bash
php artisan storage:link
```

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Akses di: `http://localhost:8000`

## Akun Default (Seeder)

| Role | Email | Password |
|---|---|---|
| Admin | `admin@disbun.test` | `password` |
| Operator | `operator@disbun.test` | `password` |
| Kepala Bidang | `kabid@disbun.test` | `password` |

> Akun Kelompok Tani didaftarkan sendiri melalui halaman registrasi dengan verifikasi API Disbun Jabar.

## Integrasi API

Sistem menggunakan API resmi Dinas Perkebunan Provinsi Jawa Barat untuk verifikasi data Kelompok Tani:

```
https://dev.disbun.jabarprov.go.id/api/kelompok-tani
```

- Pencarian otomatis berdasarkan kode wilayah dari `kode_kelompok`
- Mendukung semua wilayah di Jawa Barat (bukan hanya satu kabupaten/kota)
- Penanganan error jika API tidak dapat dijangkau

## Struktur Peran (Role)

```
Admin
 └── Kelola User (Operator, Kabid, Kelompok Tani)

Kelompok Tani (Petani)
 └── Buat & Pantau Pengajuan

Operator
 └── Verifikasi Pengajuan → Teruskan ke Kabid
 └── Upload BAST & Surat Penolakan

Kepala Bidang (Kabid)
 └── Setujui / Tolak Pengajuan
 └── Tentukan jumlah barang yang disetujui per item
```

## Teknologi

- **Backend**: Laravel 11 (PHP)
- **Frontend**: Blade, Tailwind CSS, Alpine.js
- **Database**: MySQL
- **Storage**: Laravel Storage (local)

## Lisensi

Dikembangkan untuk keperluan internal Dinas Perkebunan Provinsi Jawa Barat.
