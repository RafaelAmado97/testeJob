<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grades extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'student_name',
        'nota_1',
        'nota_2',
        'nota_3',
        'nota_4',
        'nota_prova_final',
        'nota_total',
        'media',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    protected static function booted()
    {
        static::saving(function ($grade) {
            if ($grade->student) {
                $grade->student_name = $grade->student->name;
            }
            $grade->nota_1 = $grade->nota_1 ?? 0;
            $grade->nota_2 = $grade->nota_2 ?? 0;
            $grade->nota_3 = $grade->nota_3 ?? 0;
            $grade->nota_4 = $grade->nota_4 ?? 0;
            $grade->nota_prova_final = $grade->nota_prova_final ?? 0;
            $grade->nota_total = $grade->nota_1 + $grade->nota_2 + $grade->nota_3 + $grade->nota_4 + ($grade->nota_prova_final * 2);
            $grade->media = $grade->nota_total / 6;
        });
    }
}
