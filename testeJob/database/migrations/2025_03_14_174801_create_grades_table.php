<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->float('nota_1');
            $table->float('nota_2');
            $table->float('nota_3');
            $table->float('nota_4');
            $table->float('nota_prova_final');
            $table->float('nota_total');
            $table->float('media');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
