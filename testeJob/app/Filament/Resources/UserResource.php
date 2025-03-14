<?php
namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\DeleteAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canCreate(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state)), // Criptografar a senha
                Select::make('role')
                    ->options([
                        'student' => 'Student',
                        'teacher' => 'Teacher',
                        'admin' => 'Admin',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => $set('teacher_id', null) && $set('board_id', null)),
                Select::make('teacher_id')
                    ->label('Professor')
                    ->options(
                        fn() => User::where('role', 'teacher')->pluck('name', 'id')
                    )
                    ->searchable()
                    ->nullable()
                    ->visible(fn($get) => $get('role') === 'student'),
                Select::make('board_id')
                    ->label('Board')
                    ->relationship('board', 'name')
                    ->nullable()
                    ->visible(fn($get) => $get('role') === 'teacher'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('role')->label('Role'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
