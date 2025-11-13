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
        Schema::create('phuhuynh', function (Blueprint $table) {
            $table->id();
            $table->string('hoten')->nullable();
            $table->enum('quanhe', ['cha', 'mẹ', 'ông', 'bà', 'người giám hộ'])->nullable();
            $table->string('sdt')->nullable();
            $table->string('email')->nullable();
            $table->string('diachithuongtru')->nullable();
            $table->string('diachitamtru')->nullable();
            $table->string('nghenghiep')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phuhuynh');
    }
};
