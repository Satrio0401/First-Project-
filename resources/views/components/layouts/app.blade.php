<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Organization Profile') }}</title>
        <link rel="icon" href="{{ asset('new-favicon-96x96.png') }}" type="image/x-icon">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles  
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Navigation -->
        <nav x-data="{ open: false }" class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" wire:navigate class="flex gap-1 items-center py-2">
                                <img src="{{ asset('logo-hmi.png') }}" class="w-4" alt="">
                                <div class="flex flex-col font-bold text-md text-black leading-none tracking-tight">
                                    <span>HMI CABANG</span>
                                    <span>PONTIANAK</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8 py-4">
                        <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Beranda
                        </a>
                        
                        <a href="{{ route('tentang') }}" wire:navigate class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('tentang') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Tentang
                        </a>
                        
                        <a href="{{ route('pengurus') }}" wire:navigate class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pengurus') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Struktur Pengurus
                        </a>
                        
                        <a href="{{ route('galeri.index') }}" wire:navigate class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('galeri.*') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Galeri
                        </a>

                        <a href="{{ route('berita.index') }}" wire:navigate class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('berita.*') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Berita
                        </a>
                        
                        <a href="{{ route('program-kerja') }}" wire:navigate class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('program-kerja') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Program Kerja
                        </a>
                    </div>
                    
                    
                    <div class="flex items-center sm:hidden">
                        <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-700">
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div x-show="open" @click.away="open = false" class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" wire:navigate class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Beranda
                    </a>
                    
                    <a href="{{ route('tentang') }}" wire:navigate class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('tentang') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Tentang
                    </a>
                    
                    <a href="{{ route('pengurus') }}" wire:navigate class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('pengurus') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Struktur Pengurus
                    </a>
                    
                    <a href="{{ route('galeri.index') }}" wire:navigate class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('galeri.*') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Galeri
                    </a>
                    <a href="{{ route('berita.index') }}" wire:navigate class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('berita.*') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Berita
                    </a>
                    
                    <a href="{{ route('program-kerja') }}" wire:navigate class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('program-kerja') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                        Program Kerja
                    </a>
                </div>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class=" text-white mt-20" style="background-color: #023d32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <a href="{{ route('home') }}" wire:navigate class="flex gap-3 items-center py-2">
                                <img src="{{ asset('logo-footer.png') }}" class="w-7" alt="">
                                <div class="flex flex-col font-bold text-xl leading-none tracking-tight">
                                    <span>HMI CABANG</span>
                                    <span>PONTIANAK</span>
                                </div>
                            </a>
                        <p class="text-gray-400 text-sm">
                            Website Resmi HMI Cabang Pontianak, Organisasi yang berkomitmen untuk memberikan kontribusi terbaik bagi masyarakat.
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-bold mb-4">Menu</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('home') }}" wire:navigate class="text-gray-400 hover:text-white">Beranda</a></li>
                            <li><a href="{{ route('tentang') }}" wire:navigate class="text-gray-400 hover:text-white">Tentang</a></li>
                            <li><a href="{{ route('pengurus') }}" wire:navigate class="text-gray-400 hover:text-white">Struktur Pengurus</a></li>
                            <li><a href="{{ route('galeri.index') }}" wire:navigate class="text-gray-400 hover:text-white">Galeri</a></li>
                            <li><a href="{{ route('berita.index') }}" wire:navigate class="text-gray-400 hover:text-white">Berita</a></li>
                            <li><a href="{{ route('program-kerja') }}" wire:navigate class="text-gray-400 hover:text-white">Program Kerja</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-bold mb-4">Kontak</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li>Email: info@organization.com</li>
                            <li>Telp: (021) 1234-5678</li>
                            <li>Alamat: Pontianak, Indonesia</li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} HMI Cabang Pontianak. All rights reserved.</p>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
