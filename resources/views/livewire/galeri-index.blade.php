<div>
    <!-- Header -->
    <div class="bg-linear-to-r from-emerald-700 via-green-800 to-teal-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-2">Galeri</h1>
            <p class="text-blue-100">Rekam Jejak Perjuangan dalam Lensa.</p>
        </div>
    </div>

    <!-- Konten -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Search box -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Galeri</label>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Cari berdasarkan judul..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-700 focus:border-transparent">
                    </div>
                </div>
            </div>
        </div>

        <!-- Hasil Pencarian -->
        @if ($search)
            <div class="mb-4">
                <p class="text-gray-600">
                    Menampilkan {{ $galeris->total() }} hasil
                    @if ($search)
                        untuk "<strong>{{ $search }}</strong>"
                    @endif
                    <button wire:click="resetFilters"
                        class="text-blue-600 hover:text-blue-800 cursor-pointer ml-2 font-medium">
                        Reset
                    </button>
                </p>
            </div>
        @endif

        <!-- Grid Galeri -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($galeris as $album)
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)"
                    x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                    class="relative rounded-lg overflow-hidden shadow-lg cursor-pointer border-4 border-green-500 transition-all duration-700"
                    wire:click="openModal({{ $album->id }})">

                    <img src="{{ asset('storage/' . $album->firstImage->path) }}" alt="{{ $album->judul }}"
                        class="w-full h-64 object-cover">
                    <div class="absolute inset-0 bg-black/40"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white">
                        <h3 class="text-xl font-bold mb-1 drop-shadow-lg">{{ $album->judul }}</h3>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 text-center col-span-3">Tidak ada galeri ditemukan.</p>
            @endforelse
        </div>

        <!-- Modal -->
        @if ($isModalOpen && $activeAlbum)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/90"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                <!-- Tombol Tutup -->
                <button wire:click="closeModal"
                    class="absolute top-2 right-4 text-white text-4xl font-bold z-50 cursor-pointer">&times;</button>

                <!-- Tombol Navigasi Kiri -->
                <button wire:click="prevImage"
                    class="absolute left-0 md:left-4 top-1/2 -translate-y-1/2 z-50 p-4 text-white text-4xl md:text-5xl hover:bg-black/20 rounded-full transition-colors cursor-pointer">
                    &lt;
                </button>

                <!-- Tombol Navigasi Kanan -->
                <button wire:click="nextImage"
                    class="absolute right-0 md:right-4 top-1/2 -translate-y-1/2 z-50 p-4 text-white text-4xl md:text-5xl hover:bg-black/20 rounded-full transition-colors cursor-pointer">
                    &gt;
                </button>

                <!-- Kontainer Gambar -->
                <div class="flex items-center justify-center w-full h-full p-4 md:p-12">
                    @if ($activeAlbum->images->count() > 0)
                        <img src="{{ asset('storage/' . $activeAlbum->images[$currentImageIndex]->path) }}"
                            class="max-w-full max-h-full object-contain" alt="Gambar Galeri">
                    @endif
                </div>

                @if ($activeAlbum->images->count() > 0)
                    <div
                        class="absolute bottom-4 left-1/2 -translate-x-1/2 z-50 bg-black/50 text-white text-sm font-semibold px-3 py-1 rounded-full">
                        {{ $currentImageIndex + 1 }} / {{ $activeAlbum->images->count() }}
                    </div>
                @endif
            </div>
        @endif

        <!-- Pagination -->
        <div class="mt-12">
            {{ $galeris->links() }}
        </div>

    </div>
</div>
