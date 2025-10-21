<div>
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-2">Tentang Kami</h1>
            <p class="text-blue-100">Mengenal lebih dekat {{ config('app.name') }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Visi Section -->
        @if($visi)
        <div class="mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Visi</h2>
                </div>
                <p class="text-gray-700 text-lg leading-relaxed">{{ $visi }}</p>
            </div>
        </div>
        @endif

        <!-- Misi Section -->
        @if($misi)
        <div class="mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Misi</h2>
                </div>
                <div class="text-gray-700 text-lg leading-relaxed">
                    @foreach(explode("\n", $misi) as $item)
                        @if(trim($item))
                        <div class="flex items-start mb-3">
                            <span class="text-indigo-600 mr-2">•</span>
                            <span>{{ trim($item) }}</span>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Sejarah Section -->
        @if($sejarah)
        <div class="mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Sejarah Organisasi</h2>
                </div>
                <div class="text-gray-700 text-lg leading-relaxed whitespace-pre-line">{{ $sejarah }}</div>
            </div>
        </div>
        @endif

        <!-- Sejarah Kepengurusan Section -->
        @if(count($sejarahKepengurusan) > 0)
        <div class="mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-purple-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Sejarah Kepengurusan</h2>
                </div>
                
                <div class="space-y-6">
                    @foreach($sejarahKepengurusan as $periode)
                    <div class="border-l-4 border-purple-500 pl-6 py-2">
                        <div class="flex items-center mb-2">
                            <span class="bg-purple-100 text-purple-800 text-sm font-semibold px-3 py-1 rounded-full">
                                {{ $periode['periode'] ?? '' }}
                            </span>
                        </div>
                        <div class="text-gray-700">
                            <p class="mb-1">
                                <span class="font-semibold">Ketua:</span> {{ $periode['ketua'] ?? '' }}
                            </p>
                            @if(!empty($periode['wakil_ketua']))
                            <p>
                                <span class="font-semibold">Wakil Ketua:</span> {{ $periode['wakil_ketua'] }}
                            </p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
