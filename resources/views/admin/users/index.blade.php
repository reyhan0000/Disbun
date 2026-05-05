<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Kelola User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Header + Tombol Tambah --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Daftar User</h3>
                        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition-all">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Tambah User
                        </a>
                    </div>

                    {{-- Statistik Singkat --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-center">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Total</p>
                            <p class="text-2xl font-bold text-gray-700">{{ $totalAll }}</p>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-center">
                            <p class="text-xs text-blue-500 uppercase tracking-wide">Operator</p>
                            <p class="text-2xl font-bold text-blue-700">{{ $totalPeran['operator'] }}</p>
                        </div>
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-3 text-center">
                            <p class="text-xs text-purple-500 uppercase tracking-wide">Kepala Bidang</p>
                            <p class="text-2xl font-bold text-purple-700">{{ $totalPeran['kabid'] }}</p>
                        </div>
                        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 text-center">
                            <p class="text-xs text-emerald-500 uppercase tracking-wide">Kelompok Tani</p>
                            <p class="text-2xl font-bold text-emerald-700">{{ $totalPeran['kelompok_tani'] }}</p>
                        </div>
                    </div>

                    {{-- Form Filter (sama persis gaya pengajuan) --}}
                    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="search" value="Cari (Nama / Email / Kode Kelompok)" />
                                <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" value="{{ request('search') }}" placeholder="Ketik kata kunci..." />
                            </div>
                            <div>
                                <x-input-label for="role_filter" value="Role" />
                                <select id="role_filter" name="role" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                    <option value="">Semua Role</option>
                                    <option value="operator"      {{ request('role') === 'operator'      ? 'selected' : '' }}>Operator</option>
                                    <option value="kabid"         {{ request('role') === 'kabid'         ? 'selected' : '' }}>Kepala Bidang</option>
                                    <option value="kelompok_tani" {{ request('role') === 'kelompok_tani' ? 'selected' : '' }}>Kelompok Tani</option>
                                </select>
                            </div>
                            <div class="flex items-end space-x-2">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                                    Filter
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded shadow">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    {{-- Tabel --}}
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Kelompok</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $index => $user)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $users->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->kode_kelompok ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($user->role === 'operator')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Operator</span>
                                            @elseif($user->role === 'kabid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Kepala Bidang</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Kelompok Tani</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->created_at->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            @if($user->role !== 'admin')
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Yakin ingin hapus user {{ addslashes($user->name) }}?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Tidak ada user yang sesuai dengan filter.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>