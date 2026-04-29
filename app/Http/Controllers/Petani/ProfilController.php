<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\KelompokTaniService;

class ProfilController extends Controller
{
    public function index(Request $request, KelompokTaniService $kelompokTaniService)
    {
        $user = $request->user();
        // Gunakan nama dan kode_kelompok user untuk pencarian API (lebih akurat)
        $apiData = $kelompokTaniService->getDetails($user->name, $user->kode_kelompok);
        
        return view('petani.profil.index', compact('apiData', 'user'));
    }
}
