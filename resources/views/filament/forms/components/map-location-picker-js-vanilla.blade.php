@once
    <script>
        function initMapPicker() {
            window.dispatchEvent(new CustomEvent('google-maps-loaded'));
        }

        function initializeSimpleMap(mapContainerId, latInputId, lngInputId) {
            const mapContainer = document.getElementById(mapContainerId);
            const latInput = document.getElementById(latInputId);
            const lngInput = document.getElementById(lngInputId);

            if (!mapContainer || !latInput || !lngInput) {
                return;
            }
            if (mapContainer.style.position === 'relative') {
                return;
            }
            let initialLat = parseFloat(latInput.value);
            let initialLng = parseFloat(lngInput.value);

            if (isNaN(initialLat) || isNaN(initialLng)) {
                initialLat = -0.0236;
                initialLng = 109.3322;
            }

            const initialPosition = new google.maps.LatLng(initialLat, initialLng);

            const map = new google.maps.Map(mapContainer, {
                center: initialPosition,
                zoom: 12,
            });

            const marker = new google.maps.Marker({
                position: initialPosition,
                map: map,
                draggable: true,
            });
            let isMapInteraction = false;
            function handleMapInteraction(latLng) {
                isMapInteraction = true;
                marker.setPosition(latLng);
                latInput.value = latLng.lat().toFixed(6);
                lngInput.value = latLng.lng().toFixed(6);
                latInput.dispatchEvent(new Event('input'));
                lngInput.dispatchEvent(new Event('input'));
                setTimeout(() => { isMapInteraction = false; }, 0);
            }

            function updateMapFromInputs() {
                if (isMapInteraction){
                    return;
                }
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);

                if (!isNaN(lat) && !isNaN(lng)) {
                    const newPosition = new google.maps.LatLng(lat, lng);
                    marker.setPosition(newPosition);
                    map.setCenter(newPosition);
                }
            }

            map.addListener('click', (event) => handleMapInteraction(event.latLng));
            marker.addListener('dragend', (event) => handleMapInteraction(event.latLng));

            latInput.addEventListener('input', updateMapFromInputs);
            lngInput.addEventListener('input', updateMapFromInputs);
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMapPicker&libraries=places&v=weekly"
        async defer></script>
@endonce
<div wire:ignore>
    <div id="{{ $getId() }}-map" class="w-full rounded-md" style="height: 400px;"></div>
</div>

<script>
    function triggerMapInit_{{ str_replace('.', '_', $getId()) }}() {
        setTimeout(() => {
            initializeSimpleMap(
                '{{ $getId() }}-map',
                '{{ $getLatitudeId() }}',
                '{{ $getLongitudeId() }}'
            );
        }, 0);
    }
    window.addEventListener('google-maps-loaded', triggerMapInit_{{ str_replace('.', '_', $getId()) }}, {
        once: true
    });
    if (window.google && window.google.maps) {
        triggerMapInit_{{ str_replace('.', '_', $getId()) }}();
    }

    document.addEventListener('livewire:navigated', () => {
        if (window.google && window.google.maps) {
            // Jika sudah siap, baru panggil.
            triggerMapInit_{{ str_replace('.', '_', $getId()) }}();
        }
        
    });
</script>
