<div>
    <div class="bg-gray-50 min-h-screen">
        <!-- Breadcrumb -->
        <div class="bg-white border-b border-green-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex text-sm text-gray-500">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-blue-600">Beranda</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('berita.index') }}" wire:navigate class="hover:text-blue-600">Berita</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ Str::limit($berita->judul, 50) }}</span>
                </nav>
            </div>
        </div>

        <!-- Article Content -->
        <article class="max-w-4xl mx-auto px-0 md:px-4 lg:px-8 py-12">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Article Header -->
                <div class="p-2 sm:p-8">
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <span
                            class="inline-block px-4 py-1.5 text-sm font-semibold rounded-full {{ $berita->kategori == 'Artikel' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $berita->kategori }}
                        </span>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $berita->published_at->format('d F Y, H:i') }} WIB
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $berita->views }} kali dilihat
                        </div>
                    </div>

                    <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ $berita->judul }}</h1>
                </div>

                <!-- Featured Image -->
                @if ($berita->gambar)
                    <div class="px-2 sm:px-8 mb-8">
                        <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full rounded-lg">
                    </div>
                @endif

                <!-- Article Body -->
                <div class="px-2 sm:px-8 pb-8">
                    <div class="prose prose-lg max-w-none text-justify">
                        {!! $berita->konten !!}
                    </div>
                </div>

                <!-- Share & Actions -->
                <div class="px-3 sm:px-8 pb-3 sm:pb-8 border-t border-green-700 pt-6">
                    <div class="flex flex-wrap gap-2 items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Bagikan artikel ini:</p>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ $this->facebookShare }}" target="_blank" rel="noopener noreferrer"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg text-sm font-semibold transition inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                    Facebook
                                </a>
                                <a href="{{ $this->twitterShare }}" target="_blank" rel="noopener noreferrer"
                                    class="bg-sky-500 hover:bg-sky-600 text-white px-2 py-1 rounded-lg text-sm font-semibold transition inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                    </svg>
                                    Twitter
                                </a>
                                <a href="{{ $this->whatsappShare }}" target="_blank" rel="noopener noreferrer"
                                    class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded-lg text-sm font-semibold transition inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                    </svg>
                                    WhatsApp
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('berita.index') }}" wire:navigate
                            class="text-green-600 hover:text-green-800 font-semibold flex items-center mt-2">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Berita
                        </a>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related News -->
        @if ($relatedBerita->count() > 0)
            <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Berita Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($relatedBerita as $item)
                        <a href="{{ route('berita.show', $item->slug) }}" wire:navigate
                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            @if ($item->gambar)
                                <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}"
                                    class="w-full h-40 object-cover">
                            @else
                                <div
                                    class="w-full h-40 bg-linear-to-br from-green-500 to-emerald-700 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-4">
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-full mb-2 {{ $item->kategori == 'Artikel' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $item->kategori }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $item->judul }}</h3>
                                <p class="text-sm text-gray-500">{{ $item->published_at->format('d M Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>
