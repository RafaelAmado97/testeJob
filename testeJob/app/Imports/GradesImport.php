<?php
namespace App\Imports;

use App\Models\Grades;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GradesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Encontrar o aluno pelo nome e pelo professor
        $student = User::where('name', $row['student_name'])
            ->where('teacher_id', auth()->id())
            ->first();

        if (!$student) {
            return null;
        }

        // Calcular a nota total e a média
        $nota_total = $this->calculateTotal($row);
        $media = $this->calculateAverage($nota_total);

        // Encontrar ou criar a nota
        $grade = Grades::updateOrCreate(
            ['student_id' => $student->id],
            [
                'student_name' => $row['student_name'],
                'nota_1' => $row['nota_1'],
                'nota_2' => $row['nota_2'],
                'nota_3' => $row['nota_3'],
                'nota_4' => $row['nota_4'],
                'nota_prova_final' => $row['nota_prova_final'],
                'nota_total' => $nota_total,
                'media' => $media,
            ]
        );

        return $grade;
    }

    private function calculateTotal(array $row)
    {
        return $row['nota_1'] + $row['nota_2'] + $row['nota_3'] + $row['nota_4'] + ($row['nota_prova_final'] * 2);
    }

    private function calculateAverage($nota_total)
    {
        return $nota_total / 6;
    }
}
