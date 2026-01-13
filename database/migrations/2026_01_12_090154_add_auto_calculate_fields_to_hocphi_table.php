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
        Schema::table('hocphi', function (Blueprint $table) {
            // Thêm các trường để tính tiền ăn tự động theo điểm danh
            $table->decimal('gia_tien_an_ngay', 15, 2)->nullable()->after('tienxebus')->comment('Đơn giá tiền ăn/ngày (có thể điều chỉnh)');
            $table->integer('so_ngay_di_hoc')->nullable()->after('gia_tien_an_ngay')->comment('Số ngày đi học thực tế (từ điểm danh)');
            $table->date('tu_ngay')->nullable()->after('thoigiandong')->comment('Tính từ ngày');
            $table->date('den_ngay')->nullable()->after('tu_ngay')->comment('Tính đến ngày');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hocphi', function (Blueprint $table) {
            $table->dropColumn(['gia_tien_an_ngay', 'so_ngay_di_hoc', 'tu_ngay', 'den_ngay']);
        });
    }
};
