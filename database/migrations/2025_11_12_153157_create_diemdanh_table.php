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
        Schema::create('diemdanh', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahocsinh')->nullable()->constrained('hocsinh')->onDelete('set null');
            $table->date('ngaydiemdanh')->nullable();
            $table->enum('trangthai', ['có mặt', 'vắng mặt', 'nghỉ phép', 'trễ'])->nullable();
            $table->time('gioden')->nullable();
            $table->time('giove')->nullable();
            $table->string('lydo')->nullable();
            $table->integer('sophuttre')->nullable();
            $table->string('tepdinhkem')->nullable();
            $table->decimal('nhietdo', 3, 1)->nullable();
            $table->foreignId('magiaovien')->nullable()->constrained('giaovien')->onDelete('set null');
            $table->text('ghichu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diemdanh');
    }
};
