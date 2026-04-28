<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->string('nomor_surat')->nullable()->after('nama_kelompok_tani');
            $table->string('perihal')->nullable()->after('nomor_surat');
            $table->string('no_kelompok_tani')->nullable()->after('perihal');
            $table->string('ketua_kelompok')->nullable()->after('no_kelompok_tani');
            $table->string('kabupaten_kota')->nullable()->after('ketua_kelompok');
            $table->string('komoditas_utama')->nullable()->after('kabupaten_kota');
            $table->decimal('luas_lahan_ha', 8, 2)->nullable()->after('komoditas_utama');
            $table->integer('jumlah_anggota')->nullable()->after('luas_lahan_ha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn([
                'nomor_surat',
                'perihal',
                'no_kelompok_tani',
                'ketua_kelompok',
                'kabupaten_kota',
                'komoditas_utama',
                'luas_lahan_ha',
                'jumlah_anggota'
            ]);
        });
    }
};
