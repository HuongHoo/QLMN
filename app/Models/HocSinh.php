<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
