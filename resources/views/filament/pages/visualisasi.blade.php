<x-filament-panels::page>

    <div class="flex flex-col">
        <div class="flex gap-4">
            <button id="btn-komisariat"
                class="px-3 py-2 text-sm font-semibold rounded-lg shadow-sm transition-all duration-200 
                       dark:bg-green-600 bg-green-400 text-green-900 dark:text-gray-950  hover:bg-green-500">
                Tampilkan Komisariat
            </button>
            <button id="btn-anggota"
                class="px-3 py-2 text-sm font-semibold rounded-lg shadow-sm ring-1 ring-gray-200 dark:ring-zinc-700 bg-white dark:bg-neutral-900 text-zinc-800 dark:text-white hover:dark:bg-neutral-800 transition-all duration-200">
                Tampilkan Anggota
            </button>
        </div>
        <div id="filter-container" class="hidden">
            <div class=" grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
                <div>
                    
                    <div class="relative">
                        <select id="filter-jurusan"
                            class="block w-full rounded-lg border-0 py-2 px-3 dark:text-white shadow-sm dark:bg-neutral-900 ring-1 ring-zinc-700 focus:ring-2 focus:ring-green-600 sm:text-sm sm:leading-6">
                            <option value="" class="bg-white text-gray-900">Semua Jurusan</option>
                            @foreach ($this->jurusanOptions as $id => $nama)
                                <option value="{{ $id }}" class="bg-white text-gray-900">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    
                    <div class="relative">
                        <select id="filter-komisariat"
                            class="block w-full rounded-lg border-0 py-2 px-3 dark:text-white shadow-sm dark:bg-neutral-900 ring-1 ring-zinc-700 focus:ring-2 focus:ring-green-600 sm:text-sm sm:leading-6">
                            <option value="" class="bg-white text-gray-900">Semua Komisariat</option>
                            @foreach ($this->komisariatOptions as $id => $nama)
                                <option value="{{ $id }}" class="bg-white text-gray-900">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-12 text-sm font-medium text-gray-500 dark:text-gray-400">
            Menampilkan: <span id="marker-count" class="font-bold text-gray-700 dark:text-gray-200"></span> marker
        </div>
        <div class="mt-8 dark:bg-zinc-900 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-zinc-800 p-6">
            <h2 class="text-lg font-semibold tracking-tight text-black dark:text-white">
                Peta Sebaran Komisariat dan Anggota
            </h2>
        </div>

        
    </div>

    <div class="w-full mt-4 bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
        <div id="map-container" class="w-full h-[500px] z-0"></div>
    </div>

    <div id="detail-panel" class="hidden transition-all duration-500 ease-in-out">

        <h3 class="text-lg font-bold  mb-4 flex items-center gap-2 dark:text-white text-zinc-800">
            <span class="w-1 h-6 bg-emerald-500 rounded-full "></span>
            Detail Informasi Anggota
        </h3>

        <div class="dark:bg-zinc-900 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-zinc-700 overflow-hidden">
            <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-12 gap-8">

                <div
                    class="md:col-span-4 flex flex-col items-center text-center border-b md:border-b-0 md:border-r border-gray-100 pb-6 md:pb-0 md:pr-6">
                    <div class="relative mb-4">
                        <img id="detail-foto" src="" alt="Foto Anggota"
                            class="w-40 h-40 object-cover shadow-lg ">
                        
                    </div>

                    <h2 id="detail-nama" class="text-2xl font-bold dark:text-white text-gray-950 tracking-tight"></h2>

                    <span id="detail-jurusan"
                        class="mt-2 inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                    </span>

                    <span id="detail-komisariat"
                        class="mt-1 inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                    </span>
                </div>

                <div class="md:col-span-8 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">

                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Kelamin</dt>
                            <dd id="detail-kelamin" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Angkatan / Masuk Kuliah</dt>
                            <dd id="detail-angkatan" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Tempat, Tanggal Lahir</dt>
                            <dd id="detail-ttl" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Tahun LK 1</dt>
                            <dd id="detail-lk1" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Tahun LK 2</dt>
                            <dd id="tahun_lk2" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Cabang LK 2</dt>
                            <dd id="cabang_lk2" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Tahun LK 3</dt>
                            <dd id="tahun_lk3" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Cabang LK 3</dt>
                            <dd id="badko_lk3" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Tahun LKK</dt>
                            <dd id="tahun_lkk" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Cabang LKK</dt>
                            <dd id="cabang_lkk" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Prestasi</dt>
                            <dd id="prestasi" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Nomor WhatsApp</dt>
                            <dd id="detail-wa" class="mt-1 text-sm font-semibold dark:text-white text-gray-950 font-mono"></dd>
                        </div>

                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Alamat Domisili</dt>
                            <dd id="detail-alamat" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>

                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium dark:text-white text-gray-950">Titik Koordinat</dt>
                            <dd id="detail-latlng"
                                class="mt-1 text-xs font-mono text-gray-500 bg-gray-50 p-2 rounded border border-gray-200 inline-block">
                            </dd>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-filament-panels::page>

{{-- Load Google Maps Script --}}
@once('google-maps-script')
    <script>
        function initAllMaps() {
            window.dispatchEvent(new CustomEvent('google-maps-loaded'));
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initAllMaps&v=weekly"
        async defer></script>
@endonce

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. DATA SETUP ---
        const rawDataAnggota = @json($anggotaJson);
        const rawDataKomisariat = @json($komisariatJson);

        // State
        let map;
        let activeMarkers = [];
        let currentMode = 'komisariat';

        // Elements
        const elBtnKomisariat = document.getElementById('btn-komisariat');
        const elBtnAnggota = document.getElementById('btn-anggota');
        const elFilterContainer = document.getElementById('filter-container');
        const elSelectJurusan = document.getElementById('filter-jurusan');
        const elSelectKomisariat = document.getElementById('filter-komisariat');
        const elCounter = document.getElementById('marker-count');

        // Detail Panel Elements
        const elDetailPanel = document.getElementById('detail-panel');

        // --- 2. MAP LOGIC ---
        function initializeMap() {
            const mapEl = document.getElementById('map-container');
            if (!mapEl) return;

            if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                window.addEventListener('google-maps-loaded', initializeMap, {
                    once: true
                });
                return;
            }

            map = new google.maps.Map(mapEl, {
                zoom: 12,
                center: {
                    lat: -0.026330,
                    lng: 109.342503
                },
                streetViewControl: false,
                mapTypeControl: false,
                fullscreenControl: true,
                styles: [ // Optional: Sedikit styling map biar lebih clean
                    {
                        featureType: "poi",
                        elementType: "labels",
                        stylers: [{
                            visibility: "off"
                        }]
                    }
                ]
            });

            setMode('komisariat');
        }

        function clearMap() {
            activeMarkers.forEach(m => m.setMap(null));
            activeMarkers = [];
        }

        function renderMarkers(data, type) {
            clearMap();
            const infoWindow = new google.maps.InfoWindow();

            data.forEach(item => {
                const lat = parseFloat(item.latitude);
                const lng = parseFloat(item.longitude);

                if (isNaN(lat) || isNaN(lng)) return;

                const iconUrl = type === 'anggota' ?
                    "http://maps.google.com/mapfiles/ms/icons/red-dot.png" // Merah
                    :
                    "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"; // Biru/Hijau

                const marker = new google.maps.Marker({
                    position: {
                        lat,
                        lng
                    },
                    map: map,
                    title: item.nama,
                    icon: iconUrl
                });

                marker.addListener('click', () => {
                    if (type === 'anggota') {
                        showDetailPanel(item); // Tampilkan Detail di Bawah
                    }
                    infoWindow.setContent(`
                        <div style="padding:5px; font-weight:600; font-family:sans-serif; color: black;">
                            ${item.nama}
                        </div>
                    `);
                    infoWindow.open(map, marker);
                });

                activeMarkers.push(marker);
            });

            elCounter.innerText = activeMarkers.length;
        }

        // --- 3. FILTER LOGIC ---
        function applyFilters() {
            // Sembunyikan detail panel setiap kali filter berubah
            elDetailPanel.classList.add('hidden');

            const jurId = elSelectJurusan.value;
            const komId = elSelectKomisariat.value;

            const filtered = rawDataAnggota.filter(anggota => {
                const matchJurusan = jurId === "" || anggota.jurusan_id == jurId;
                const matchKomisariat = komId === "" || anggota.komisariat_id == komId;
                return matchJurusan && matchKomisariat;
            });

            renderMarkers(filtered, 'anggota');
        }

        function setMode(mode) {
            currentMode = mode;
            elDetailPanel.classList.add('hidden'); // Reset detail saat ganti mode

            // Style Reset
            const activeClass = ['bg-emerald-600', 'text-white', 'ring-emerald-600'];
            const inactiveClass = ['bg-white', 'text-gray-950', 'ring-gray-950/10'];

            if (mode === 'komisariat') {
                // Update Button Style
                // elBtnKomisariat.classList.add(...activeClass);
                // elBtnKomisariat.classList.remove(...inactiveClass);
                // elBtnAnggota.classList.add(...inactiveClass);
                // elBtnAnggota.classList.remove(...activeClass);

                elFilterContainer.classList.add('hidden');
                renderMarkers(rawDataKomisariat, 'komisariat');

            } else {
                // elBtnAnggota.classList.add(...activeClass);
                // elBtnAnggota.classList.remove(...inactiveClass);
                // elBtnKomisariat.classList.add(...inactiveClass);
                // elBtnKomisariat.classList.remove(...activeClass);

                elFilterContainer.classList.remove('hidden');
                applyFilters();
            }
        }

        // --- 4. DETAIL PANEL LOGIC (UPDATED) ---
        function showDetailPanel(data) {
            // 1. Populate Data
            document.getElementById('detail-foto').src = data.foto_url;
            document.getElementById('detail-nama').textContent = data.nama;
            document.getElementById('detail-kelamin').textContent = data.kelamin;
            document.getElementById('detail-jurusan').textContent = data.jurusan_nama;
            document.getElementById('detail-komisariat').textContent = data.komisariat_nama;

            document.getElementById('detail-angkatan').textContent = data.tahun_masuk_kuliah || '-';
            document.getElementById('detail-ttl').textContent =
                `${data.tempat_lahir || ''}, ${data.tanggal_lahir}`;
            document.getElementById('detail-alamat').textContent = data.alamat || '-';
            document.getElementById('detail-lk1').textContent = data.tahun_lk1 || '-';
            document.getElementById('detail-wa').textContent = data.no_wa || '-';
            document.getElementById('tahun_lk2').textContent = data.tahun_lk2 || '-';
            document.getElementById('cabang_lk2').textContent = data.cabang_lk2 || '-';
            document.getElementById('tahun_lk3').textContent = data.tahun_lk3 || '-';
            document.getElementById('badko_lk3').textContent = data.badko_lk3 || '-';
            document.getElementById('tahun_lkk').textContent = data.tahun_lkk || '-';
            document.getElementById('cabang_lkk').textContent = data.cabang_lkk || '-';
            document.getElementById('prestasi').textContent = data.prestasi || '-';
            document.getElementById('detail-latlng').textContent = `${data.latitude}, ${data.longitude}`;

            // 2. Show Panel (Remove Hidden)
            elDetailPanel.classList.remove('hidden');

            // 3. Auto Scroll ke Panel Detail (UX Improvement)
            // Memberi sedikit delay agar transisi CSS terlihat smooth, baru scroll
            setTimeout(() => {
                elDetailPanel.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
        }

        // --- 5. EVENT LISTENERS ---
        elBtnKomisariat.addEventListener('click', () => setMode('komisariat'));
        elBtnAnggota.addEventListener('click', () => setMode('anggota'));
        elSelectJurusan.addEventListener('change', applyFilters);
        elSelectKomisariat.addEventListener('change', applyFilters);

        // Start
        initializeMap();
    });
</script>
