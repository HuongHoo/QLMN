<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HocPhi extends Model
{
    protected $table = 'hocphi';
    protected $fillable = [
        'mahocsinh',
        'thoigiandong',
        'tu_ngay',
        'den_ngay',
        'hocphi',
        'tienansang',
        'tienantrua',
        'tienxebus',
        'gia_tien_an_ngay',
        'so_ngay_di_hoc',
        'phikhac',
        'tongtien',
        'ngaythanhtoan',
        'dathanhtoan',
        'magiaovien',
        'ghichu',
    ];

    protected $casts = [
        'tu_ngay' => 'date',
        'den_ngay' => 'date',
        'thoigiandong' => 'date',
        'ngaythanhtoan' => 'date',
    ];

    public function hocsinh()
    {
        return $this->belongsTo(HocSinh::class, 'mahocsinh');
    }
    public function giaovien()
    {
        return $this->belongsTo(GiaoVien::class, 'magiaovien');
    }

    /**
     * Tự động tính tiền ăn dựa vào điểm danh
     */
    public function tinhTienAn()
    {
        if (!$this->mahocsinh || !$this->tu_ngay || !$this->den_ngay || !$this->gia_tien_an_ngay) {
            return 0;
        }

        // Đếm số ngày đi học (có mặt) trong khoảng thời gian
        $soNgayDiHoc = \App\Models\DiemDanh::where('mahocsinh', $this->mahocsinh)
            ->whereBetween('ngaydiemdanh', [$this->tu_ngay, $this->den_ngay])
            ->where(function($query) {
                $query->where('trangthai', 'like', '%có mặt%')
                      ->orWhere('trangthai', 'like', '%đi muộn%');
            })
            ->count();

        $this->so_ngay_di_hoc = $soNgayDiHoc;
        
        // Tính tiền ăn = số ngày × đơn giá
        $tienAn = $soNgayDiHoc * $this->gia_tien_an_ngay;
        
        return $tienAn;
    }
}
