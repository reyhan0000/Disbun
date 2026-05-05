<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['operator', 'kabid', 'kelompok_tani']);

        // Filter by role
        if ($request->filled('role') && in_array($request->role, ['operator', 'kabid', 'kelompok_tani'])) {
            $query->where('role', $request->role);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('kode_kelompok', 'like', "%{$search}%");
            });
        }

        $query->orderBy('role')->orderBy('name');

        $users       = $query->paginate(10)->withQueryString();
        $totalAll    = User::whereIn('role', ['operator', 'kabid', 'kelompok_tani'])->count();
        $totalPeran  = [
            'operator'      => User::where('role', 'operator')->count(),
            'kabid'         => User::where('role', 'kabid')->count(),
            'kelompok_tani' => User::where('role', 'kelompok_tani')->count(),
        ];

        return view('admin.users.index', compact('users', 'totalAll', 'totalPeran'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:operator,kabid',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $canEdit = in_array($user->role, ['operator', 'kabid']);
        $canChangePassword = in_array($user->role, ['operator', 'kabid']);

        if (! $canEdit && ! $canChangePassword) {
            abort(403, 'Tidak memiliki akses mengubah user ini.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ];

        if ($canEdit) {
            $rules['role'] = 'required|in:operator,kabid';
        }

        if ($canChangePassword && $request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($canEdit && $request->filled('role')) {
            $data['role'] = $request->role;
        }

        if ($canChangePassword && $request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $message = 'User berhasil diperbarui.';

        return redirect()->route('admin.users.index')
            ->with('success', $message);
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            abort(403, 'Tidak bisa menghapus user admin.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function resetPassword(Request $request, User $user)
    {
        if (! in_array($user->role, ['operator', 'kabid'])) {
            abort(403);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Password user berhasil direset.');
    }
}
