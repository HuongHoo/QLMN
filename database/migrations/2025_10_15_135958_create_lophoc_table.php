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
            $table->string('tenlop', 100);
            $table->string('nhomtuoi', 50);
            $table->integer('siso');
            $table->string('sophong', 20);
            $table->string('nienkhoa', 9); 
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
