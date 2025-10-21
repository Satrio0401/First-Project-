<div>

    <div class="bg-linear-to-r from-emerald-700 via-green-800 to-teal-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-2">Tentang Kami</h1>
            <p class="text-blue-100">Memahami Visi, Sejarah, dan Perjuangan Kami
                        dalam Membina Insan Cita.</p>
        </div>
    </div>
    <div class="max-w-7xl py-12 bg-white">
        {{-- visi misi --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 mb-12">
            @if ($visi)
                <div class="p-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 rounded-full p-3 mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">Visi</h2>
                    </div>
                    <p class="text-gray-700 text-base leading-relaxed">{{ $visi }}</p>
                </div>
            @endif
            @if ($misi)
                <div class="p-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 rounded-full p-3 mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">Misi</h2>
                    </div>
                    <div class="text-gray-700 text-base leading-relaxed">
                        @foreach (explode("\n", $misi) as $item)
                            @if (trim($item))
                                <div class="flex items-start mb-3">
                                    <svg class="w-5 h-5 text-emerald-500 mx-3 shrink-0 mt-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ trim($item) }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            @endif
        </div>


        <!-- Sejarah Section -->
        @if ($sejarah)
            <div class="mb-12">
                <div class="p-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 rounded-full p-3 mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">Sejarah Organisasi</h2>
                    </div>
                    <div class="text-gray-700 text-base leading-relaxed whitespace-pre-line">{{ $sejarah }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Sejarah Kepengurusan Section -->
        @if (count($sejarahKepengurusan) > 0)
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-green-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Sejarah Kepengurusan</h2>
                </div>

                <div class="relative border-l-3 border-green-700 ml-4">
                    @foreach ($sejarahKepengurusan as $periode)
                        <div class="mb-6">
                            <span
                                class="absolute -left-3 flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 ring-8 ring-white">
                                <svg class="h-4 w-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <div class="ml-6">
                                <div class="flex items-center mb-2">
                                    <span
                                        class="bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">
                                        {{ $periode['periode'] ?? '' }}
                                    </span>
                                </div>
                                <div class="mt-2 text-base text-slate-600">
                                    <p><span class="font-semibold text-slate-700">Ketua Umum:</span>
                                        {{ $periode['ketua'] ?? '' }}</p>
                                    @if (!empty($periode['wakil_ketua']))
                                        <p><span class="font-semibold text-slate-700">Wakil Ketua:</span>
                                            {{ $periode['wakil_ketua'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
    
</div>
