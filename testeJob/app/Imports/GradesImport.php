<?php

namespace App\Imports;

use App\Models\Grades;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GradesImport implements ToModel, WithHeadingRow
{
    private $teacherId;
    private $updatedCount = 0;
    private $ignoredCount = 0;

    public function __construct($teacherId)
    {
        $this->teacherId = $teacherId;
    }

    public function model(array $row)
    {
        $student = User::where('name', $row['student_name'])->first();

        // Se o aluno não existir, ignora a linha
        if (!$student) {
            $this->ignoredCount++;
            return null;
        }

        $grade = Grades::updateOrCreate(
            ['student_id' => $student->id, 'teacher_id' => $this->teacherId],
            [
                'nota_1' => $row['nota_1'] ?? 0,
                'nota_2' => $row['nota_2'] ?? 0,
                'nota_3' => $row['nota_3'] ?? 0,
                'nota_4' => $row['nota_4'] ?? 0,
                'nota_prova_final' => $row['nota_prova_final'] ?? 0,
            ]
        );

        // Contabiliza quantas notas foram atualizadas
        $this->updatedCount++;

        return $grade;
    }


    public function getUpdatedCount()
    {
        return $this->updatedCount;
    }

    public function getIgnoredCount()
    {
        return $this->ignoredCount;
    }
}
