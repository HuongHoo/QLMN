<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoatDong extends Model
{
    use HasFactory;

    protected $table = 'hoatdong';

    protected $fillable = [
        'tieude',
        'mota',
        'anh',
        'loai',
        'lophoc_id',
        'ngay',
        'hienthi',
        'thutu',
    ];

    protected $casts = [
        'ngay' => 'date',
        'hienthi' => 'boolean',
    ];

    /**
     * Lớp học liên quan
     */
    public function lophoc()
    {
        return $this->belongsTo(LopHoc::class, 'lophoc_id');
    }

    /**
     * Scope: Chỉ lấy hoạt động đang hiển thị
     */
    public function scopeHienThi($query)
    {
        return $query->where('hienthi', true);
    }

    /**
     * Scope: Lọc theo loại
     */
    public function scopeLoai($query, $loai)
    {
        return $query->where('loai', $loai);
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
