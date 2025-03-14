<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            if (!Schema::hasColumn('grades', 'student_id')) {
                $table->foreignId('student_id')->constrained('users')->after('id');
            }
            if (!Schema::hasColumn('grades', 'student_name')) {
                $table->string('student_name')->after('student_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            if (Schema::hasColumn('grades', 'student_id')) {
                $table->dropForeign(['student_id']);
                $table->dropColumn('student_id');
            }
            if (Schema::hasColumn('grades', 'student_name')) {
                $table->dropColumn('student_name');
            }
        });
    }
};
