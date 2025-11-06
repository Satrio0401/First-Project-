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

@once('google-maps-script')
    <script>
        // Definisikan fungsi ini di scope global agar bisa diakses oleh callback Google
        function initAllMaps() {
            console.log('Google Maps API is ready. Firing event.');
            window.dispatchEvent(new CustomEvent('google-maps-loaded'));
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initAllMaps&v=weekly"
        async defer></script>
@endonce

<script>
    let map;
    let activeMarkers = [];

    function clearMarkers() {
        activeMarkers.forEach(marker => marker.setMap(null));
        activeMarkers = [];
    }

    function drawMarkers(mapInstance, data, markerColor, isAnggota = false) {
        clearMarkers();
        if (!data || !Array.isArray(data) || data.length === 0) {
            console.warn('Data tidak valid atau kosong. Peta tidak akan digambar.', data);
            return;
        }

        const infowindow = new google.maps.InfoWindow();

        data.forEach(item => {
            const position = {
                lat: parseFloat(item.latitude),
                lng: parseFloat(item.longitude)
            };

            const marker = new google.maps.Marker({
                position: position,
                map: mapInstance,
                title: item.nama,
                icon: {
                    url: `http://maps.google.com/mapfiles/ms/icons/${markerColor}-dot.png`
                }
            });

            marker.addListener('click', () => {
                if (isAnggota) {
                    // Kirim ID anggota ke backend
                    window.Livewire.dispatch('showAnggotaDetails', {
                        anggotaId: item.id
                    });
                }
                infowindow.setContent(`<strong style="color: black;">${item.nama}</strong>`);
                infowindow.open(map, marker);
            });
            activeMarkers.push(marker); // Simpan marker untuk dihapus nanti
        });
    }

    // function initializeMap() {
    //     console.log('Attempting to initialize empty map...');
    //     const mapElement = document.getElementById('map-container');
    //     const anggotaFilters = document.getElementById('anggota-filters');
    //     if (!mapElement) {
    //         console.error('Map element #map-container not found!');
    //         return;
    //     }
    //     if (mapElement.classList.contains('map-initialized')) {
    //         console.warn('Map already initialized.');
    //         return;
    //     }
    //     mapElement.classList.add('map-initialized');
    //     map = new google.maps.Map(mapElement, {
    //         zoom: 12,
    //         center: {
    //             lat: -0.05,
    //             lng: 109.347
    //         },
    //     });
    //     const komisariatData = JSON.parse(mapElement.getAttribute('data-komisariat') || '[]');
    //     const anggotaData = JSON.parse(mapElement.getAttribute('data-anggota') || '[]');
    //     document.getElementById('show-komisariat-btn').addEventListener('click', () => {
    //         window.Livewire.dispatch('hideInfolist');
    //         drawMarkers(komisariatData, 'blue', false); // Gambar marker komisariat (biru)
    //         anggotaFilters.style.display = 'none'; // Sembunyikan filter
    //     });

    //     document.getElementById('show-anggota-btn').addEventListener('click', () => {
    //         drawMarkers(anggotaData, 'red', true); // Gambar marker anggota (merah)
    //         anggotaFilters.style.display = 'grid'; // Tampilkan filter
    //     });

    //     // Tampilkan data komisariat secara default saat pertama kali load
    //     drawMarkers(komisariatData, 'blue', false);
    // }

    // Dengarkan event universal
    // window.addEventListener('google-maps-loaded', initializeMap);

    // // Pemicu untuk navigasi SPA
    // document.addEventListener('livewire:navigated', () => {
    //     if (window.google && window.google.maps) {
    //         initializeMap();
    //     }
    // });

    // // Pemicu untuk hard refresh (jika API sudah di-cache)
    // if (window.google && window.google.maps) {
    //     initializeMap();
    // }
    document.addEventListener('livewire:initialized', () => {
        const mapElement = document.getElementById('map-container');
        if (!mapElement) return;

        map = new google.maps.Map(mapElement, {
            zoom: 12,
            center: {
                lat: -0.05,
                lng: 109.347
            },
        });

        window.Livewire.on('drawKomisariatMarkers', ({
            data
        }) => {
            drawMarkers(map, data, 'blue', false);
        });

        // Terima 'data' dari event
        window.Livewire.on('drawAnggotaMarkers', ({
            data
        }) => {
            drawMarkers(map, data, 'red', true);
        });

        window.Livewire.on('redrawAnggotaMarkers', ({
            data
        }) => {
            drawMarkers(map, data, 'red', true);
        });

        window.Livewire.on('showAnggotaDetails', ({
            anggotaId
        }) => {
            // Anda bisa menambahkan logika di sini jika perlu,
            // misalnya scroll ke infolist.
            console.log(`Showing details for Anggota ID: ${anggotaId}`);

            // Opsi: Scroll ke bawah agar infolist terlihat
            const infolistElement = document.querySelector('.fi-infolist-grid');
            if (infolistElement) {
                infolistElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
        // window.Livewire.dispatch('drawKomisariatMarkers');
        @this.call('showKomisariatView');
        // window.Livewire.on('redrawAnggotaMarkers', () => {
        //     // Ambil ulang data anggota yang sudah difilter dari atribut
        //     const mapElement = document.getElementById('map-container');
        //     const newAnggotaData = JSON.parse(mapElement.getAttribute('data-anggota'));
        //     // Gambar ulang marker anggota
        //     drawMarkers(newAnggotaData, 'red', true);
        // });
    });
</script>
