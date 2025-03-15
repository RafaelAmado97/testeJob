<x-filament::page>
    <form wire:submit.prevent="upload">
        {{ $form }}
        <x-filament::button type="submit">
            Upload Planilha
        </x-filament::button>
    </form>
</x-filament::page>
