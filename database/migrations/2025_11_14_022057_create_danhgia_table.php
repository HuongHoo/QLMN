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
        Schema::create('danhgia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahocsinh')->nullable()->constrained('hocsinh')->onDelete('set null');
            $table->foreignId('magiaovien')->nullable()->constrained('giaovien')->onDelete('set null');
            $table->date('nam')->nullable();
            $table->date('thang')->nullable();
            $table->integer('thechat')->nullable();
            $table->integer('ngonngu')->nullable();
            $table->integer('nhanthuc')->nullable();
            $table->integer('camxucxahoi')->nullable();
            $table->integer('nghethuat')->nullable();
            $table->text('nhanxetchung')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danhgia');
    }
};
