<div>
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-2">Berita</h1>
            <p class="text-blue-100">Informasi terkini dan pengumuman penting</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Search & Filter -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Berita</label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search" 
                            placeholder="Cari berdasarkan judul atau konten..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Kategori Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select 
                            wire:model.live="kategoriFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Semua Kategori</option>
                            <option value="Artikel">Artikel</option>
                            <option value="Pengumuman">Pengumuman</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Info -->
        @if($search || $kategoriFilter)
        <div class="mb-4">
            <p class="text-gray-600">
                Menampilkan {{ $berita->total() }} hasil
                @if($search)
                    untuk "<strong>{{ $search }}</strong>"
                @endif
                @if($kategoriFilter)
                    di kategori <strong>{{ $kategoriFilter }}</strong>
                @endif
                <button wire:click="$set('search', ''); $set('kategoriFilter', '')" class="text-blue-600 hover:text-blue-700 ml-2">
                    Reset
                </button>
            </p>
        </div>
        @endif

        <!-- Berita Grid -->
        @if($berita->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($berita as $item)
            <a href="{{ route('berita.show', $item->slug) }}" wire:navigate class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                @if($item->gambar)
                <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $item->kategori == 'Artikel' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $item->kategori }}
                        </span>
                        <span class="text-xs text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $item->views }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $item->judul }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $item->excerpt }}</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $item->published_at->format('d M Y') }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div>
            {{ $berita->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Berita</h3>
            <p class="text-gray-500">
                @if($search || $kategoriFilter)
                    Tidak ditemukan berita yang sesuai dengan pencarian Anda
                @else
                    Belum ada berita yang dipublikasikan
                @endif
            </p>
        </div>
        @endif
    </div>
</div>
