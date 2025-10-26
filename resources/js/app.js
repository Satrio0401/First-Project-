// resources/js/app.js

// Fungsi global ini akan dipanggil oleh script Google Maps setelah selesai dimuat
// Kita buat kosong saja, karena inisialisasi sebenarnya terjadi di dalam Alpine
window.initMapPicker = function() {};

document.addEventListener('alpine:init', () => {
    Alpine.data('mapLocationPicker', ({ state, lat, lng }) => ({
        map: null,
        marker: null,
        state: state, // Terhubung ke Filament via $wire.entangle

        initMap() {
            // Inisialisasi peta di dalam div yang memiliki x-ref="map"
            this.map = new google.maps.Map(this.$refs.map, {
                center: { lat: lat, lng: lng },
                zoom: 13,
            });

            // Buat marker awal di posisi yang diberikan
            this.marker = new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: this.map,
                draggable: true, // PENTING: Agar marker bisa digeser
            });

            // Tambahkan event listener saat peta diklik
            this.map.addListener('click', (event) => {
                this.updateMarkerPosition(event.latLng);
            });

            // Tambahkan event listener saat marker selesai digeser
            this.marker.addListener('dragend', (event) => {
                this.updateMarkerPosition(event.latLng);
            });
        },

        // Fungsi untuk memperbarui posisi marker dan mengirim data ke Filament
        updateMarkerPosition(latLng) {
            // Pindahkan marker ke posisi baru
            this.marker.setPosition(latLng);

            // Siapkan data posisi baru
            const newPosition = {
                lat: latLng.lat(),
                lng: latLng.lng(),
            };

            // Perbarui 'state' yang terhubung ke Filament.
            // Ini akan secara otomatis mengirim data kembali ke backend.
            this.state = newPosition;
        }
    }));
});