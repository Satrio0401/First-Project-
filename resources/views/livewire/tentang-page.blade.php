<div class="">

    <div class="relative bg-linear-to-r from-emerald-700 via-green-800 to-teal-900 text-white py-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-4xl font-bold mb-2">Tentang Kami</h1>
            <p class="text-blue-100">
                Memahami Visi, Sejarah, dan Perjuangan Kami dalam Membina Insan Cita.
            </p>
        </div>
    </div>
    {{-- <div class="bg-gray-100 flex flex-col gap-12 py-6 px-2 md:px-6"> --}}
    <div class="flex flex-col gap-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- visi misi --}}
        <div class="reveal grid grid-cols-1 lg:grid-cols-2 bg-white rounded-xl shadow opacity-0 translate-y-10 transition-all duration-700">
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
                    @php
                        $normalizedVisi = trim(str_replace(["\r\n", "\r"], "\n", (string) $visi));

                        // Prioritaskan pemisahan berdasarkan baris agar format manual tetap dihormati.
                        $visiItems = preg_split('/\n+/', $normalizedVisi);
                        $visiItems = array_values(array_filter(array_map(fn($item) => trim($item), $visiItems)));

                        // Fallback untuk data yang menempel dalam satu baris: pecah berdasarkan nomor atau akhir kalimat.
                        if (count($visiItems) <= 1 && $normalizedVisi !== '') {
                            $visiItems = preg_split('/(?=\d+[\.)]\s)|(?<=[.!?])\s*(?=[A-Z])/', $normalizedVisi);
                            $visiItems = array_values(array_filter(array_map(fn($item) => preg_replace('/^\d+[\.)]\s*/', '', trim($item)), $visiItems)));
                        }
                    @endphp
                    <div class="text-gray-700 text-base leading-relaxed">
                        @foreach ($visiItems as $item)
                            @if ($item !== '')
                                <div class="flex items-start mb-3">
                                    <span class="mt-2 mx-3 h-2.5 w-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>{{ $item }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
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
                    @php
                        $normalizedMisi = trim(str_replace(["\r\n", "\r"], "\n", (string) $misi));

                        // Prioritaskan pemisahan berdasarkan baris agar format manual tetap dihormati.
                        $misiItems = preg_split('/\n+/', $normalizedMisi);
                        $misiItems = array_values(array_filter(array_map(fn($item) => trim($item), $misiItems)));

                        // Fallback untuk data yang menempel dalam satu baris: pecah berdasarkan nomor atau akhir kalimat.
                        if (count($misiItems) <= 1 && $normalizedMisi !== '') {
                            $misiItems = preg_split('/(?=\d+[\.)]\s)|(?<=[.!?])\s*(?=[A-Z])/', $normalizedMisi);
                            $misiItems = array_values(array_filter(array_map(fn($item) => preg_replace('/^\d+[\.)]\s*/', '', trim($item)), $misiItems)));
                        }
                    @endphp
                    <div class="text-gray-700 text-base leading-relaxed">
                        @foreach ($misiItems as $item)
                            @if ($item !== '')
                                <div class="flex items-start mb-3">
                                    <svg class="w-5 h-5 text-emerald-500 mx-3 shrink-0 mt-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ $item }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            @endif
        </div>


        <!-- Sejarah Section -->
        @if ($sejarah)
            <div class="reveal bg-white rounded-xl p-6 shadow opacity-0 translate-y-10 transition-all duration-700">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Sejarah Organisasi</h2>
                </div>
                <div class="text-gray-700 text-base leading-relaxed whitespace-pre-line text-justify">
                    {{ $sejarah }}
                </div>
            </div>
        @endif

        <!-- Sejarah Kepengurusan Section -->
        @if ($sejarahKepengurusan->count() > 0)
            <div class="reveal bg-white p-6 rounded-xl shadow opacity-0 translate-y-10 transition-all duration-700">
                <div class="flex items-center mb-6">
                    <div class="bg-green-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Sejarah Kepengurusan</h2>
                </div>
                @php
                    // Hindari data periodik yang sama tampil berulang karena duplikasi data.
                    $riwayatKepengurusan = $sejarahKepengurusan
                        ->unique(fn($item) => trim((string) $item->periode_mulai) . '|' . trim((string) $item->periode_berakhir) . '|' . trim((string) $item->ketua) . '|' . trim((string) ($item->wakil_ketua ?? '')))
                        ->values();
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach ($riwayatKepengurusan as $periode)
                        <article class="rounded-xl border border-emerald-100 bg-emerald-50/40 p-5 shadow-sm">
                            <div class="flex items-start gap-3">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100">
                                    <svg class="h-5 w-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800">
                                        {{ $periode->periode_mulai }} - {{ $periode->periode_berakhir }}
                                    </span>
                                    <div class="mt-3 space-y-1 text-base text-slate-700 leading-relaxed">
                                        <p><span class="font-semibold text-slate-800">Ketua Umum:</span> {{ $periode->ketua }}</p>
                                        @if (!empty($periode['wakil_ketua']))
                                            <p><span class="font-semibold text-slate-800">Wakil Ketua:</span> {{ $periode->wakil_ketua }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

            </div>
        @endif
    </div>
</div>
