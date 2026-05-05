<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kode_kelompok' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $kelompokTaniService = app(\App\Services\KelompokTaniService::class);
        
        // Verifikasi berdasarkan nama dan kode_kelompok (lebih akurat)
        $verifyResult = $kelompokTaniService->verify($request->name, $request->kode_kelompok);

        if ($verifyResult === null) {
            // API tidak dapat dijangkau
            throw ValidationException::withMessages([
                'name' => 'Sistem verifikasi dari Dinas Perkebunan sedang mengalami gangguan dan tidak dapat dijangkau. Pendaftaran tidak dapat dilakukan saat ini. Silakan coba beberapa saat lagi atau hubungi Administrator.',
            ]);
        }

        if ($verifyResult === false) {
            // API berhasil, data tidak ditemukan
            throw ValidationException::withMessages([
                'name' => 'Data yang Anda masukkan tidak ditemukan di database Dinas Perkebunan. Silakan periksa kembali Nama Kelompok Tani dan Kode Kelompok, atau hubungi Dinas terkait untuk melakukan pendaftaran kelompok tani Anda.',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'kode_kelompok' => $request->kode_kelompok,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect(route('login'))->with('status', 'Pendaftaran berhasil! Silakan masuk menggunakan akun baru Anda.');
    }
}
