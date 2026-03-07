<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // 名前（例：田中 花子）
            $table->string('department');       // 学部（例：情報学部）
            $table->integer('grade');            // 学年（例：2）
            $table->string('status')->default('join'); // 状態（join:加入, update:情報更新）
            $table->string('avatar_color')->nullable(); // アイコンの色（例：bg-blue-500）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
