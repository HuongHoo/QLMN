<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danhgia';

    protected $fillable = [
        'mahocsinh',
        'magiaovien',
        'nam',
        'thang',
        'thechat',
        'ngonngu',
        'nhanthuc',
        'camxucxahoi',
        'nghethuat',
        'nhanxetchung',
    ];

    public function hocsinh()
    {
        return $this->belongsTo(HocSinh::class, 'mahocsinh', 'id');
    }

    public function giaovien()
    {
        return $this->belongsTo(GiaoVien::class, 'magiaovien', 'id');
    }
}
