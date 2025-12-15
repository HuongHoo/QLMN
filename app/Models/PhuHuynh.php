<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhuHuynh extends Model
{
    protected $table = 'phuhuynh';
    protected $primaryKey = 'id';
    protected $fillable = [
        'hoten',
        'quanhe',
        'sdt',
        'email',
        'diachithuongtru',
        'diachitamtru',
        'nghenghiep',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Lấy danh sách học sinh của phụ huynh
     */
    public function hocsinhs()
    {
        return $this->hasMany(HocSinh::class, 'maphuhuynh');
    }

    /**
     * Lấy các cuộc trò chuyện của phụ huynh
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'phuhuynh_id');
    }

    /**
     * Lấy tin nhắn đã gửi
     */
    public function sentMessages()
    {
        return Message::where('sender_id', $this->id)
            ->where('sender_type', 'phuhuynh');
    }

    /**
     * Lấy tin nhắn đã nhận
     */
    public function receivedMessages()
    {
        return Message::where('receiver_id', $this->id)
            ->where('receiver_type', 'phuhuynh');
    }

    /**
     * Đếm tin nhắn chưa đọc
     */
    public function unreadMessagesCount()
    {
        return Message::where('receiver_id', $this->id)
            ->where('receiver_type', 'phuhuynh')
            ->where('is_read', false)
            ->count();
    }
}
