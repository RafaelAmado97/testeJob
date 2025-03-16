<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\BoardResource;
use Filament\Facades\Filament;
use App\Http\Controllers\RegistrationController;
use App\Filament\Resources\TeacherDashboard;
use App\Filament\Resources\Dashboard;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register']);

Route::get('/dashboard', Dashboard::class)->name('dashboard');

Filament::registerResources([
    BoardResource::class,
]);
