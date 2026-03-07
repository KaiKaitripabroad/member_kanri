<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * members を仕様（サークルメンバー情報・論理削除あり）に合わせて変更
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->string('email', 255)->nullable()->after('grade');
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('role', 50)->nullable()->after('phone');
            $table->date('joined_at')->nullable()->after('role');
            $table->text('notes')->nullable()->after('joined_at');
            $table->timestamp('deleted_at')->nullable()->after('updated_at');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['status', 'avatar_color']);
        });

        Schema::table('members', function (Blueprint $table) {
            $table->unique('user_id');
            $table->index('grade');
            $table->index('department');
            $table->index('deleted_at');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id']);
            $table->dropIndex(['grade']);
            $table->dropIndex(['department']);
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'email', 'phone', 'role', 'joined_at', 'notes', 'deleted_at']);
            $table->string('status')->default('join');
            $table->string('avatar_color')->nullable();
        });
    }
};
