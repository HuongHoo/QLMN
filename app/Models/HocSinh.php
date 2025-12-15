<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DanhGia;

class HocSinh extends Model
{
    protected $table = 'hocsinh';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mathe',
        'tenhocsinh',
        'ngaysinh',
        'gioitinh',
        'diachithuongtru',
        'diachitamtru',
        'malop',
        'maphuhuynh',
        'ngaynhaphoc',
        'trangthai',
        'anh',
        'ghichusuckhoe'
    ];
    public function lophoc()
    {
        return $this->belongsTo(LopHoc::class, 'malop');
    }

    public function phuhuynh()
    {
        return $this->belongsTo(PhuHuynh::class, 'maphuhuynh');
    }
    public function diemdanh()
    {
        return $this->hasMany(DiemDanh::class, 'mahocsinh');
    }

    public function suckhoe()
    {
        return $this->hasMany(SucKhoe::class, 'mahocsinh', 'id');
    }

    public function danhgia()
    {
        return $this->hasMany(DanhGia::class, 'mahocsinh', 'id');
    }

    public function hocphi()
    {
        return $this->hasMany(HocPhi::class, 'mahocsinh', 'id');
    }

    public function latestDanhgia()
    {
        return $this->hasOne(DanhGia::class, 'mahocsinh', 'id')->latestOfMany();
    }
}
