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
        if (!$kelompokTaniService->verify($request->name, $request->kode_kelompok)) {
            throw ValidationException::withMessages([
                'name' => 'Data yang anda masukan salah silahkan periksa kembali data yang anda masukan atau data anda belum terdaftar di Dinas Perkebunan. Silakan hubungi dinas terkait untuk melakukan pendaftaran kelompok tani Anda.',
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
