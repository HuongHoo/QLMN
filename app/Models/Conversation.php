<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';

    protected $fillable = [
        'giaovien_id',
        'phuhuynh_id',
        'last_message_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Quan hệ với giáo viên
     */
    public function giaoVien()
    {
        return $this->belongsTo(GiaoVien::class, 'giaovien_id');
    }

    /**
     * Quan hệ với phụ huynh
     */
    public function phuHuynh()
    {
        return $this->belongsTo(PhuHuynh::class, 'phuhuynh_id');
    }

    /**
     * Lấy tin nhắn cuối cùng
     */
    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    /**
     * Lấy tất cả tin nhắn trong cuộc trò chuyện
     */
    public function messages()
    {
        return Message::between($this->giaovien_id, $this->phuhuynh_id)
            ->orderBy('created_at', 'asc');
    }

    /**
     * Đếm tin nhắn chưa đọc của giáo viên (tin từ phụ huynh gửi)
     */
    public function unreadCountForTeacher()
    {
        return Message::where('sender_id', $this->phuhuynh_id)
            ->where('sender_type', 'phuhuynh')
            ->where('receiver_id', $this->giaovien_id)
            ->where('receiver_type', 'giaovien')
            ->where('is_read', false)
            ->count();
    }

    /**
     * Đếm tin nhắn chưa đọc của phụ huynh (tin từ giáo viên gửi)
     */
    public function unreadCountForParent()
    {
        return Message::where('sender_id', $this->giaovien_id)
            ->where('sender_type', 'giaovien')
            ->where('receiver_id', $this->phuhuynh_id)
            ->where('receiver_type', 'phuhuynh')
            ->where('is_read', false)
            ->count();
    }

    /**
     * Tìm hoặc tạo conversation
     */
    public static function findOrCreateConversation($giaoVienId, $phuHuynhId)
    {
        return self::firstOrCreate(
            [
                'giaovien_id' => $giaoVienId,
                'phuhuynh_id' => $phuHuynhId,
            ]
        );
    }

    /**
     * Cập nhật tin nhắn cuối cùng
     */
    public function updateLastMessage($messageId)
    {
        $this->update([
            'last_message_id' => $messageId,
            'last_message_at' => now(),
        ]);
    }

    /**
     * Scope: Lấy cuộc trò chuyện của giáo viên
     */
    public function scopeForTeacher($query, $giaoVienId)
    {
        return $query->where('giaovien_id', $giaoVienId)
            ->orderBy('last_message_at', 'desc');
    }

    /**
     * Scope: Lấy cuộc trò chuyện của phụ huynh
     */
    public function scopeForParent($query, $phuHuynhId)
    {
        return $query->where('phuhuynh_id', $phuHuynhId)
            ->orderBy('last_message_at', 'desc');
    }
}
