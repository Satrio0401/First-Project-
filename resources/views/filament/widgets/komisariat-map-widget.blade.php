<x-filament-widgets::widget>
    <x-filament::card>
        <h2 class="text-lg font-semibold tracking-tight">Peta Sebaran Komisariat</h2>
    </x-filament::card>
    <div class="mt-4 rounded-md shadow-md">
        <div wire:ignore class="w-full rounded-md" id="komisariat-map" style="height: 500px;"
            data-komisariat="{{ $this->getKomisariatsData() }}"></div>
    </div>
</x-filament-widgets::widget>
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
    function initializeEmptyMap() {
        console.log('Attempting to initialize empty map...');
        const mapElement = document.getElementById('komisariat-map');

        if (!mapElement) {
            console.error('Map element #komisariat-map not found!');
            return;
        }
        if (mapElement.classList.contains('map-initialized')) {
            console.warn('Map already initialized.');
            return;
        }
        mapElement.classList.add('map-initialized');
        const komisariatsData = mapElement.getAttribute('data-komisariat');
        let komisariats;
        if (!komisariatsData) {
            console.error('Attribute data-komisariats not found or is empty!');
            return;
        }

        try {
            komisariats = JSON.parse(komisariatsData);
            console.log('Data komisarit Berhasil diload:', komisariats)
        } catch (e) {
            console.error('Gagal mem parsing data JSON dari komisariat:', e);
            console.error('Data mentah: ', komisariatsData);
            return;
        }
        console.log('Map element found. Creating map...');
        const map = new google.maps.Map(mapElement, {
            zoom: 12,
            center: {
                lat: -0.05,
                lng: 109.347
            },
        });
        console.log('Empty map should be visible now.');

        // const infowindow = new google.maps.InfoWindow();

        // 3. Lakukan looping pada data komisariat
        komisariats.forEach(komisariat => {
            // Pastikan koordinat adalah angka, bukan string
            const position = {
                lat: parseFloat(komisariat.latitude),
                lng: parseFloat(komisariat.longitude)
            };

            // Buat marker untuk setiap komisariat
            const marker = new google.maps.Marker({
                position: position,
                map: map,
                title: komisariat.nama, // Teks saat hover
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png" // Marker biru
                }
            });
            const infowindow = new google.maps.InfoWindow({
                content: '<strong style="color: black;">' + komisariat.nama + '</strong>'
            });
            // 4. Tambahkan event saat marker diklik untuk menampilkan nama
            marker.addListener('click', () => {
                // infowindow.setContent('<strong>' + komisariat.nama + '</strong>');
                infowindow.open(map, marker);
            });
        });
    }

    // Dengarkan event universal
    window.addEventListener('google-maps-loaded', initializeEmptyMap);

    // Pemicu untuk navigasi SPA
    document.addEventListener('livewire:navigated', () => {
        if (window.google && window.google.maps) {
            initializeEmptyMap();
        }
    });

    // Pemicu untuk hard refresh (jika API sudah di-cache)
    if (window.google && window.google.maps) {
        initializeEmptyMap();
    }
</script>
