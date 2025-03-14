<?php
namespace App\Filament\Resources\GradesResource\Pages;

use App\Filament\Resources\GradesResource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ViewGrades extends Page
{
    protected static string $resource = GradesResource::class;

    protected static string $view = 'filament.resources.grade-resource.pages.view-grades';

    public function mount()
    {
        $this->record = Auth::user()->grades;
    }
}
