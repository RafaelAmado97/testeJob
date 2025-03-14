<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\BoardResource;
use Filament\Facades\Filament;
use App\Http\Controllers\RegistrationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register']);

Filament::registerResources([
    BoardResource::class,
]);
