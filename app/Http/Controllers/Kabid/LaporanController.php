<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::latest()->get();

        return view('kabid.laporan.index', compact('pengajuans'));
    }

    public function filter(Request $request)
    {
        $query = Pengajuan::query();

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pengajuan', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('nama_kelompok')) {
            $query->where('nama_kelompok_tani', 'like', '%'.$request->nama_kelompok.'%');
        }

        $pengajuans = $query->latest()->get();

        return view('kabid.laporan.index', compact('pengajuans'));
    }

    public function print(Request $request)
    {
        $query = Pengajuan::query();

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pengajuan', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('nama_kelompok')) {
            $query->where('nama_kelompok_tani', 'like', '%'.$request->nama_kelompok.'%');
        }

        $pengajuans = $query->latest()->get();

        $filters = [
            'tanggal_awal' => $request->tanggal_awal ?? '-',
            'tanggal_akhir' => $request->tanggal_akhir ?? '-',
            'status' => $request->status ?? 'all',
        ];

        return view('kabid.laporan.print', compact('pengajuans', 'filters'));
    }
}
