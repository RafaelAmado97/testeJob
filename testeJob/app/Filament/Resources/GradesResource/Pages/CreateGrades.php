<?php

namespace App\Filament\Resources\GradesResource\Pages;

use App\Filament\Resources\GradesResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GradesImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class CreateGrades extends CreateRecord
{
    protected static string $resource = GradesResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['student_id']) && empty($data['nota_1']) && empty($data['nota_2']) && empty($data['nota_3']) && empty($data['nota_4']) && empty($data['nota_prova_final']) && empty($data['spreadsheet'])) {
            Notification::make()
                ->title('Erro')
                ->body('Por favor, preencha pelo menos um campo ou faça o upload de uma planilha.')
                ->danger()
                ->send();
            throw new \Exception('Validation failed');
        }

        if (!empty($data['spreadsheet'])) {
            $teacherId = auth()->user()->id;

            // Recuperar o caminho do arquivo salvo pelo Filament
            $filePath = Storage::disk('public')->path($data['spreadsheet']);
            $file = new UploadedFile($filePath, basename($filePath));

            $extension = $file->getClientOriginalExtension();

            if (!in_array($extension, ['xls', 'xlsx', 'xlsm'])) {
                Notification::make()
                    ->title('Erro')
                    ->body('Formato de arquivo inválido. Apenas arquivos Excel (.xls, .xlsx, .xlsm) são permitidos.')
                    ->danger()
                    ->send();
                throw new \Exception('Invalid file format');
            }

            // Importando os dados da planilha
            $import = new GradesImport($teacherId);
            Excel::import($import, $filePath);

            $updatedCount = $import->getUpdatedCount();


            Notification::make()
                ->title('Sucesso')
                ->body("$updatedCount alunos atualizados.")
                ->success()
                ->send();

            $data = []; // Limpar os dados do formulário, pois a planilha foi processada
        }

        return $data;
    }
}
