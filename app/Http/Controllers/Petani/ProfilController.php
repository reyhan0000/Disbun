<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\KelompokTaniService;

class ProfilController extends Controller
{
    public function index(Request $request, KelompokTaniService $kelompokTaniService)
    {
        // Hanya memanggil API jika usernya kelompok tani (di-handle oleh middleware, tapi dipastikan lagi)
        $apiData = $kelompokTaniService->getDetails($request->user()->name);
        $user = $request->user();

        return view('petani.profil.index', compact('apiData', 'user'));
    }
}
