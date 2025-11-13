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
        Schema::create('giaovien', function (Blueprint $table) {
            $table->id();
            $table->string('sothe')->unique()->nullable();
            $table->string('tengiaovien')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->enum('gioitinh', ['nam', 'nữ', 'khác'])->nullable();
            $table->string('sdt')->nullable();
            $table->string('email')->nullable();
            $table->string('diachithuongtru')->nullable();
            $table->string('diachitamtru')->nullable();
            $table->enum('chucvu', ['giáo viên', 'hiệu trưởng', 'hiệu phó'])->nullable();
            $table->foreignId('malopchunhiem')->nullable()->constrained('lophoc')->onDelete('set null');

            $table->string('cccd')->nullable();
            $table->date('ngayvaolam')->nullable();
            $table->string('trangthai')->nullable();
            $table->string('anh')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giaovien');
    }
};
