<div>
    
    <div class="bg-linear-to-r from-emerald-700 via-green-800 to-teal-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-2">Struktur Pengurus</h1>
            <p class="text-blue-100">Tim yang berdedikasi untuk kemajuan organisasi</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if($pengurusInti->count() > 0)
        <div class="mb-16">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Pengurus Inti</h2>
                <div class="w-24 h-1 bg-green-600 mx-auto rounded-full"></div>
            </div>
            

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($pengurusInti as $pengurus)
                    {{-- Perbaikan: Struktur div kartu diperbaiki --}}
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 relative">
                        @if ($pengurus->foto)
                            <img src="{{ $pengurus->foto_url }}" alt="{{ $pengurus->nama }}"
                                class="w-full h-64 object-cover">
                        @else
                            {{-- Perbaikan: Menggunakan bg-gradient-to-br --}}
                            <div class="w-full h-64 bg-linear-to-br from-blue-400 to-indigo-600 flex items-center justify-center">
                                <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4">
                            <span class="bg-green-700 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                Pengurus Inti
                            </span>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $pengurus->nama }}</h3>
                            <p class="text-teal-800 font-semibold">{{ $pengurus->jabatan }}</p>
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
                {{-- Perbaikan: Menambahkan penutup div yang hilang --}}
            </div>
        </div>
        @endif
    </div>
</div>


