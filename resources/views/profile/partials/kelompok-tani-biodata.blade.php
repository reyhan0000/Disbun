<section>
    <header class="mb-4 flex items-center">
        <svg class="w-8 h-8 text-emerald-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        <div>
            <h2 class="text-xl font-bold text-emerald-900">
                Biodata Kelompok Tani (Data Pusat)
            </h2>
            <p class="text-sm text-gray-500">
                Berikut adalah profil resmi Kelompok Tani Anda yang terdaftar di database Dinas Perkebunan Provinsi Jawa Barat.
            </p>
        </div>
    </header>

    <!-- Verified Badge -->
    <div class="mb-4 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg p-4 shadow-md">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-white/20 rounded-full p-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-white font-bold text-sm">TERVERIFIKASI - Data API Pusat</p>
                <p class="text-emerald-100 text-xs">Data ini bersumber dari database Dinas Perkebunan Provinsi Jawa Barat</p>
            </div>
            <div class="ml-auto">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                    Valid
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 bg-emerald-50 p-6 rounded-lg border border-emerald-200 shadow-inner">
        <div class="col-span-1 md:col-span-2 lg:col-span-3 pb-4 border-b border-emerald-200">
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Nama Kelompok Tani</p>
            <p class="font-black text-2xl text-emerald-900">{{ $apiData['nama'] }}</p>
        </div>
        
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Kode Kelompok</p>
            <p class="font-semibold text-gray-900">{{ $apiData['kode_kelompok'] }}</p>
        </div>
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Nama Ketua</p>
            <p class="font-semibold text-gray-900">{{ $apiData['nama_ketua'] }}</p>
        </div>
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Tahun Berdiri</p>
            <p class="font-semibold text-gray-900">{{ $apiData['tahun_berdiri'] }}</p>
        </div>
        
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Komoditas (Jenis Komoditi)</p>
            <p class="font-semibold text-gray-900">{{ $apiData['komoditas_utama'] }}</p>
        </div>
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Kelas Kelompok</p>
            <p class="font-semibold text-gray-900">{{ $apiData['jenis_kelas'] }}</p>
        </div>
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Luas Lahan</p>
            <p class="font-semibold text-gray-900">{{ $apiData['luas_lahan_ha'] }} Ha</p>
        </div>
        
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Jumlah Anggota</p>
            <p class="font-semibold text-gray-900">{{ $apiData['jumlah_anggota'] }} Orang</p>
        </div>
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Anggota Laki-Laki</p>
            <p class="font-semibold text-gray-900">{{ $apiData['anggota_laki_laki'] }} Orang</p>
        </div>
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Anggota Perempuan</p>
            <p class="font-semibold text-gray-900">{{ $apiData['anggota_perempuan'] }} Orang</p>
        </div>
        
        <div class="col-span-1 md:col-span-2 lg:col-span-3 pt-4 border-t border-emerald-200">
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Alamat Lengkap Sekretariat</p>
            <p class="font-medium text-gray-900">{{ $apiData['alamat'] }}</p>
        </div>
        
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Desa/Kelurahan</p>
            <p class="font-semibold text-gray-900">{{ $apiData['kelurahan'] }}</p>
        </div>
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Kecamatan</p>
            <p class="font-semibold text-gray-900">{{ $apiData['kecamatan'] }}</p>
        </div>
        <div>
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Kabupaten/Kota</p>
            <p class="font-semibold text-gray-900">{{ $apiData['kabupaten'] }}</p>
        </div>
    </div>
    
    <div class="mt-4 flex items-center text-sm text-gray-500 bg-gray-50 p-3 rounded-md border border-gray-100">
        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>Data di atas terintegrasi langsung dengan API Pusat dan bersifat <em>read-only</em>. Jika terdapat ketidaksesuaian data, silakan hubungi Kantor Dinas Perkebunan Provinsi Jawa Barat.</span>
    </div>
</section>