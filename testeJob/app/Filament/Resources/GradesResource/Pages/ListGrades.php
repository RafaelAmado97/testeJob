<?php
namespace App\Filament\Resources\GradesResource\Pages;

use App\Filament\Resources\GradesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;

class ListGrades extends ListRecords
{
    protected static string $resource = GradesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn() => auth()->user()->role === 'teacher' || auth()->user()->role === 'admin'),
            Actions\Action::make('downloadTemplate')
                ->label('Download Template')
                ->action(fn() => Storage::disk('public')->download('templates/grade_template.xlsx'))
                ->visible(fn() => auth()->user()->role === 'teacher' || auth()->user()->role === 'admin'),
        ];
    }
}
