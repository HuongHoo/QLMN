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
        Schema::create('suckhoe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahocsinh')->nullable()->constrained('hocsinh')->onDelete('set null');
            $table->date('ngaykham')->nullable();
            $table->decimal('chieucao', 5, 2)->nullable();
            $table->decimal('cannang', 5, 2)->nullable();
            $table->text('tinhtrang')->nullable();
            $table->text('ghichu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suckhoe');
    }
};
