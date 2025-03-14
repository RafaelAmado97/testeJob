<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['student', 'teacher', 'admin'])->default('student');
            $table->unsignedBigInteger('teacher_id')->nullable(); // ID do professor responsável pelo aluno
            $table->unsignedBigInteger('board_id')->nullable(); // ID da diretoria para professores
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('set null');
        });

        // Excluímos as tabelas antigas, já que tudo agora é tratado em `users`
        Schema::dropIfExists('students');
        Schema::dropIfExists('teachers');
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
?>
