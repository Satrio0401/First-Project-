<div>
    <!-- Header -->
    <div class="bg-linear-to-r from-emerald-700 via-green-800 to-teal-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-2">Peta Persebaran Anggota</h1>
            <p class="text-blue-100">Marker berdasarkan jumlah anggota per kecamatan.</p>
        </div>
    </div>

    <!-- Map Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div id="map" class="w-full h-[500px] rounded-lg shadow-md"></div>
    </div>
</div>

<script>
    const kecamatanData = @json($kecamatanData);

    function initMap() {
        // Titik tengah default (Pontianak)
        const centerLocation = { lat: -0.026330, lng: 109.342503 };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: centerLocation,
        });

        if (!kecamatanData.length) {
            console.warn("Tidak ada data kecamatan");
            return;
        }

        kecamatanData.forEach(item => {
            const lat = parseFloat(item.latitude);
            const lng = parseFloat(item.longitude);

            if (isNaN(lat) || isNaN(lng)) return;

            const marker = new google.maps.Marker({
                position: { lat, lng },
                map,
                title: item.kecamatan
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div>
                        <strong>Kecamatan:</strong> ${item.kecamatan} <br>
                        <strong>Jumlah Anggota:</strong> ${item.jumlah}
                    </div>
                `
            });

            marker.addListener('click', () => infoWindow.open(map, marker));
        });
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgGBjlEnlrlO2KdsQMFL70E_Ppo3GmFPs&callback=initMap&v=weeklyy" async defer></script>
