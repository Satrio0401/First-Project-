<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    {{-- 1. Ubah cara inisialisasi x-data dan hapus event listener --}}
    <div x-data="mapLocationPicker({
        state: $wire.entangle('{{ $getStatePath() }}'),
        lat: {{ optional($getState())['lat'] ?? -0.0275 }},
        lng: {{ optional($getState())['lng'] ?? 109.3425 }}
    })" wire:ignore>
        <div x-ref="map" class="w-full rounded-md" style="height: 400px;"></div>
    </div>
</x-dynamic-component>

@once
    <script>
        // 2. Ubah callback Google Maps untuk memanggil method di dalam komponen Alpine
        function initMapPicker() {
            // Dispatch event yang bisa didengarkan oleh komponen Alpine
            window.dispatchEvent(new CustomEvent('google-maps-loaded'));
        }

        document.addEventListener('alpine:init', () => {
            // 3. Ubah struktur komponen Alpine
            Alpine.data('mapLocationPicker', ({
                state,
                lat,
                lng
            }) => ({
                map: null,
                marker: null,
                state: state,

                // 'init' adalah method spesial di Alpine yang berjalan saat komponen diinisialisasi
                init() {
                    // Dengarkan event dari Google Maps, lalu panggil initMap
                    window.addEventListener('google-maps-loaded', () => {
                        this.initMap();
                    });

                    // Jika Google Maps sudah termuat sebelumnya, langsung panggil initMap
                    if (window.google && window.google.maps) {
                        this.initMap();
                    }
                    this.$watch('state', (newState) => {
                        // Cek jika state baru valid dan berbeda dari posisi marker saat ini
                        if (newState && newState.lat && newState.lng) {
                            const newPosition = new google.maps.LatLng(newState.lat, newState.lng);
                            if (!this.marker.getPosition().equals(newPosition)) {
                                this.updateMapFromState(newPosition);
                            }
                        }
                    });
                },

                initMap() {
                    // Guard clause untuk mencegah inisialisasi ganda
                    if (this.map) return;

                    this.map = new google.maps.Map(this.$refs.map, {
                        center: {
                            lat: lat,
                            lng: lng
                        },
                        zoom: 12,
                    });

                    this.marker = new google.maps.Marker({
                        position: {
                            lat: lat,
                            lng: lng
                        },
                        map: this.map,
                        draggable: true,
                    });

                    this.map.addListener('click', (event) => {
                        this.updateMarkerPosition(event.latLng);
                    });

                    this.marker.addListener('dragend', (event) => {
                        this.updateMarkerPosition(event.latLng);
                    });
                },

                updateMarkerPosition(latLng) {
                    this.marker.setPosition(latLng);
                    this.state = {
                        lat: latLng.lat(),
                        lng: latLng.lng(),
                    };
                },

                updateMapFromState(newPosition) {
                    this.marker.setPosition(newPosition);
                    this.map.panTo(newPosition);
                }
            }));
        });
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMapPicker&libraries=places&v=weekly"
        async defer></script>
@endonce