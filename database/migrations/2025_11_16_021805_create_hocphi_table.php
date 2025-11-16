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
        Schema::create('hocphi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahocsinh')->nullable()->constrained('hocsinh')->onDelete('set null');
            $table->date('thoigiandong')->nullable();
            $table->decimal('hocphi', 15, 2)->nullable();
            $table->decimal('tienansang', 15, 2)->nullable();
            $table->decimal('tienantrua', 15, 2)->nullable();
            $table->decimal('tienxebus', 15, 2)->nullable();
            $table->decimal('phikhac', 15, 2)->nullable();
            $table->decimal('tongtien', 15, 2)->nullable();
            $table->date('ngaythanhtoan')->nullable();
            $table->decimal('dathanhtoan', 15, 2)->nullable();
            $table->foreignId('magiaovien')->nullable()->constrained('giaovien')->onDelete('set null');
            $table->string('ghichu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hocphi');
    }
};
