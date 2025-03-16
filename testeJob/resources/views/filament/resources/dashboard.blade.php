
@extends('filament::page')

@section('content')
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        @foreach ($widgets as $widget)
            @livewire($widget)
        @endforeach
    </div>
@endsection
