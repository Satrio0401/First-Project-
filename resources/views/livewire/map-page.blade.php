<div>
    <!-- Header -->
    <div class="bg-linear-to-r from-emerald-700 via-green-800 to-teal-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-2">Peta Persebaran Anggota</h1>
            <p class="text-blue-100">Marker berdasarkan jumlah anggota per kecamatan.</p>
        </div>
    </div>
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                
                <div class="md:col-span-1">
                    <label for="filter-komisariat" class="block text-sm font-medium text-gray-700">Filter Komisariat</label>
                    <select id="filter-komisariat" wire:model.live="selectedKomisariat" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md">
                        <option value="">Semua Komisariat</option>
                        @foreach($this->komisariatOptions as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="md:col-span-1">
                    <label for="filter-jurusan" class="block text-sm font-medium text-gray-700">Filter Jurusan</label>
                    <select id="filter-jurusan" wire:model.live="selectedJurusan" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md">
                        <option value="">Semua Jurusan</option>
                        @foreach($this->jurusanOptions as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-1 text-center md:text-right text-gray-600">
                    <p class="text-sm">Menampilkan <span class="font-bold text-emerald-700">{{ $markerCount }}</span> marker</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Map Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div wire:ignore id="map" class="w-full h-[500px] rounded-lg shadow-md"></div>
    </div>
</div>

<script>
    document.addEventListener('livewire:navigated', () => {
        
        let map = null;
        let activeMarkers = [];
        const defaultAvatar = "{{ asset('images/default-avatar.png') }}";
        
        const abortController = new AbortController();

        document.addEventListener('livewire:navigating', () => {
            
            abortController.abort();
            
            map = null;
        }, { once: true }); 

        function clearMarkers() {
            activeMarkers.forEach(marker => marker.setMap(null));
            activeMarkers = [];
        }

        function drawMarkers(anggotaData) {
            if (!map) return;
            clearMarkers();

            const infowindow = new google.maps.InfoWindow();

            anggotaData.forEach(anggota => {
                const lat = parseFloat(anggota.latitude);
                const lng = parseFloat(anggota.longitude);
                if (isNaN(lat) || isNaN(lng)) return;

                const marker = new google.maps.Marker({
                    position: { lat, lng },
                    map,
                    title: anggota.nama
                });
                activeMarkers.push(marker);

                const contentString = `
                    <div style="display: flex; align-items: center; gap: 15px; color: black; max-width: 350px;">
                        <img src="${anggota.foto ? '/storage/' + anggota.foto : defaultAvatar}" alt="${anggota.nama}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                        <div>
                            <strong style="font-size: 1.1em;">${anggota.nama}</strong><br>
                            <strong>Kuliah:</strong> ${anggota.tahun_masuk_kuliah || 'N/A'}<br>
                            <strong>LK1:</strong> ${anggota.tahun_lk1 || 'N/A'}<br>
                            <strong>Jurusan:</strong> ${anggota.jurusan ? anggota.jurusan.nama_jurusan : 'N/A'}<br>
                            <strong>Komisariat:</strong> ${anggota.komisariat ? anggota.komisariat.nama : 'N/A'}
                        </div>
                    </div>
                `;

                marker.addListener('click', () => {
                    infowindow.setContent(contentString);
                    infowindow.open(map, marker);
                });
            });
        }

        function initialize() {
            const mapElement = document.getElementById("map");
            if (!mapElement || map) return;

            const centerLocation = { lat: -0.026330, lng: 109.342503 };
            map = new google.maps.Map(mapElement, {
                zoom: 12,
                center: centerLocation,
            });

            Livewire.on('updateMap', ({ data }) => {
                drawMarkers(data);
            }, { signal: abortController.signal });

            @this.call('triggerRender');
        }

        if (typeof google === 'object' && typeof google.maps === 'object') {
            initialize();
        } else {
            window.addEventListener('google-maps-loaded', initialize, { once: true });
        }
    });
</script>

<script>
    function initAllMaps() {
        window.dispatchEvent(new CustomEvent('google-maps-loaded'));
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initAllMaps&v=weekly" async defer></script>
