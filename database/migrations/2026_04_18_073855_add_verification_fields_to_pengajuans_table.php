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
            $table->unsignedBigInteger('verified_by')->nullable()->after('alasan_penolakan');
            $table->timestamp('verified_at')->nullable()->after('verified_by');
            $table->string('verification_notes')->nullable()->after('verified_at');
            $table->timestamp('verified_kabid_at')->nullable()->after('verification_notes');
            $table->unsignedBigInteger('verified_kabid_by')->nullable()->after('verified_kabid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn(['verified_by', 'verified_at', 'verification_notes', 'verified_kabid_at', 'verified_kabid_by']);
        });
    }
};
