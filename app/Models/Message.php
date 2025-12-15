<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'message',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Lấy người gửi (giáo viên hoặc phụ huynh)
     */
    public function sender()
    {
        if ($this->sender_type === 'giaovien') {
            return $this->belongsTo(GiaoVien::class, 'sender_id');
        }
        return $this->belongsTo(PhuHuynh::class, 'sender_id');
    }

    /**
     * Lấy người nhận (giáo viên hoặc phụ huynh)
     */
    public function receiver()
    {
        if ($this->receiver_type === 'giaovien') {
            return $this->belongsTo(GiaoVien::class, 'receiver_id');
        }
        return $this->belongsTo(PhuHuynh::class, 'receiver_id');
    }

    /**
     * Lấy thông tin giáo viên gửi
     */
    public function senderGiaoVien()
    {
        return $this->belongsTo(GiaoVien::class, 'sender_id');
    }

    /**
     * Lấy thông tin phụ huynh gửi
     */
    public function senderPhuHuynh()
    {
        return $this->belongsTo(PhuHuynh::class, 'sender_id');
    }

    /**
     * Lấy thông tin giáo viên nhận
     */
    public function receiverGiaoVien()
    {
        return $this->belongsTo(GiaoVien::class, 'receiver_id');
    }

    /**
     * Lấy thông tin phụ huynh nhận
     */
    public function receiverPhuHuynh()
    {
        return $this->belongsTo(PhuHuynh::class, 'receiver_id');
    }

    /**
     * Đánh dấu tin nhắn đã đọc
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Scope: Lấy tin nhắn chưa đọc
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: Lấy tin nhắn giữa giáo viên và phụ huynh
     */
    public function scopeBetween($query, $giaoVienId, $phuHuynhId)
    {
        return $query->where(function ($q) use ($giaoVienId, $phuHuynhId) {
            $q->where(function ($q1) use ($giaoVienId, $phuHuynhId) {
                $q1->where('sender_id', $giaoVienId)
                    ->where('sender_type', 'giaovien')
                    ->where('receiver_id', $phuHuynhId)
                    ->where('receiver_type', 'phuhuynh');
            })->orWhere(function ($q2) use ($giaoVienId, $phuHuynhId) {
                $q2->where('sender_id', $phuHuynhId)
                    ->where('sender_type', 'phuhuynh')
                    ->where('receiver_id', $giaoVienId)
                    ->where('receiver_type', 'giaovien');
            });
        });
    }

    /**
     * Lấy tên người gửi
     */
    public function getSenderNameAttribute()
    {
        if ($this->sender_type === 'giaovien') {
            $gv = GiaoVien::find($this->sender_id);
            return $gv ? $gv->tengiaovien : 'Giáo viên';
        }
        $ph = PhuHuynh::find($this->sender_id);
        return $ph ? $ph->hoten : 'Phụ huynh';
    }

    /**
     * Lấy tên người nhận
     */
    public function getReceiverNameAttribute()
    {
        if ($this->receiver_type === 'giaovien') {
            $gv = GiaoVien::find($this->receiver_id);
            return $gv ? $gv->tengiaovien : 'Giáo viên';
        }
        $ph = PhuHuynh::find($this->receiver_id);
        return $ph ? $ph->hoten : 'Phụ huynh';
    }
}
