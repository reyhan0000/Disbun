<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Services\KelompokTaniService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    protected $kelompokTaniService;

    protected $notificationService;

    public function __construct(KelompokTaniService $kelompokTaniService, NotificationService $notificationService)
    {
        $this->kelompokTaniService = $kelompokTaniService;
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $query = Pengajuan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('nama_kelompok_tani', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->latest()->paginate(10)->withQueryString();

        return view('operator.pengajuan.index', compact('pengajuans'));
    }

    public function show(Pengajuan $pengajuan)
    {
        $apiData = $this->kelompokTaniService->getDetails($pengajuan->nama_kelompok_tani);

        return view('operator.pengajuan.show', compact('pengajuan', 'apiData'));
    }

    public function verify(Request $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== 'pending_operator') {
            return redirect()->back()->with('error', 'Status pengajuan tidak valid untuk diverifikasi.');
        }

        $request->validate([
            'keputusan' => 'required|in:terima,tolak',
            'alasan_penolakan' => 'required_if:keputusan,tolak',
        ]);

        if ($request->keputusan === 'terima') {
            $pengajuan->update([
                'status' => 'pending_kabid',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'verification_notes' => 'Lolos verifikasi, diteruskan ke Kabid',
            ]);

            $this->notificationService->notifyVerifikasi($pengajuan, 'Diteruskan ke Kabid', 'Pengajuan telah lolos verifikasi dan menunggu persetujuan Kabid.');

            return redirect()->route('operator.pengajuan.index')->with('success', 'Pengajuan lolos verifikasi dan diteruskan ke Kabid.');
        } else {
            $pengajuan->update([
                'status' => 'rejected_operator',
                'alasan_penolakan' => 'Ditolak Operator: '.$request->alasan_penolakan,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'verification_notes' => 'Ditolak: '.$request->alasan_penolakan,
            ]);

            $this->notificationService->notifyVerifikasi($pengajuan, 'Ditolak', $request->alasan_penolakan);

            return redirect()->route('operator.pengajuan.index')->with('success', 'Pengajuan telah ditolak.');
        }
    }
}
