<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DiemDanh extends Model
{
    protected $table = 'diemdanh';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mahocsinh',
        'ngaydiemdanh',
        'trangthai',
        'gioden',
        'giove',
        'lydo',
        'sophuttre',
        'tepdinhkem',
        'nhietdo',
        'magiaovien',
        'ghichu'
    ];

    public function hocsinh()
    {
        return $this->belongsTo(HocSinh::class, 'mahocsinh');
    }

    public function giaovien()
    {
        return $this->belongsTo(GiaoVien::class, 'magiaovien');
    }


    public function getGiobatdauAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function getGioketthucAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }
}
