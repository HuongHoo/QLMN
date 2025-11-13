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
        Schema::create('lophoc', function (Blueprint $table) {
            $table->id();
            $table->string('tenlop', 100)->nullable();
            $table->string('nhomtuoi', 50)->nullable();
            $table->integer('siso')->nullable();
            $table->string('sophong', 20)->nullable();
            $table->string('nienkhoa', 9)->nullable();
            $table->time('giobatdau')->default('07:00:00')->nullable();
            $table->time('gioketthuc')->default('14:30:00')->nullable();
            $table->string('ghichu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lophoc');
    }
};
