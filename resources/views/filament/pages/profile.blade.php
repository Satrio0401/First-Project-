<x-filament::page>
    @if ($isEditing)
        <form wire:submit.prevent="save">
            {{ $this->form }}
            <div class="flex justify-start gap-x-3" style="margin-top: 1rem">
                @foreach ($this->getFormActions() as $action)
                    {{ $action }}
                @endforeach
            </div>
        </form>
    @else
        <div class="flex justify-end">
            {{ $this->editAction }}
        </div>
        {{ $this->infolist }}
    @endif
</x-filament::page>
