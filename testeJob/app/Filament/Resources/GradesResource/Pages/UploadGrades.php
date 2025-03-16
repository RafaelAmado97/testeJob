<?php

namespace App\Filament\Resources\GradesResource\Pages;

use App\Filament\Resources\GradesResource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GradesImport;
use Illuminate\Support\Facades\Storage;

class UploadGrades extends Page
{
    protected static string $resource = GradesResource::class;

    protected static string $view = 'filament.resources.grades-resource.pages.upload-grades';

    public $spreadsheet;

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('spreadsheet')
                ->label('Planilha de Notas')
                ->disk('public')
                ->directory('spreadsheets')
                ->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                ->maxSize(1024)
                ->required(),
        ];
    }

    public function upload()
    {
        $this->validate([
            'spreadsheet' => 'required|file|mimes:xlsx,xls|max:1024',
        ]);

        $teacherId = auth()->user()->id;
        $import = new GradesImport($teacherId);
        Excel::import($import, $this->spreadsheet->getRealPath());

        $updatedCount = $import->getUpdatedCount();
        $newCount = $import->getNewCount();

        $this->notify('success', "$newCount novos alunos importados e $updatedCount alunos atualizados.");

        $this->spreadsheet = null;
    }
}
