<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Notifikasi') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @forelse($notifications as $notif)
                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors {{ $notif->is_read ? 'bg-white' : 'bg-blue-50' }}">
                        <div class="flex items-start gap-3">
                            @if(!$notif->is_read)
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-2 flex-shrink-0"></div>
                            @endif
                            <div class="flex-1">
                                <a href="{{ route('operator.notifikasi.show', $notif) }}" class="block">
                                    <p class="font-semibold text-gray-900 {{ $notif->is_read ? '' : 'font-bold' }}">{{ $notif->title }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $notif->message }}</p>
                                    <p class="text-xs text-gray-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                                </a>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($notif->type === 'pengajuan') bg-blue-100 text-blue-800
                                    @elseif($notif->type === 'verifikasi') bg-yellow-100 text-yellow-800
                                    @elseif($notif->type === 'persetujuan') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($notif->type) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 5.849 6 7.664 6 9v5.158a2.032 2.032 0 01-.405 1.405L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                        <p class="mt-1 text-sm text-gray-500">Anda akan menerima notifikasi tentang pengajuan yang perlu diverifikasi di sini.</p>
                    </div>
                @endforelse

                @if($unreadCount > 0)
                <div class="p-4 border-t border-gray-100 bg-gray-50">
                    <form action="{{ route('operator.notifikasi.markAllRead') }}" method="POST" class="text-center">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Tandai semua sudah dibaca ({{ $unreadCount }})
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
