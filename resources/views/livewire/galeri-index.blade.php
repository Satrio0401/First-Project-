<div> 
    
    <!-- Header Galeri -->
    <div class="bg-linear-to-r from-emerald-700 via-green-800 to-teal-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-2">Galeri</h1>
            <p class="text-blue-100">Rekam Jejak Perjuangan dalam Lensa.</p>
        </div>
    </div>

    <!-- Konten Galeri -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-16">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Galeri</h2>
                <div class="w-24 h-1 bg-green-600 mx-auto rounded-full"></div>
            </div>
            
            <div x-data="gallery()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Gambar Galeri -->
                    <template x-for="(image, index) in images" :key="index">
                        <div class="reveal relative rounded-lg overflow-hidden shadow-lg cursor-pointer border-4 border-green-500 opacity-0 translate-y-10 transition-all duration-700"
                             @click="openModal(index)">
                            <img :src="image.src" :alt="image.title" class="w-full h-64 object-cover">
                            <div class="absolute inset-0 bg-black/40"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white">
                                <h3 class="text-xl font-bold mb-1 drop-shadow-lg" x-text="image.title"></h3>
                                <p class="font-semibold drop-shadow-md" x-text="image.desc"></p>
                            </div>
                        </div>
                    </template>
                </div>
            
                <!-- Modal full screen -->
                <div x-show="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90"
                     x-transition>
                    <!-- Tutup tombol -->
                    <button @click="closeModal()" class="absolute top-4 right-4 text-white text-3xl font-bold z-50">&times;</button>
                    
                    <!-- Gambar -->
                    <div class="flex items-center justify-center w-full h-full px-4">
                        <button @click="prev()" class="px-4 text-white text-3xl z-50">&lt;</button>
                        <img :src="images[currentIndex].src" class="max-w-full max-h-full object-contain transition-transform duration-300 mx-4">
                        <button @click="next()" class="px-4 text-white text-3xl z-50">&gt;</button>
                    </div>
                </div>
            </div>
            
            <script>
            function gallery() {
                return {
                    images: [
                        { src: '{{ asset("hmi.jpg") }}', title: 'Galeri 1', desc: 'Deskripsi singkat 1' },
                        { src: '{{ asset("logo-hmi.png") }}', title: 'Galeri 2', desc: 'Deskripsi singkat 2' },
                        { src: '{{ asset("hmi.jpg") }}', title: 'Galeri 3', desc: 'Deskripsi singkat 3' },
                    ],
                    isOpen: false,
                    currentIndex: 0,
                    openModal(index) {
                        this.currentIndex = index;
                        this.isOpen = true;
                    },
                    closeModal() {
                        this.isOpen = false;
                    },
                    next() {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                    },
                    prev() {
                        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                    }
                }
            }
            </script>
            
            
        </div>
    </div>

</div>
