<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\PengajuanItem;
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
        $query = Pengajuan::where('user_id', auth()->id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->latest()->paginate(10)->withQueryString();

        return view('petani.pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        $user = auth()->user();
        $apiData = $this->kelompokTaniService->getDetails(null, $user->kode_kelompok);

        return view('petani.pengajuan.create', compact('apiData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'perihal' => 'required|string|max:255',
            'file_surat_pengajuan' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'kategori' => 'required|in:sarana,prasarana',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string',
            'jenis_barang' => 'required|array',
            'jenis_barang.*' => 'required|string',
            'jumlah_diminta' => 'required|array',
            'jumlah_diminta.*' => 'required|integer|min:1',
            'satuan' => 'required|array',
            'satuan.*' => 'required|string|max:50',
        ]);

        $user = auth()->user();
        $apiData = $this->kelompokTaniService->getDetails(null, $user->kode_kelompok);

        if (! $apiData) {
            return back()->with('error', 'Gagal membuat pengajuan: Data Kelompok Tani tidak ditemukan di sistem pusat.');
        }

        $status = 'pending_operator';
        $alasan = null;

        $filePath = $request->file('file_surat_pengajuan')->store('surat_pengajuan', 'public');

        $pengajuan = Pengajuan::create([
            'user_id' => auth()->id(),
            'nama_kelompok_tani' => $apiData['nama'],
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'no_kelompok_tani' => $apiData['no_sk_pengukuhan'],
            'ketua_kelompok' => $apiData['nama_ketua'],
            'kabupaten_kota' => $apiData['alamat'],
            'komoditas_utama' => $apiData['komoditas_utama'],
            'luas_lahan_ha' => $apiData['luas_lahan_ha'],
            'jumlah_anggota' => $apiData['jumlah_anggota'],
            'tanggal_pengajuan' => now(),
            'file_surat_pengajuan' => $filePath,
            'status' => $status,
            'alasan_penolakan' => $alasan,
            'kategori' => $request->kategori,
        ]);

        foreach ($request->nama_barang as $index => $nama_barang) {
            PengajuanItem::create([
                'pengajuan_id' => $pengajuan->id,
                'nama_barang' => $nama_barang,
                'jenis_barang' => $request->jenis_barang[$index] ?? null,
                'jumlah_diminta' => $request->jumlah_diminta[$index],
                'satuan' => $request->satuan[$index] ?? null,
            ]);
        }

        $this->notificationService->send(
            auth()->id(),
            'Pengajuan Dikirim',
            "Pengajuan {$pengajuan->nomor_surat} - {$pengajuan->perihal} berhasil dikirim dan menunggu verifikasi Operator.",
            'pengajuan',
            $pengajuan->id,
            Pengajuan::class
        );

        $this->notificationService->notifyPengajuanBaru($pengajuan);

        return redirect()->route('petani.pengajuan.show', $pengajuan)->with('success', 'Pengajuan berhasil dikirim dan sedang menunggu verifikasi Operator.');
    }

    public function show(Pengajuan $pengajuan)
    {
        if ($pengajuan->user_id !== auth()->id()) {
            abort(403);
        }

        return view('petani.pengajuan.show', compact('pengajuan'));
    }
}
