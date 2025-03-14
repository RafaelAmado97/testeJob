<?php
namespace App\Filament\Resources\GradesResource\Pages;

use App\Filament\Resources\GradesResource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GradesImport;
use Filament\Actions\ButtonAction;

class UploadGrades extends Page
{
    protected static string $resource = GradesResource::class;

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('spreadsheet')
                ->disk('public')
                ->directory('spreadsheets')
                ->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                ->maxSize(1024)
                ->required(),
        ];
    }

    public function processSpreadsheet(array $data)
    {
        // Processar a planilha e atualizar o banco de dados
        Excel::import(new GradesImport, $data['spreadsheet']);

        // Exibir mensagem de sucesso
        $this->notify('success', 'Planilha importada com sucesso e notas atualizadas.');
    }

    protected function getActions(): array
    {
        return [
            Actions\ButtonAction::make('upload')
                ->label('Upload Spreadsheet')
                ->action('processSpreadsheet')
                ->requiresConfirmation(),
        ];
    }
}
