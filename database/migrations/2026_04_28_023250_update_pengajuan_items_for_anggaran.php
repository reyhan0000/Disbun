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
        Schema::table('pengajuan_items', function (Blueprint $table) {
            $table->dropColumn(['sarpras_id', 'ketersediaan']);
            $table->bigInteger('anggaran_disetujui')->nullable()->after('jumlah_disetujui');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_items', function (Blueprint $table) {
            $table->string('sarpras_id')->nullable();
            $table->boolean('ketersediaan')->nullable();
            $table->dropColumn('anggaran_disetujui');
        });
    }
};
