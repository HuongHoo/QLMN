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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id'); // ID người gửi
            $table->string('sender_type'); // 'giaovien' hoặc 'phuhuynh'
            $table->unsignedBigInteger('receiver_id'); // ID người nhận
            $table->string('receiver_type'); // 'giaovien' hoặc 'phuhuynh'
            $table->text('message'); // Nội dung tin nhắn
            $table->boolean('is_read')->default(false); // Đã đọc chưa
            $table->timestamp('read_at')->nullable(); // Thời gian đọc
            $table->timestamps();

            // Indexes để tối ưu truy vấn
            $table->index(['sender_id', 'sender_type']);
            $table->index(['receiver_id', 'receiver_type']);
            $table->index('is_read');
            $table->index('created_at');
        });

        // Bảng conversations để lưu các cuộc trò chuyện
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('giaovien_id');
            $table->unsignedBigInteger('phuhuynh_id');
            $table->unsignedBigInteger('last_message_id')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->unique(['giaovien_id', 'phuhuynh_id']);
            $table->index('last_message_at');

            $table->foreign('giaovien_id')->references('id')->on('giaovien')->onDelete('cascade');
            $table->foreign('phuhuynh_id')->references('id')->on('phuhuynh')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('messages');
    }
};
