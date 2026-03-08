<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->nullable()->after('gender');
            $table->string('student_number', 50)->nullable()->after('role');
            $table->text('notes')->nullable()->after('student_number');
            $table->string('department', 100)->nullable()->after('notes');
            $table->unsignedTinyInteger('grade')->nullable()->after('department');
            $table->date('joined_at')->nullable()->after('grade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'student_number', 'notes', 'department', 'grade', 'joined_at']);
        });
    }
};
