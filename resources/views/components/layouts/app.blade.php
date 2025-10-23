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
                        <a href="{{ route('home') }}" wire:navigate class="flex gap-2 items-center py-2">
                            <img src="{{ asset('logo-hmi.png') }}" class="w-4" alt="">
                            <div class="flex flex-col font-bold text-md text-black leading-none tracking-tight">
                                <span>HMI CABANG</span>
                                <span>PONTIANAK</span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:space-x-8 py-4">
                    <a href="{{ route('home') }}" wire:navigate
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                        Beranda
                    </a>

                    <a href="{{ route('tentang') }}" wire:navigate
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('tentang') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                        Tentang
                    </a>

                    <a href="{{ route('pengurus') }}" wire:navigate
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pengurus') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                        Struktur Pengurus
                    </a>

                    <a href="{{ route('galeri.index') }}" wire:navigate
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('galeri.*') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                        Galeri
                    </a>

                    <a href="{{ route('berita.index') }}" wire:navigate
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('berita.*') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                        Berita
                    </a>

                    <a href="{{ route('program-kerja') }}" wire:navigate
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('program-kerja') ? 'border-green-600 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                        Program Kerja
                    </a>
                </div>


                <div class="flex items-center sm:hidden">
                    <button @click="open = !open" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-700">
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" @click.away="open = false" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                    Beranda
                </a>

                <a href="{{ route('tentang') }}" wire:navigate
                    class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('tentang') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                    Tentang
                </a>

                <a href="{{ route('pengurus') }}" wire:navigate
                    class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('pengurus') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                    Struktur Pengurus
                </a>

                <a href="{{ route('galeri.index') }}" wire:navigate
                    class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('galeri.*') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                    Galeri
                </a>
                <a href="{{ route('berita.index') }}" wire:navigate
                    class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('berita.*') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                    Berita
                </a>

                <a href="{{ route('program-kerja') }}" wire:navigate
                    class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('program-kerja') ? 'bg-green-50 border-green-700 text-green-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">
                    Program Kerja
                </a>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class=" text-white" style="background-color: #023d32">
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
                        Website Resmi HMI Cabang Pontianak, Organisasi yang berkomitmen untuk memberikan kontribusi
                        terbaik bagi masyarakat.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Menu</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" wire:navigate
                                class="text-gray-400 hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('tentang') }}" wire:navigate
                                class="text-gray-400 hover:text-white">Tentang</a></li>
                        <li><a href="{{ route('pengurus') }}" wire:navigate
                                class="text-gray-400 hover:text-white">Struktur Pengurus</a></li>
                        <li><a href="{{ route('galeri.index') }}" wire:navigate
                                class="text-gray-400 hover:text-white">Galeri</a></li>
                        <li><a href="{{ route('berita.index') }}" wire:navigate
                                class="text-gray-400 hover:text-white">Berita</a></li>
                        <li><a href="{{ route('program-kerja') }}" wire:navigate
                                class="text-gray-400 hover:text-white">Program Kerja</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>Email: info@organization.com</li>
                        <li>Telp: +62 812-5711-6116</li>
                        <li>Alamat: Graha HMI Masjid An-Nur Jl KH. Wahid 𝙷𝚊𝚜𝚢𝚒𝚖 No. 229A</li>
                    </ul>
                    <div class="flex space-x-4 mt-6">
                        <a href="https://web.facebook.com/hmicabang.pontianak?_rdc=1&_rdr#"
                            class="text-gray-400 hover:text-white" target="_blank" rel="noopener noreferrer">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/hmipontianak" class="text-gray-400 hover:text-white"
                            target="_blank" rel="noopener noreferrer">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.012-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.08 2.525c.636-.247 1.363-.416 2.427-.465C9.53 2.013 9.884 2 12.315 2zM12 7a5 5 0 100 10 5 5 0 000-10zm0 8a3 3 0 110-6 3 3 0 010 6zm5.75-9.25a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://x.com/hmicabptk" class="text-gray-400 hover:text-white" target="_blank"
                            rel="noopener noreferrer">
                            <span class="sr-only">X</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                        {{-- <a href="#" class="text-gray-400 hover:text-white" target="_blank"
                            rel="noopener noreferrer">
                            <span class="sr-only">TikTok</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 48 48" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>Tiktok</title>
                                <g id="Icon/Social/tiktok-black" stroke="none" stroke-width="1" fill="none"
                                    fill-rule="evenodd">
                                    <path
                                        d="M38.0766847,15.8542954 C36.0693906,15.7935177 34.2504839,14.8341149 32.8791434,13.5466056 C32.1316475,12.8317108 31.540171,11.9694126 31.1415066,11.0151329 C30.7426093,10.0603874 30.5453728,9.03391952 30.5619062,8 L24.9731521,8 L24.9731521,28.8295196 C24.9731521,32.3434487 22.8773693,34.4182737 20.2765028,34.4182737 C19.6505623,34.4320127 19.0283477,34.3209362 18.4461858,34.0908659 C17.8640239,33.8612612 17.3337909,33.5175528 16.8862248,33.0797671 C16.4386588,32.6422142 16.0833071,32.1196657 15.8404292,31.5426268 C15.5977841,30.9658208 15.4727358,30.3459348 15.4727358,29.7202272 C15.4727358,29.0940539 15.5977841,28.4746337 15.8404292,27.8978277 C16.0833071,27.3207888 16.4386588,26.7980074 16.8862248,26.3604545 C17.3337909,25.9229017 17.8640239,25.5791933 18.4461858,25.3491229 C19.0283477,25.1192854 19.6505623,25.0084418 20.2765028,25.0219479 C20.7939283,25.0263724 21.3069293,25.1167239 21.794781,25.2902081 L21.794781,19.5985278 C21.2957518,19.4900128 20.7869423,19.436221 20.2765028,19.4380839 C18.2431278,19.4392483 16.2560928,20.0426009 14.5659604,21.1729264 C12.875828,22.303019 11.5587449,23.9090873 10.7814424,25.7878401 C10.003907,27.666593 9.80084889,29.7339663 10.1981162,31.7275214 C10.5953834,33.7217752 11.5748126,35.5530237 13.0129853,36.9904978 C14.4509252,38.4277391 16.2828722,39.4064696 18.277126,39.8028054 C20.2711469,40.1991413 22.3382874,39.9951517 24.2163416,39.2169177 C26.0948616,38.4384508 27.7002312,37.1209021 28.8296253,35.4300711 C29.9592522,33.7397058 30.5619062,31.7522051 30.5619062,29.7188301 L30.5619062,18.8324027 C32.7275484,20.3418321 35.3149087,21.0404263 38.0766847,21.0867664 L38.0766847,15.8542954 Z"
                                        id="Fill-1" fill="#000000"></path>
                                </g>
                            </svg>
                        </a> --}}
                        {{-- <a href="#" class="text-gray-400 hover:text-white" target="_blank"
                            rel="noopener noreferrer">
                            <span class="sr-only">YouTube</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.78 22 12 22 12s0 3.22-.42 4.814a2.506 2.506 0 0 1-1.768 1.768c-1.594.42-7.812.42-7.812.42s-6.218 0-7.812-.42a2.506 2.506 0 0 1-1.768-1.768C2 15.22 2 12 2 12s0-3.22.42-4.814a2.506 2.506 0 0 1 1.768-1.768C5.782 5 12 5 12 5s6.218 0 7.812.418ZM15.194 12 10 15V9l5.194 3Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a> --}}
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} HMI Cabang Pontianak. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
    <script>
        const initRevealAnimation = () => {
            const reveals = document.querySelectorAll(".reveal");
            if (reveals.length === 0) return;

            const options = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove("opacity-0", "translate-y-10");
                        observer.unobserve(entry.target);
                    }
                });
            }, options);

            reveals.forEach(section => {
                observer.observe(section);
            });
        };

        document.addEventListener('DOMContentLoaded', initRevealAnimation);
        document.addEventListener('livewire:navigated', initRevealAnimation);
    </script>
</body>

</html>
