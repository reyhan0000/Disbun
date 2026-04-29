<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'user_id',
        'nama_kelompok_tani',
        'nomor_surat',
        'perihal',
        'no_kelompok_tani',
        'ketua_kelompok',
        'kabupaten_kota',
        'komoditas_utama',
        'luas_lahan_ha',
        'jumlah_anggota',
        'tanggal_pengajuan',
        'status',
        'file_surat_pengajuan',
        'alasan_penolakan',
        'verified_by',
        'verified_at',
        'verification_notes',
        'file_bast',
        'verified_kabid_by',
        'verified_kabid_at',
        'kategori',
    ];

    public function items()
    {
        return $this->hasMany(PengajuanItem::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function verifiedKabidBy()
    {
        return $this->belongsTo(User::class, 'verified_kabid_by');
    }
}
