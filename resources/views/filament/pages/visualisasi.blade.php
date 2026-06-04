<x-filament-panels::page>
    <style>
        /* Fix Tombol Close InfoWindow Google Maps yang hilang akibat reset CSS Tailwind */
        .gm-style-iw button[title="Close"] {
            opacity: 1 !important;
            background: none !important;
        }
        .gm-style-iw button[title="Close"] img,
        .gm-style-iw button[title="Close"] svg {
            display: block !important;
            width: 15px !important;
            height: 15px !important;
            fill: #333 !important;
        }
        .gm-ui-hover-effect span {
            background-color: #333 !important;
        }
    </style>

    {{-- TOOLBAR: Tombol kembali + filter (hanya muncul di mode anggota) --}}
    <div class="flex flex-col gap-4">
        <div id="btn-back-container" class="hidden flex flex-col sm:flex-row sm:items-center gap-4">
            <button id="btn-kembali"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg shadow-sm ring-1 ring-gray-200 dark:ring-zinc-700 bg-white dark:bg-neutral-900 text-zinc-800 dark:text-white hover:bg-gray-50 hover:dark:bg-neutral-800 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Peta Komisariat
            </button>
            <div class="text-base font-bold text-gray-800 dark:text-white">
                <span id="nama-komisariat-filter" class="text-emerald-600 dark:text-emerald-400"></span>
            </div>
        </div>

        <div id="filter-container" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Filter Jurusan
                    </label>
                    <select id="filter-jurusan"
                        class="block w-full rounded-lg border-0 py-2 px-3 dark:text-white shadow-sm dark:bg-neutral-900 ring-1 ring-zinc-700 focus:ring-2 focus:ring-green-600 sm:text-sm sm:leading-6">
                        <option value="">Semua Jurusan</option>
                        @foreach ($this->jurusanOptions as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Legenda gender --}}
                <div class="flex items-center gap-6 pb-1">
                    <div class="flex items-center gap-2">
                        <img src="http://maps.google.com/mapfiles/ms/icons/blue-dot.png" class="w-5 h-5" alt="">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Laki-laki</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <img src="http://maps.google.com/mapfiles/ms/icons/pink-dot.png" class="w-5 h-5" alt="">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Perempuan</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Menampilkan: <span id="marker-count" class="font-bold text-gray-700 dark:text-gray-200">0</span> marker
        </div>
    </div>

    {{-- MAP --}}
    <div class="w-full mt-4 bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
        <div id="map-container" class="w-full h-[500px] z-0"></div>
    </div>

    {{-- CARD KOMISARIAT (muncul saat marker komisariat diklik) --}}
    <div id="komisariat-panel" class="hidden mt-6 transition-all duration-500 ease-in-out">
        <h3 class="text-lg font-bold mb-4 flex items-center gap-2 dark:text-white text-zinc-800">
            <span class="w-1 h-6 bg-emerald-500 rounded-full"></span>
            Informasi Komisariat
        </h3>
        <div class="dark:bg-zinc-900 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-zinc-700 p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                <div class="space-y-2">
                    <h2 id="kom-nama" class="text-2xl font-bold dark:text-white text-gray-900"></h2>
                    <div id="kom-extra" class="space-y-1 text-sm text-gray-500 dark:text-gray-400"></div>
                </div>
                <div class="shrink-0">
                    <button id="btn-lihat-anggota"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition-all duration-200 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Lihat Semua Anggota
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- DETAIL ANGGOTA (muncul saat marker anggota diklik) --}}
    <div id="detail-panel" class="hidden mt-6 transition-all duration-500 ease-in-out">
        <h3 class="text-lg font-bold mb-4 flex items-center gap-2 dark:text-white text-zinc-800">
            <span class="w-1 h-6 bg-emerald-500 rounded-full"></span>
            Detail Informasi Anggota
        </h3>
        <div class="dark:bg-zinc-900 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-zinc-700 overflow-hidden">
            <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-12 gap-8">

                <div class="md:col-span-4 flex flex-col items-center text-center border-b md:border-b-0 md:border-r border-gray-100 dark:border-zinc-700 pb-6 md:pb-0 md:pr-6">
                    <div class="relative mb-4">
                        <img id="detail-foto" src="" alt="Foto Anggota"
                            class="w-40 h-40 object-cover shadow-lg rounded-xl">
                    </div>
                    <h2 id="detail-nama" class="text-2xl font-bold dark:text-white text-gray-950 tracking-tight"></h2>
                    <span id="detail-jurusan"
                        class="mt-2 inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20"></span>
                    <span id="detail-komisariat"
                        class="mt-1 inline-flex items-center rounded-md bg-gray-50 dark:bg-zinc-800 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 ring-1 ring-inset ring-gray-500/10"></span>
                </div>

                <div class="md:col-span-8 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelamin</dt>
                            <dd id="detail-kelamin" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Angkatan / Masuk Kuliah</dt>
                            <dd id="detail-angkatan" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tempat, Tanggal Lahir</dt>
                            <dd id="detail-ttl" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun LK 1</dt>
                            <dd id="detail-lk1" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun LK 2</dt>
                            <dd id="tahun_lk2" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cabang LK 2</dt>
                            <dd id="cabang_lk2" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun LK 3</dt>
                            <dd id="tahun_lk3" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cabang LK 3</dt>
                            <dd id="badko_lk3" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun LKK</dt>
                            <dd id="tahun_lkk" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cabang LKK</dt>
                            <dd id="cabang_lkk" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Prestasi</dt>
                            <dd id="prestasi" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor WhatsApp</dt>
                            <dd id="detail-wa" class="mt-1 text-sm font-semibold dark:text-white text-gray-950 font-mono"></dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat Domisili</dt>
                            <dd id="detail-alamat" class="mt-1 text-sm font-semibold dark:text-white text-gray-950"></dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Titik Koordinat</dt>
                            <dd id="detail-latlng"
                                class="mt-1 text-xs font-mono text-gray-500 bg-gray-50 dark:bg-zinc-800 p-2 rounded border border-gray-200 dark:border-zinc-600 inline-block"></dd>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-filament-panels::page>

{{-- Google Maps Script --}}
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

    // ── DATA ──────────────────────────────────────────────────────────────────
    const rawDataAnggota    = @json($anggotaJson);
    const rawDataKomisariat = @json($komisariatJson);

    // ── STATE ─────────────────────────────────────────────────────────────────
    let map;
    let activeMarkers = [];
    let currentMode   = 'komisariat'; // 'komisariat' | 'anggota'
    let sharedInfoWindow = null;
    let selectedKomisariatId = null;

    // ── ELEMENTS ──────────────────────────────────────────────────────────────
    const elBtnBackContainer = document.getElementById('btn-back-container');
    const elBtnKembali       = document.getElementById('btn-kembali');
    const elFilterContainer  = document.getElementById('filter-container');
    const elSelectJurusan    = document.getElementById('filter-jurusan');
    const elCounter          = document.getElementById('marker-count');
    const elKomisariatPanel  = document.getElementById('komisariat-panel');
    const elDetailPanel      = document.getElementById('detail-panel');
    const elBtnLihatAnggota  = document.getElementById('btn-lihat-anggota');

    // ── MAP INIT ──────────────────────────────────────────────────────────────
    function initializeMap() {
        const mapEl = document.getElementById('map-container');
        if (!mapEl) return;

        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
            window.addEventListener('google-maps-loaded', initializeMap, { once: true });
            return;
        }

        map = new google.maps.Map(mapEl, {
            zoom: 12,
            center: { lat: -0.026330, lng: 109.342503 },
            streetViewControl: false,
            mapTypeControl: false,
            fullscreenControl: true,
            styles: [{ featureType: 'poi', elementType: 'labels', stylers: [{ visibility: 'off' }] }]
        });

        sharedInfoWindow = new google.maps.InfoWindow();

        renderKomisariatMarkers();
    }

    // ── UTILS ─────────────────────────────────────────────────────────────────
    function clearMap() {
        activeMarkers.forEach(m => m.setMap(null));
        activeMarkers = [];
    }

    function infoWindowContent(nama, lat = null, lng = null, alamat = null) {
        let html = `<div style="padding:4px 6px;font-family:sans-serif;color:#111;font-size:13px;max-width:250px;">`;
        html += `<div style="font-weight:600;margin-bottom:2px;">${nama}</div>`;
        if (alamat) {
            html += `<div style="font-size:11px;color:#555;margin-bottom:4px;line-height:1.3;">📍 ${alamat}</div>`;
        }
        if (lat !== null && lng !== null) {
            html += `<div style="font-size:10px;color:#888;font-family:monospace;margin-top:2px;">Lat: ${lat}<br>Lng: ${lng}</div>`;
        }
        html += `</div>`;
        return html;
    }

    function scrollTo(el) {
        setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 120);
    }

    // ── RENDER: KOMISARIAT ────────────────────────────────────────────────────
    function renderKomisariatMarkers() {
        clearMap();

        rawDataKomisariat.forEach(item => {
            const lat = parseFloat(item.latitude);
            const lng = parseFloat(item.longitude);
            if (isNaN(lat) || isNaN(lng)) return;

            const marker = new google.maps.Marker({
                position: { lat, lng },
                map,
                title: item.nama,
                icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
            });

            marker.addListener('click', () => {
                sharedInfoWindow.setContent(infoWindowContent(item.nama, item.latitude, item.longitude, item.alamat));
                sharedInfoWindow.open(map, marker);
                showKomisariatPanel(item);
            });

            activeMarkers.push(marker);
        });

        elCounter.innerText = activeMarkers.length;
    }

    // ── RENDER: ANGGOTA ───────────────────────────────────────────────────────
    function renderAnggotaMarkers() {
        clearMap();

        const jurId    = elSelectJurusan.value;
        const filtered = rawDataAnggota.filter(a =>
            (jurId === '' || a.jurusan_id == jurId) &&
            (selectedKomisariatId === null || a.komisariat_id == selectedKomisariatId)
        );

        filtered.forEach(item => {
            const lat = parseFloat(item.latitude);
            const lng = parseFloat(item.longitude);
            if (isNaN(lat) || isNaN(lng)) return;

            // Warna marker berdasarkan gender
            const isLakiLaki = ['laki-laki', 'l', 'male', 'pria']
                .includes((item.kelamin || '').toLowerCase().trim());
            const iconUrl = isLakiLaki
                ? 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'  // Biru  = laki-laki
                : 'http://maps.google.com/mapfiles/ms/icons/pink-dot.png'; // Pink  = perempuan

            const marker = new google.maps.Marker({
                position: { lat, lng },
                map,
                title: item.nama,
                icon: iconUrl
            });

            marker.addListener('click', () => {
                sharedInfoWindow.setContent(infoWindowContent(item.nama, item.latitude, item.longitude, item.alamat));
                sharedInfoWindow.open(map, marker);
                showDetailPanel(item);
            });

            activeMarkers.push(marker);
        });

        elCounter.innerText = activeMarkers.length;
    }

    // ── PANEL: KOMISARIAT ─────────────────────────────────────────────────────
    function showKomisariatPanel(data) {
        selectedKomisariatId = data.id;
        document.getElementById('kom-nama').textContent = data.nama;

        const extras = [];
        if (data.alamat)  extras.push(`<div>📍 ${data.alamat}</div>`);
        if (data.ketua)   extras.push(`<div>👤 Ketua: ${data.ketua}</div>`);
        if (data.no_telp) extras.push(`<div>📞 ${data.no_telp}</div>`);
        document.getElementById('kom-extra').innerHTML = extras.join('');

        elDetailPanel.classList.add('hidden');
        elKomisariatPanel.classList.remove('hidden');
        scrollTo(elKomisariatPanel);
    }

    // ── PANEL: DETAIL ANGGOTA ─────────────────────────────────────────────────
    function showDetailPanel(data) {
        document.getElementById('detail-foto').src              = data.foto_url || '';
        document.getElementById('detail-nama').textContent      = data.nama;
        document.getElementById('detail-kelamin').textContent   = data.kelamin;
        document.getElementById('detail-jurusan').textContent   = data.jurusan_nama;
        document.getElementById('detail-komisariat').textContent= data.komisariat_nama;
        document.getElementById('detail-angkatan').textContent  = data.tahun_masuk_kuliah || '-';
        document.getElementById('detail-ttl').textContent       = `${data.tempat_lahir || ''}, ${data.tanggal_lahir || '-'}`;
        document.getElementById('detail-alamat').textContent    = data.alamat || '-';
        document.getElementById('detail-lk1').textContent       = data.tahun_lk1 || '-';
        document.getElementById('detail-wa').textContent        = data.no_wa || '-';
        document.getElementById('tahun_lk2').textContent        = data.tahun_lk2 || '-';
        document.getElementById('cabang_lk2').textContent       = data.cabang_lk2 || '-';
        document.getElementById('tahun_lk3').textContent        = data.tahun_lk3 || '-';
        document.getElementById('badko_lk3').textContent        = data.badko_lk3 || '-';
        document.getElementById('tahun_lkk').textContent        = data.tahun_lkk || '-';
        document.getElementById('cabang_lkk').textContent       = data.cabang_lkk || '-';
        document.getElementById('prestasi').textContent         = data.prestasi || '-';
        document.getElementById('detail-latlng').textContent    = `${data.latitude}, ${data.longitude}`;

        elDetailPanel.classList.remove('hidden');
        scrollTo(elDetailPanel);
    }

    // ── MODE SWITCHES ─────────────────────────────────────────────────────────
    function switchToAnggotaMode() {
        currentMode = 'anggota';

        const kom = rawDataKomisariat.find(k => k.id == selectedKomisariatId);
        const namaKom = kom ? kom.nama : '-';
        document.getElementById('nama-komisariat-filter').textContent = namaKom;

        elKomisariatPanel.classList.add('hidden');
        elDetailPanel.classList.add('hidden');
        elBtnBackContainer.classList.remove('hidden');
        elFilterContainer.classList.remove('hidden');
        renderAnggotaMarkers();
        // Scroll kembali ke peta
        document.getElementById('map-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function switchToKomisariatMode() {
        currentMode = 'komisariat';
        elKomisariatPanel.classList.add('hidden');
        elDetailPanel.classList.add('hidden');
        elBtnBackContainer.classList.add('hidden');
        elFilterContainer.classList.add('hidden');
        elSelectJurusan.value = '';
        renderKomisariatMarkers();
        document.getElementById('map-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // ── EVENT LISTENERS ───────────────────────────────────────────────────────
    elBtnLihatAnggota.addEventListener('click', switchToAnggotaMode);
    elBtnKembali.addEventListener('click', switchToKomisariatMode);
    elSelectJurusan.addEventListener('change', () => {
        elDetailPanel.classList.add('hidden');
        renderAnggotaMarkers();
    });

    // ── BOOT ──────────────────────────────────────────────────────────────────
    initializeMap();
});
</script>