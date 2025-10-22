<div>
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-green-700 via-emerald-600 to-teal-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold mb-2">Struktur Pengurus</h1>
            <p class="text-green-200">Tim yang berdedikasi untuk kemajuan organisasi</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Pengurus Inti Section -->
        @if($pengurusInti->count() > 0)
        <div class="mb-16">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Pengurus Inti</h2>
                <div class="w-24 h-1 bg-green-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($pengurusInti as $pengurus)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1">
                    <div class="relative">
                        @if($pengurus->foto)
                        <img src="{{ $pengurus->foto_url }}" alt="{{ $pengurus->nama }}" class="w-full h-64 object-cover">
                        @else
                        <div class="w-full h-64 bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center">
                            <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @endif
                        <div class="absolute top-4 right-4">
                            <span class="bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                                Pengurus Inti
                            </span>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $pengurus->nama }}</h3>
                        <p class="text-emerald-600 font-semibold">{{ $pengurus->jabatan }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Divisi Section -->
        @if($divisi->count() > 0)
        <div>
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Tim Divisi</h2>
                <div class="w-24 h-1 bg-emerald-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($divisi as $pengurus)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="relative">
                        @if($pengurus->foto)
                        <img src="{{ $pengurus->foto_url }}" alt="{{ $pengurus->nama }}" class="w-full h-48 object-cover">
                        @else
                        <div class="w-full h-48 bg-gradient-to-br from-teal-400 to-green-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $pengurus->nama }}</h3>
                        <p class="text-green-700 text-sm font-medium">{{ $pengurus->jabatan }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Empty State -->
        @if($pengurusInti->count() === 0 && $divisi->count() === 0)
        <div class="text-center py-12">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data Pengurus</h3>
            <p class="text-gray-500">Data pengurus akan segera ditampilkan</p>
        </div>
        @endif
    </div>
</div>
