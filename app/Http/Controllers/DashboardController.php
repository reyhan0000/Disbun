<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\PengajuanItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'kelompok_tani') {
            $stats = [
                'total' => Pengajuan::where('user_id', $user->id)->count(),
                'disetujui' => Pengajuan::where('user_id', $user->id)->whereIn('status', ['approved_full', 'approved_partial', 'approved_kabid'])->count(),
                'ditolak' => Pengajuan::where('user_id', $user->id)->whereIn('status', ['rejected_operator', 'rejected_kabid'])->count(),
                'menunggu' => Pengajuan::where('user_id', $user->id)->whereIn('status', ['pending_operator', 'pending_kabid'])->count(),
            ];
            $recent = Pengajuan::where('user_id', $user->id)->latest()->take(5)->get();

            return view('dashboard.petani', compact('stats', 'recent'));
        } elseif ($user->role === 'admin') {
            // Admin Dashboard - User Management Stats
            $stats = [
                'total_users' => User::count(),
                'operator' => User::where('role', 'operator')->count(),
                'kabid' => User::where('role', 'kabid')->count(),
                'petani' => User::where('role', 'kelompok_tani')->count(),
            ];

            $userStats = User::select('role', DB::raw('count(*) as total'))
                ->groupBy('role')
                ->get();

            return view('dashboard.admin', compact('stats', 'userStats'));
        } else {
            // Operator & Kabid Dashboard
            $stats = [
                'total' => Pengajuan::count(),
                'pending_operator' => Pengajuan::where('status', 'pending_operator')->count(),
                'pending_kabid' => Pengajuan::where('status', 'pending_kabid')->count(),
                'disetujui' => Pengajuan::whereIn('status', ['approved_full', 'approved_partial', 'approved_kabid'])->count(),
                'ditolak' => Pengajuan::whereIn('status', ['rejected_operator', 'rejected_kabid'])->count(),
            ];

            // Komoditas stats (Group by)
            $komoditasStats = Pengajuan::select('komoditas_utama', DB::raw('count(*) as total'))
                ->groupBy('komoditas_utama')
                ->orderByDesc('total')
                ->take(5)
                ->get();

            // Barang stats
            $barangStats = PengajuanItem::select('jenis_barang', DB::raw('count(*) as total'))
                ->whereNotNull('jenis_barang')
                ->groupBy('jenis_barang')
                ->orderByDesc('total')
                ->get();

            return view('dashboard.admin', compact('stats', 'komoditasStats', 'barangStats'));
        }
    }
}
