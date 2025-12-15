<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnhHoatDong extends Model
{
    use HasFactory;

    protected $table = 'anh_hoatdong';

    protected $fillable = [
        'hoatdong_hangngay_id',
        'anh',
        'mota',
    ];

    /**
     * Hoạt động liên quan
     */
    public function hoatDongHangNgay()
    {
        return $this->belongsTo(HoatDongHangNgay::class, 'hoatdong_hangngay_id');
    }

    /**
     * Lấy URL ảnh
     */
    public function getAnhUrlAttribute()
    {
        if (str_starts_with($this->anh, 'http')) {
            return $this->anh;
        }
        return asset('storage/' . $this->anh);
    }
}
