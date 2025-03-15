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
    private $newCount = 0;

    public function __construct($teacherId)
    {
        $this->teacherId = $teacherId;
    }

    public function model(array $row)
    {
        $student = User::firstOrCreate(
            ['id' => $row['student_id']],
            ['name' => $row['student_name']]
        );

        $grade = Grades::updateOrCreate(
            ['student_id' => $student->id, 'teacher_id' => $this->teacherId],
            [
                'nota_1' => $row['nota_1'],
                'nota_2' => $row['nota_2'],
                'nota_3' => $row['nota_3'],
                'nota_4' => $row['nota_4'],
                'nota_prova_final' => $row['nota_prova_final'],
            ]
        );

        if ($grade->wasRecentlyCreated) {
            $this->newCount++;
        } else {
            $this->updatedCount++;
        }

        return $grade;
    }

    public function getUpdatedCount()
    {
        return $this->updatedCount;
    }

    public function getNewCount()
    {
        return $this->newCount;
    }
}
