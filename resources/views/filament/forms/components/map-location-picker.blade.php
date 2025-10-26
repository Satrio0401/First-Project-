<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="mapLocationPicker({
        state: $wire.entangle('{{ $getStatePath() }}'),
        lat: {{ optional($getState())['lat'] ?? -0.0275 }},
        lng: {{ optional($getState())['lng'] ?? 109.3425 }}
    })" @google-maps-loaded.window="initMap()" wire:ignore>
        <div x-ref="map" class="w-full rounded-md" style="height: 400px;"></div>
    </div>
</x-dynamic-component>
@once
    <script>
        window.initMapPicker = function() {
            window.dispatchEvent(new CustomEvent('google-maps-loaded'));
        };
        document.addEventListener('alpine:init', () => {
            Alpine.data('mapLocationPicker', ({
                state,
                lat,
                lng
            }) => ({
                map: null,
                marker: null,
                state: state,
                initMap() {
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
                    const newPosition = {
                        lat: latLng.lat(),
                        lng: latLng.lng(),
                    };
                    this.state = newPosition;
                }
            }));
        });
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMapPicker&libraries=places&v=weekly"
        async defer></script>
@endonce
