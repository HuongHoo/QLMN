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
        // Bảng hoạt động của trường (gallery công khai)
        Schema::create('hoatdong', function (Blueprint $table) {
            $table->id();
            $table->string('tieude'); // Tiêu đề hoạt động
            $table->text('mota')->nullable(); // Mô tả
            $table->string('anh'); // Đường dẫn ảnh
            $table->enum('loai', ['hoctap', 'vuichoi', 'sukien', 'khac'])->default('khac'); // Loại hoạt động
            $table->unsignedBigInteger('lophoc_id')->nullable(); // Thuộc lớp nào (null = toàn trường)
            $table->date('ngay')->nullable(); // Ngày diễn ra
            $table->boolean('hienthi')->default(true); // Có hiển thị không
            $table->integer('thutu')->default(0); // Thứ tự hiển thị
            $table->timestamps();

            $table->foreign('lophoc_id')->references('id')->on('lophoc')->onDelete('set null');
        });

        // Bảng hoạt động hàng ngày của bé (timeline)
        Schema::create('hoatdong_hangngay', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hocsinh_id')->nullable(); // Học sinh cụ thể (null = cả lớp)
            $table->unsignedBigInteger('lophoc_id'); // Thuộc lớp nào
            $table->unsignedBigInteger('giaovien_id'); // Giáo viên đăng
            $table->string('tieude'); // Tiêu đề hoạt động
            $table->text('mota')->nullable(); // Mô tả
            $table->enum('loai', ['gioian', 'hoctap', 'ngoaitroi', 'nghingoi', 'khac'])->default('khac');
            $table->time('giobatdau')->nullable(); // Giờ bắt đầu
            $table->time('gioketthuc')->nullable(); // Giờ kết thúc
            $table->date('ngay'); // Ngày
            $table->timestamps();

            $table->foreign('hocsinh_id')->references('id')->on('hocsinh')->onDelete('cascade');
            $table->foreign('lophoc_id')->references('id')->on('lophoc')->onDelete('cascade');
            $table->foreign('giaovien_id')->references('id')->on('giaovien')->onDelete('cascade');
        });

        // Bảng ảnh hoạt động hàng ngày (mỗi hoạt động có nhiều ảnh)
        Schema::create('anh_hoatdong', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hoatdong_hangngay_id');
            $table->string('anh'); // Đường dẫn ảnh
            $table->string('mota')->nullable(); // Mô tả ảnh
            $table->timestamps();

            $table->foreign('hoatdong_hangngay_id')->references('id')->on('hoatdong_hangngay')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anh_hoatdong');
        Schema::dropIfExists('hoatdong_hangngay');
        Schema::dropIfExists('hoatdong');
    }
};
