<x-filament-panels::page>
    <h2 class="text-xl font-bold tracking-tight">
        Membuat User untuk: {{ $record->nama }}
    </h2>

<form wire:submit="create" class="mt-6">
        {{-- Render semua komponen form yang sudah didefinisikan di class PHP --}}
        {{ $this->form }}

        {{-- Tombol untuk submit form --}}
        <div style="margin-top: 1.5rem">
            <x-filament::button type="submit">
                Buat User
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
