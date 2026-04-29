<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanItem extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'nama_barang',
        'jenis_barang',
        'jumlah_diminta',
        'jumlah_disetujui',
        'anggaran_disetujui',
        'satuan',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }
}
