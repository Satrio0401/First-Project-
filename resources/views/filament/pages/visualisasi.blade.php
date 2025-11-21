<x-filament-panels::page>
    <div class="flex">
        <x-filament::button wire:click="showKomisariatView" style="margin-right: 1rem">
            Tampilkan Komisariat
        </x-filament::button>
        <x-filament::button wire:click="showAnggotaView" color="gray">
            Tampilkan Anggota
        </x-filament::button>
    </div>
    @if ($showAnggotaFilters)
        <div id="anggota-filters" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="selectedJurusan">
                    <option value="">Semua Jurusan</option>
                    @foreach ($this->jurusanOptions as $id => $nama)
                        <option value="{{ $id }}">{{ $nama }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="selectedKomisariat">
                    <option value="">Semua Komisariat</option>
                    @foreach ($this->komisariatOptions as $id => $nama)
                        <option value="{{ $id }}">{{ $nama }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>
    @endif
    <div class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-400">
        Menampilkan: <span class="font-bold text-gray-700 dark:text-gray-200">{{ $markerCount }}</span> marker
    </div>
    <x-filament::card>
        <h2 class="text-lg font-semibold tracking-tight">Peta Sebaran Komisariat dan Anggota</h2>
    </x-filament::card>
    <div class="mt-4 rounded-md shadow-md">
        <div wire:ignore class="w-full rounded-md" id="map-container" style="height: 500px;" {{-- data-komisariat="{{ $this->getKomisariatsData() }}" data-anggota="{{ $this->getAnggotasData() }}" --}}>
        </div>
    </div>
    <div class="mt=6">
        @if ($selectedAnggota)
            {{ $this->infolist }}
        @endif
    </div>
</x-filament-panels::page>

{{-- Pastikan script Google Maps dimuat --}}
@once('google-maps-script')
    <script>
        function initAllMaps() {
            // Dispatch event saat Google Maps siap
            window.dispatchEvent(new CustomEvent('google-maps-loaded'));
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initAllMaps&v=weekly"
        async defer></script>
@endonce

<script>
    document.addEventListener('livewire:initialized', () => {
        let map;
        let activeMarkers = [];

        // 1. Fungsi untuk membersihkan marker
        function clearMarkers() {
            activeMarkers.forEach(marker => marker.setMap(null));
            activeMarkers = [];
        }

        // 2. Fungsi menggambar marker
        function drawMarkers(mapInstance, data, markerColor, isAnggota = false) {
            clearMarkers();
            
            if (!data || !Array.isArray(data) || data.length === 0) {
                console.warn('Data kosong atau tidak valid.');
                return;
            }

            const infowindow = new google.maps.InfoWindow();

            data.forEach(item => {
                // Pastikan koordinat valid angka
                const lat = parseFloat(item.latitude);
                const lng = parseFloat(item.longitude);

                if (isNaN(lat) || isNaN(lng)) return;

                // PERBAIKAN: Tambahkan '$' sebelum {markerColor}
                // Gunakan URL icon standar google atau custom icon Anda
                // Contoh default: merah. Untuk warna lain perlu icon khusus.
                let iconUrl = isAnggota 
                    ? "http://maps.google.com/mapfiles/ms/icons/red-dot.png" 
                    : "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";

                const marker = new google.maps.Marker({
                    position: { lat, lng },
                    map: mapInstance,
                    title: item.nama,
                    icon: iconUrl 
                });

                marker.addListener('click', () => {
                    if (isAnggota) {
                        // Panggil method di komponen Livewire
                        @this.call('showAnggotaDetails', { anggotaId: item.id });
                    }
                    
                    infowindow.setContent(`
                        <div style="color:black; padding:5px;">
                            <strong>${item.nama}</strong>
                        </div>
                    `);
                    infowindow.open(mapInstance, marker);
                });

                activeMarkers.push(marker);
            });
        }

        // 3. Fungsi Inisialisasi Utama (PENTING)
        function initializeMap() {
            const mapElement = document.getElementById('map-container');
            
            // Cek 1: Apakah elemen div ada?
            if (!mapElement) return;

            // Cek 2: Apakah Google Maps API sudah siap?
            if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                // Jika belum siap, tunggu event 'google-maps-loaded'
                window.addEventListener('google-maps-loaded', initializeMap, { once: true });
                return;
            }

            // Cek 3: Apakah map sudah pernah dibuat agar tidak double render?
            if (map) return; 

            // Buat Peta
            map = new google.maps.Map(mapElement, {
                zoom: 12,
                center: { lat: -0.026330, lng: 109.342503 }, // Sesuaikan center default
            });

            // 4. Daftarkan Event Listeners Livewire
            // Perhatikan: Kita menggunakan Livewire.on di dalam sini agar map scope-nya aman
            
            Livewire.on('drawKomisariatMarkers', ({ data }) => {
                drawMarkers(map, data, 'blue', false);
            });

            Livewire.on('drawAnggotaMarkers', ({ data }) => {
                drawMarkers(map, data, 'red', true);
            });

            Livewire.on('redrawAnggotaMarkers', ({ data }) => {
                drawMarkers(map, data, 'red', true);
            });

            // 5. Trigger data awal (Komisariat)
            // Menggunakan @this (blade directive) yang diterjemahkan menjadi object Livewire component
            @this.call('showKomisariatView');
        }

        // Jalankan inisialisasi
        initializeMap();
    });
</script>