<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    protected $table = 'thongbao';

    protected $fillable = [
        'tieude',
        'noidung',
        'loaithongbao',
        'tepdinhkem',
        'ngaytao',
        'user_id',
        'magiaovien',
        'malop',
        'trangthai',
        'ngaygui',
        'lydotuchoi',
    ];

    protected $casts = [
        'ngaytao' => 'date',
        'ngaygui' => 'date',
    ];

    /**
     * Relationship with GiaoVien
     */
    public function giaovien()
    {
        return $this->belongsTo(GiaoVien::class, 'magiaovien');
    }

    /**
     * Relationship with LopHoc
     */
    public function lophoc()
    {
        return $this->belongsTo(LopHoc::class, 'malop');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
