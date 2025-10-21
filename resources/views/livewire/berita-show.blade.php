<div>
    <div class="bg-gray-50 min-h-screen">
        <!-- Breadcrumb -->
        <div class="bg-white border-b">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('berita.index') }}" class="hover:text-blue-600">Berita</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ Str::limit($berita->judul, 50) }}</span>
                </nav>
            </div>
        </div>

        <!-- Article Content -->
        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Article Header -->
                <div class="p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <span class="inline-block px-4 py-1.5 text-sm font-semibold rounded-full {{ $berita->kategori == 'Artikel' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $berita->kategori }}
                        </span>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $berita->published_at->format('d F Y, H:i') }} WIB
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $berita->views }} kali dilihat
                        </div>
                    </div>

                    <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ $berita->judul }}</h1>
                </div>

                <!-- Featured Image -->
                @if($berita->gambar)
                <div class="px-8 mb-8">
                    <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full rounded-lg">
                </div>
                @endif

                <!-- Article Body -->
                <div class="px-8 pb-8">
                    <div class="prose prose-lg max-w-none">
                        {!! $berita->konten !!}
                    </div>
                </div>

                <!-- Share & Actions -->
                <div class="px-8 pb-8 border-t pt-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Bagikan artikel ini:</p>
                            <div class="flex space-x-3">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                    Facebook
                                </button>
                                <button class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                    Twitter
                                </button>
                                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                    WhatsApp
                                </button>
                            </div>
                        </div>
                        <a href="{{ route('berita.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Berita
                        </a>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related News -->
        @if($relatedBerita->count() > 0)
        <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Berita Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedBerita as $item)
                <a href="{{ route('berita.show', $item->slug) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    @if($item->gambar)
                    <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-full h-40 object-cover">
                    @else
                    <div class="w-full h-40 bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    @endif
                    <div class="p-4">
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full mb-2 {{ $item->kategori == 'Artikel' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
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
