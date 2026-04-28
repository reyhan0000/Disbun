<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-emerald-50 overflow-hidden">
            
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col w-full relative">
                
                <!-- Mobile Navigation / Topbar -->
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-emerald-800 shadow-md border-b border-emerald-900 z-10 shrink-0">
                        <div class="py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between w-full">
<div class="flex-1 min-w-0 mr-4 text-white">
                                 <!-- Force text to be white inside the header -->
                                 <div class="[&>h2]:!text-white">
                                     {{ $header }}
                                 </div>
                             </div>
                            
                            <!-- User Dropdown (same as navigation.blade.php) -->
                            <div class="hidden sm:flex sm:items-center sm:ms-6 shrink-0">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-emerald-100 bg-emerald-800 hover:text-white hover:bg-emerald-900 focus:outline-none transition ease-in-out duration-150 shadow-sm border-emerald-600">
                                            <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center text-emerald-800 font-bold shadow-inner mr-2">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                            <div class="text-right mr-2">
                                                <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                                                <div class="text-xs text-emerald-200 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</div>
                                            </div>
                                            <div>
                                                <svg class="fill-current h-4 w-4 text-emerald-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-gray-100">
                    <div class="p-4 sm:p-6 lg:p-8">
                        {{ $slot }}
                    </div>
                </main>

                <!-- Footer (Fixed at bottom of content area) -->
                <footer class="py-4 border-t border-emerald-900 bg-emerald-800 shadow-inner flex-shrink-0">
                    <div class="px-4 sm:px-6 lg:px-8 text-center sm:flex sm:justify-between sm:text-left text-sm text-emerald-100">
                        <div class="mb-2 sm:mb-0">
                            &copy; {{ date('Y') }} <span class="font-bold text-white">SIBANSAR</span>. Hak Cipta Dilindungi.
                        </div>
                        <div>
                            Dinas Perkebunan Provinsi Jawa Barat
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
