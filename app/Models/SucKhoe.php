<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SucKhoe extends Model
{
    protected $table = 'suckhoe';

    protected $fillable = [
        'mahocsinh',
        'ngaykham',
        'chieucao',
        'cannang',
        'tinhtrang',
        'ghichu',
    ];
    public function hocsinh()
    {
        return $this->belongsTo(HocSinh::class, 'mahocsinh');
    }
}
