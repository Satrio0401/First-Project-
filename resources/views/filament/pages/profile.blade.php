<x-filament::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}
        <div style="margin-top: 16px">
            <x-filament::button type="submit">
                Simpan
            </x-filament::button>
        </div>
    </form>
</x-filament::page>