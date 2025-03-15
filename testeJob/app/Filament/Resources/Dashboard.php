<?php

namespace App\Filament\Resources;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\TeacherDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $view = 'filament.resources.dashboard';

    public function getWidgets(): array
    {
        return [
            TeacherDashboard::class,
        ];
    }
}
