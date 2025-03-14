<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['student', 'teacher', 'admin'])->default('student')->after('password');
            $table->unsignedBigInteger('teacher_id')->nullable()->after('role'); // ID do professor responsável pelo aluno
            $table->unsignedBigInteger('board_id')->nullable()->after('teacher_id'); // ID da diretoria para professores

            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('set null');
        });

        // Excluímos as tabelas antigas, já que tudo agora é tratado em `users`
        Schema::dropIfExists('students');
        Schema::dropIfExists('teachers');
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['board_id']);
            $table->dropColumn(['role', 'teacher_id', 'board_id']);
        });

        // Recriar as tabelas antigas se necessário
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('board_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('set null');
        });
    }
};
