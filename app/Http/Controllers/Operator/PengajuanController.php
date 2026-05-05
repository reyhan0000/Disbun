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
        $tab = $request->get('tab', 'masuk');
        $query = Pengajuan::query();

        if ($tab === 'masuk') {
            $query->whereIn('status', ['pending_operator', 'approved_full_kabid', 'approved_partial_kabid', 'rejected_kabid']);
        } else {
            $query->whereNotIn('status', ['pending_operator', 'approved_full_kabid', 'approved_partial_kabid', 'rejected_kabid']);
        }

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

    public function print(Pengajuan $pengajuan)
    {
        return view('pengajuan.print-detail', compact('pengajuan'));
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

    public function uploadBast(Request $request, Pengajuan $pengajuan)
    {
        if (!in_array($pengajuan->status, ['approved_full_kabid', 'approved_partial_kabid'])) {
            return redirect()->back()->with('error', 'Status pengajuan harus disetujui Kabid terlebih dahulu.');
        }

        $request->validate([
            'file_bast' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $bastPath = $request->file('file_bast')->store('bast_files', 'public');

        $pengajuan->update([
            'status' => $pengajuan->status === 'approved_full_kabid' ? 'approved_full' : 'approved_partial',
            'file_bast' => $bastPath,
            'verification_notes' => 'Proses Selesai. Dokumen BAST telah diunggah oleh Operator.',
        ]);

        $this->notificationService->notifyPersetujuan($pengajuan, 'Selesai (BAST Diunggah)', 'Dokumen BAST telah diunggah oleh Operator. Proses pengajuan selesai.');

        return redirect()->route('operator.pengajuan.show', $pengajuan)->with('success', 'Dokumen BAST berhasil diunggah. Pengajuan selesai.');
    }

    public function uploadSuratPenolakan(Request $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== 'rejected_kabid') {
            return redirect()->back()->with('error', 'Status pengajuan tidak valid untuk unggah surat penolakan.');
        }

        $request->validate([
            'file_surat_penolakan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $penolakanPath = $request->file('file_surat_penolakan')->store('surat_penolakan', 'public');

        $pengajuan->update([
            'status' => 'rejected_full',
            'file_surat_penolakan' => $penolakanPath,
            'verification_notes' => 'Surat Penolakan telah diunggah oleh Operator.',
        ]);

        $this->notificationService->notifyPersetujuan($pengajuan, 'Surat Penolakan Diterbitkan', 'Dokumen Surat Penolakan resmi telah diterbitkan dan diunggah. Silakan periksa detail pengajuan Anda.');

        return redirect()->route('operator.pengajuan.show', $pengajuan)->with('success', 'Dokumen Surat Penolakan berhasil diunggah.');
    }
}
