<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoatDongHangNgay extends Model
{
    use HasFactory;

    protected $table = 'hoatdong_hangngay';

    protected $fillable = [
        'hocsinh_id',
        'lophoc_id',
        'giaovien_id',
        'tieude',
        'mota',
        'loai',
        'giobatdau',
        'gioketthuc',
        'ngay',
    ];

    protected $casts = [
        'ngay' => 'date',
        'giobatdau' => 'datetime:H:i',
        'gioketthuc' => 'datetime:H:i',
    ];

    /**
     * Học sinh liên quan (nếu có)
     */
    public function hocsinh()
    {
        return $this->belongsTo(HocSinh::class, 'hocsinh_id');
    }

    /**
     * Lớp học
     */
    public function lophoc()
    {
        return $this->belongsTo(LopHoc::class, 'lophoc_id');
    }

    /**
     * Giáo viên đăng
     */
    public function giaovien()
    {
        return $this->belongsTo(GiaoVien::class, 'giaovien_id');
    }

    /**
     * Các ảnh của hoạt động
     */
    public function anhHoatDongs()
    {
        return $this->hasMany(AnhHoatDong::class, 'hoatdong_hangngay_id');
    }

    /**
     * Alias cho anhHoatDongs
     */
    public function anhHoatDong()
    {
        return $this->anhHoatDongs();
    }

    /**
     * Lấy icon theo loại
     */
    public function getIconAttribute()
    {
        return match ($this->loai) {
            'gioian' => 'fa-utensils',
            'hoctap' => 'fa-book',
            'ngoaitroi' => 'fa-sun',
            'nghingoi' => 'fa-moon',
            default => 'fa-star',
        };
    }

    /**
     * Lấy màu badge theo loại
     */
    public function getBadgeColorAttribute()
    {
        return match ($this->loai) {
            'gioian' => 'success',
            'hoctap' => 'primary',
            'ngoaitroi' => 'warning',
            'nghingoi' => 'info',
            default => 'secondary',
        };
    }

    /**
     * Lấy tên loại hiển thị
     */
    public function getLoaiTextAttribute()
    {
        return match ($this->loai) {
            'gioian' => 'Giờ ăn',
            'hoctap' => 'Học tập',
            'ngoaitroi' => 'Ngoài trời',
            'nghingoi' => 'Nghỉ ngơi',
            default => 'Hoạt động',
        };
    }

    /**
     * Scope: Lấy hoạt động hôm nay
     */
    public function scopeHomNay($query)
    {
        return $query->whereDate('ngay', today());
    }

    /**
     * Scope: Lấy theo lớp
     */
    public function scopeTheoLop($query, $lopHocId)
    {
        return $query->where('lophoc_id', $lopHocId);
    }

    /**
     * Scope: Lấy theo học sinh hoặc cả lớp
     */
    public function scopeChoHocSinh($query, $hocSinhId, $lopHocId)
    {
        return $query->where(function ($q) use ($hocSinhId, $lopHocId) {
            $q->where('hocsinh_id', $hocSinhId)
                ->orWhere(function ($q2) use ($lopHocId) {
                    $q2->whereNull('hocsinh_id')
                        ->where('lophoc_id', $lopHocId);
                });
        });
    }
}
