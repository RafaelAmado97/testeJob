<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class TeacherDashboard extends Widget
{
    protected static string $view = 'filament.widgets.teacher-dashboard';

    public function getData()
    {
        $teacherId = auth()->user()->id;

        // Gráfico de Pizza: Percentual de alunos aprovados e reprovados
        $approved = DB::table('grades')
            ->where('teacher_id', $teacherId)
            ->where('media', '>=', 7)
            ->count();

        $total = DB::table('grades')
            ->where('teacher_id', $teacherId)
            ->count();

        $reproved = $total - $approved;

        // Gráfico de Barras: Média geral dos alunos por professor
        $averageGrades = DB::table('grades')
            ->select(DB::raw('AVG(media) as average, teacher_id'))
            ->groupBy('teacher_id')
            ->get();

        // Gráfico de Barras Avançado: Número de alunos por professor com linha indicando % de aprovados
        $studentsPerTeacher = DB::table('grades')
            ->select(DB::raw('COUNT(*) as total, teacher_id'))
            ->groupBy('teacher_id')
            ->get();

        $approvedPerTeacher = DB::table('grades')
            ->select(DB::raw('COUNT(*) as approved, teacher_id'))
            ->where('media', '>=', 7)
            ->groupBy('teacher_id')
            ->get();

        return [
            'approved' => $approved,
            'reproved' => $reproved,
            'averageGrades' => $averageGrades,
            'studentsPerTeacher' => $studentsPerTeacher,
            'approvedPerTeacher' => $approvedPerTeacher,
        ];
    }
}
