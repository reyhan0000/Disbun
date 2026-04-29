<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class PersetujuanController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $query = Pengajuan::where(function ($q) {
            $q->where('status', 'pending_kabid')
              ->orWhereIn('status', ['approved_full', 'approved_partial', 'rejected_kabid']);
        });

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

        return view('kabid.persetujuan.index', compact('pengajuans'));
    }

    public function show(Pengajuan $pengajuan)
    {
        return view('kabid.persetujuan.show', compact('pengajuan'));
    }

    public function approve(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.anggaran_disetujui' => 'required|numeric|min:0',
            'items.*.jumlah_disetujui' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $itemId => $data) {
            $item = $pengajuan->items()->findOrFail($itemId);

            $item->update([
                'anggaran_disetujui' => $data['anggaran_disetujui'],
                'jumlah_disetujui' => $data['jumlah_disetujui'],
            ]);
        }

        $pengajuan->update([
            'status' => 'approved_kabid',
            'verified_kabid_by' => auth()->id(),
            'verified_kabid_at' => now(),
            'verification_notes' => 'Disetujui oleh Kabid. Menunggu unggah BAST oleh Operator.',
        ]);

        $this->notificationService->notifyPersetujuan($pengajuan, 'Disetujui Kabid', 'Pengajuan Anda telah disetujui Kabid. Mohon tunggu Operator mengunggah dokumen BAST.');

        return redirect()->route('kabid.persetujuan.index')->with('success', 'Pengajuan berhasil disetujui. Tugas selanjutnya adalah Operator mengunggah BAST.');
    }

    public function reject(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:1000',
        ]);

        $pengajuan->update([
            'status' => 'rejected_kabid',
            'alasan_penolakan' => $request->alasan_penolakan,
            'verified_kabid_by' => auth()->id(),
            'verified_kabid_at' => now(),
            'verification_notes' => 'Ditolak: '.$request->alasan_penolakan,
        ]);

        $this->notificationService->notifyPersetujuan($pengajuan, 'Ditolak', $request->alasan_penolakan);

        return redirect()->route('kabid.persetujuan.index')->with('error', 'Pengajuan telah ditolak.');
    }
}
