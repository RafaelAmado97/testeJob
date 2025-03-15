<x-filament::layouts.base>
    <x-filament::app-header />

    <div class="filament-main">
        <div class="filament-main-content">
            {{ \Filament\Facades\Filament::renderHook('content.start') }}

            {{ $slot }}

            {{ \Filament\Facades\Filament::renderHook('content.end') }}
        </div>
    </div>

    <x-filament::app-footer />
</x-filament::layouts.base>
