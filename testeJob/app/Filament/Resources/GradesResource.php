<?php
namespace App\Filament\Resources;

use App\Filament\Resources\GradesResource\Pages;
use App\Models\Grades;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;

class GradesResource extends Resource
{
    protected static ?string $model = Grades::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'teacher' || auth()->user()->role === 'admin' || auth()->user()->role === 'student';
    }

    public static function canCreate(): bool
    {
        return auth()->user()->role === 'teacher' || auth()->user()->role === 'admin';
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->role === 'teacher' || auth()->user()->role === 'admin';
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('student_id')
                    ->label('Student Name')
                    ->relationship('student', 'name')
                    ->options(User::where('teacher_id', auth()->id())->pluck('name', 'id'))
                    ->required(),
                TextInput::make('nota_1')
                    ->label('Nota 1')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => self::calculateGrades($state, $set)),
                TextInput::make('nota_2')
                    ->label('Nota 2')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => self::calculateGrades($state, $set)),
                TextInput::make('nota_3')
                    ->label('Nota 3')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => self::calculateGrades($state, $set)),
                TextInput::make('nota_4')
                    ->label('Nota 4')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => self::calculateGrades($state, $set)),
                TextInput::make('nota_prova_final')
                    ->label('Nota Prova Final')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => self::calculateGrades($state, $set)),
                TextInput::make('nota_total')
                    ->label('Nota Total')
                    ->numeric()
                    ->disabled(),
                TextInput::make('media')
                    ->label('Média')
                    ->numeric()
                    ->disabled(),
                FileUpload::make('spreadsheet')
                    ->label('Planilha de Notas')
                    ->disk('public')
                    ->directory('spreadsheets')
                    ->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->maxSize(1024)
                    ->required(),
            ]);
    }

    protected static function calculateGrades($state, callable $set)
    {
        $nota_1 = data_get($state, 'nota_1', 0);
        $nota_2 = data_get($state, 'nota_2', 0);
        $nota_3 = data_get($state, 'nota_3', 0);
        $nota_4 = data_get($state, 'nota_4', 0);
        $nota_prova_final = data_get($state, 'nota_prova_final', 0);

        $nota_total = $nota_1 + $nota_2 + $nota_3 + $nota_4 + ($nota_prova_final * 2);
        $media = $nota_total / 6;

        $set('nota_total', $nota_total);
        $set('media', $media);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')->label('Student Name'),
                TextColumn::make('nota_1')->label('Nota 1'),
                TextColumn::make('nota_2')->label('Nota 2'),
                TextColumn::make('nota_3')->label('Nota 3'),
                TextColumn::make('nota_4')->label('Nota 4'),
                TextColumn::make('nota_prova_final')->label('Nota Prova Final'),
                TextColumn::make('nota_total')->label('Nota Total'),
                TextColumn::make('media')->label('Média'),
            ])
            ->filters([
                //
            ])
            ->actions([
                DeleteAction::make()
                    ->visible(fn($record) => auth()->user()->role === 'admin'), // Apenas admin pode excluir
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrades::route('/create'),
            'edit' => Pages\EditGrades::route('/{record}/edit'),
            'upload' => Pages\UploadGrades::route('/upload'), // <- Adicione essa linha
        ];
    }
}
