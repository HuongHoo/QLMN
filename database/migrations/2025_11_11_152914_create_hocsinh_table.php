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
        Schema::create('hocsinh', function (Blueprint $table) {
            $table->id();
            $table->string('mathe', 20)->unique()->nullable();
            $table->string('tenhocsinh', 100)->nullable();
            $table->date('ngaysinh')->nullable();
            $table->enum('gioitinh', ['nam', 'nữ'])->nullable();
            $table->string('diachithuongtru', 300)->nullable();
            $table->string('diachitamtru', 300)->nullable();
            $table->foreignId('malop')->nullable()->constrained('lophoc')->onDelete('set null');
            $table->foreignId('maphuhuynh')->nullable()->constrained('phuhuynh')->onDelete('set null');
            $table->date('ngaynhaphoc')->nullable();
            $table->enum('trangthai', ['đang học', 'nghỉ học'])->default('đang học')->nullable();
            $table->string('anh')->nullable();
            $table->text('ghichusuckhoe')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hocsinh');
    }
};
