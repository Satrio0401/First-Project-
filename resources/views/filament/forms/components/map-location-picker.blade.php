<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        {{-- Inisialisasi Alpine.js dengan data dari Filament --}}
        x-data="mapLocationPicker({

            {{-- Ini adalah 'jembatan' ajaib antara JavaScript dan Livewire (Filament) --}}
            state: $wire.entangle('{{ $getStatePath() }}'),

            {{-- Ambil latitude & longitude awal (untuk form edit), atau set default (Pontianak) --}}
            lat: {{ $getState()['lat'] ?? -0.0275 }},
            lng: {{ $getState()['lng'] ?? 109.3425 }}
        })"

        {{-- Panggil fungsi initMap() saat komponen siap --}}
        x-init="initMap()"

        {{-- SANGAT PENTING: Mencegah Livewire merusak peta saat ada update --}}
        wire:ignore
    >
        <div x-ref="map" class="w-full rounded-md" style="height: 400px;"></div>
    </div>
</x-dynamic-component>

{{-- Gunakan @once agar skrip Google Maps hanya dimuat satu kali per halaman --}}
@once
    @push('scripts')
        {{-- Muat Google Maps API dengan API Key Anda dan tentukan fungsi callback --}}
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMapPicker&libraries=places&v=weekly" async></script>
    @endpush
@endonce