<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * activity_logs — 操作ログ（監査）（仕様に準拠）
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('target_type', ['MEMBER', 'EVENT']);
            $table->unsignedBigInteger('target_id')->nullable();
            $table->enum('action', ['CREATE', 'UPDATE', 'DELETE']);
            $table->json('changed_fields')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('created_at');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
