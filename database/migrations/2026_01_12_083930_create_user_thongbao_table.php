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
        Schema::create('user_thongbao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('thongbao_id')->constrained('thongbao')->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            // Unique constraint để tránh trùng lặp
            $table->unique(['user_id', 'thongbao_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_thongbao');
    }
};
