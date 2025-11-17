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
        Schema::create('thongbao', function (Blueprint $table) {
            $table->id();
            $table->string('tieude')->nullable();
            $table->text('noidung')->nullable();
            $table->enum('loaithongbao', ['chung', 'khẩn cấp', 'sự kiện', 'nghỉ lễ'])->default('chung');
            $table->string('tepdinhkem')->nullable();
            $table->date('ngaytao')->nullable();
            $table->foreignId('magiaovien')->nullable()->constrained('giaovien')->onDelete('set null');

            $table->foreignId('malop')->nullable()->constrained('lophoc')->onDelete('set null');
            $table->enum('trangthai', ['chờ duyệt', 'đã duyệt','từ chối'])->default('chờ duyệt')->nullable();
              $table->date('ngaygui')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thongbao');
    }
};
