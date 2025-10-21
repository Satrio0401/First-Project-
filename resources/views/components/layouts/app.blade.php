<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Organization Profile') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">
                                {{ config('app.name', 'Organization') }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Beranda
                        </a>
                        
                        <a href="{{ route('tentang') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('tentang') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Tentang
                        </a>
                        
                        <a href="{{ route('pengurus') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pengurus') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Struktur Pengurus
                        </a>
                        
                        <a href="{{ route('berita.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('berita.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Berita
                        </a>
                        
                        <a href="{{ route('program-kerja') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('program-kerja') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Program Kerja
                        </a>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden">
                        <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div x-show="open" @click.away="open = false" class="sm:hidden" x-data="{ open: false }">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Beranda
                    </a>
                    
                    <a href="{{ route('tentang') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('tentang') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Tentang
                    </a>
                    
                    <a href="{{ route('pengurus') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('pengurus') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Struktur Pengurus
                    </a>
                    
                    <a href="{{ route('berita.index') }}" class="block pl-3 pr-4 py-2 border-Pl-4 {{ request()->routeIs('berita.*') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Berita
                    </a>
                    
                    <a href="{{ route('program-kerja') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('program-kerja') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Program Kerja
                    </a>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-bold mb-4">{{ config('app.name') }}</h3>
                        <p class="text-gray-400 text-sm">
                            Organisasi yang berkomitmen untuk memberikan kontribusi terbaik bagi masyarakat.
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-bold mb-4">Menu</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Beranda</a></li>
                            <li><a href="{{ route('tentang') }}" class="text-gray-400 hover:text-white">Tentang</a></li>
                            <li><a href="{{ route('pengurus') }}" class="text-gray-400 hover:text-white">Struktur Pengurus</a></li>
                            <li><a href="{{ route('berita.index') }}" class="text-gray-400 hover:text-white">Berita</a></li>
                            <li><a href="{{ route('program-kerja') }}" class="text-gray-400 hover:text-white">Program Kerja</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-bold mb-4">Kontak</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li>Email: info@organization.com</li>
                            <li>Telp: (021) 1234-5678</li>
                            <li>Alamat: Jakarta, Indonesia</li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
