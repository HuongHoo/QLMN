<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiaoVien extends Model
{
    protected $table = 'giaovien';
    protected $fillable = [
        'sothe',
        'tengiaovien',
        'ngaysinh',
        'gioitinh',
        'sdt',
        'email',
        'diachithuongtru',
        'diachitamtru',
        'chucvu',
        'malopchunhiem',
        'cccd',
        'ngayvaolam',
        'trangthai',
        'anh',
        'user_id',
    ];
    public function lophoc()
    {
        return $this->belongsTo(LopHoc::class, 'malopchunhiem', 'id');
        // 'malopchunhiem' là FK trong giaovien
        // 'id' là PK trong lophoc
    }
    // app/Models/GiaoVien.php
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Lấy các cuộc trò chuyện của giáo viên
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'giaovien_id');
    }

    /**
     * Lấy tin nhắn đã gửi
     */
    public function sentMessages()
    {
        return Message::where('sender_id', $this->id)
            ->where('sender_type', 'giaovien');
    }

    /**
     * Lấy tin nhắn đã nhận
     */
    public function receivedMessages()
    {
        return Message::where('receiver_id', $this->id)
            ->where('receiver_type', 'giaovien');
    }

    /**
     * Đếm tin nhắn chưa đọc
     */
    public function unreadMessagesCount()
    {
        return Message::where('receiver_id', $this->id)
            ->where('receiver_type', 'giaovien')
            ->where('is_read', false)
            ->count();
    }
}
