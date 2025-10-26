<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="mapLocationPicker({
            state: $wire.entangle('{{ $getStatePath() }}'),
            lat: {{ $getState()['lat'] ?? -0.0275 }},
            lng: {{ $getState()['lng'] ?? 109.3425 }}
        })"
        @google-maps-loaded.window="initMap()"
        wire:ignore
    >
        <div x-ref="map" class="w-full rounded-md" style="height: 400px;"></div>
    </div>
</x-dynamic-component>


@once 
        <script>
        window.initMapPicker = function() {
            window.dispatchEvent(new CustomEvent('google-maps-loaded'));
        };

        document.addEventListener('alpine:init', () => {
            Alpine.data('mapLocationPicker', ({ state, lat, lng }) => ({
                map: null,
                marker: null,
                state: state,
                AdvancedMarkerElement: null,

                async initMap() {
                    const { Map } = await google.maps.importLibrary("maps");
                    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
                    
                    this.map = new Map(this.$refs.map, {
                        center: { lat: lat, lng: lng },
                        zoom: 13,
                        
                        mapId: '4504f8b37365c3d0', 
                    });

                    this.marker = new AdvancedMarkerElement({
                        map: this.map,
                        position: { lat: lat, lng: lng },
                        gmpDraggable: true,
                    });
                    
                    this.map.addListener('click', (event) => {
                        this.updateMarkerPosition(event.latLng);
                    });

                    this.marker.addListener('gmp-dragend', (event) => {
                        this.updateMarkerPosition(event.target.position);
                    });
                },

                updateMarkerPosition(position) {
                    this.marker.position = position;

                    const newPosition = {
                        lat: typeof position.lat === 'function' ? position.lat() : position.lat,
                        lng: typeof position.lng === 'function' ? position.lng() : position.lng,
                    };
                    
                    this.state = newPosition;
                }
            }));
        });
    </script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMapPicker&v=weekly" async defer></script>
@endonce