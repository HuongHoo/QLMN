<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HocPhi extends Model
{
    protected $table = 'hocphi';
    protected $fillable = [
        'mahocsinh',
        'thoigiandong',
        'hocphi',
        'tienansang',
        'tienantrua',
        'tienxebus',
        'phikhac',
        'tongtien',
        'ngaythanhtoan',
        'dathanhtoan',
        'magiaovien',
        'ghichu',
    ];

    public function hocsinh()
    {
        return $this->belongsTo(HocSinh::class, 'mahocsinh');
    }
    public function giaovien()
    {
        return $this->belongsTo(GiaoVien::class, 'magiaovien');
    }
}
