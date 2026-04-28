<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::latest()->get();

        $stats = [
            'total' => Pengajuan::count(),
            'pending' => Pengajuan::whereIn('status', ['pending_operator', 'pending_kabid'])->count(),
            'disetujui' => Pengajuan::whereIn('status', ['approved_full', 'approved_partial', 'approved_kabid'])->count(),
            'ditolak' => Pengajuan::whereIn('status', ['rejected_operator', 'rejected_kabid'])->count(),
        ];

        return view('operator.laporan.index', compact('pengajuans', 'stats'));
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

        $stats = [
            'total' => $query->count(),
            'pending' => (clone $query)->whereIn('status', ['pending_operator', 'pending_kabid'])->count(),
            'disetujui' => (clone $query)->whereIn('status', ['approved_full', 'approved_partial', 'approved_kabid'])->count(),
            'ditolak' => (clone $query)->whereIn('status', ['rejected_operator', 'rejected_kabid'])->count(),
        ];

        return view('operator.laporan.index', compact('pengajuans', 'stats'));
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

        return view('operator.laporan.print', compact('pengajuans', 'filters'));
    }
}
