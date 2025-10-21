<div>
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-2">Program Kerja</h1>
            <p class="text-blue-100">Rencana dan kegiatan organisasi</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Program Aktif -->
        @if($programAktif->count() > 0)
        <div class="mb-16">
            <div class="flex items-center mb-8">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Program Aktif</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($programAktif as $program)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition border-t-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                Aktif
                            </span>
                            @if($program->tanggal_mulai)
                            <span class="text-xs text-gray-500">
                                {{ $program->tanggal_mulai->format('M Y') }}
                            </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $program->nama }}</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">{{ $program->deskripsi }}</p>

                        @if($program->tanggal_mulai || $program->tanggal_selesai)
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-medium">Periode:</span>
                                <span class="ml-2">
                                    @if($program->tanggal_mulai)
                                        {{ $program->tanggal_mulai->format('d M Y') }}
                                    @endif
                                    @if($program->tanggal_selesai)
                                        - {{ $program->tanggal_selesai->format('d M Y') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Program Selesai -->
        @if($programSelesai->count() > 0)
        <div>
            <div class="flex items-center mb-8">
                <div class="bg-gray-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Program Selesai</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($programSelesai as $program)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition border-t-4 border-gray-400">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded-full">
                                Selesai
                            </span>
                            @if($program->tanggal_selesai)
                            <span class="text-xs text-gray-500">
                                {{ $program->tanggal_selesai->format('M Y') }}
                            </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $program->nama }}</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">{{ $program->deskripsi }}</p>

                        @if($program->tanggal_mulai || $program->tanggal_selesai)
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-medium">Periode:</span>
                                <span class="ml-2">
                                    @if($program->tanggal_mulai)
                                        {{ $program->tanggal_mulai->format('d M Y') }}
                                    @endif
                                    @if($program->tanggal_selesai)
                                        - {{ $program->tanggal_selesai->format('d M Y') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Empty State -->
        @if($programAktif->count() === 0 && $programSelesai->count() === 0)
        <div class="text-center py-12">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Program Kerja</h3>
            <p class="text-gray-500">Program kerja akan segera ditampilkan</p>
        </div>
        @endif
    </div>
</div>
