<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiaoVien extends Model
{
    protected $table = 'giaovien';
    protected $fillable = [
        'sothe',
        'tengiaovien',
        'ngaysinh',
        'gioitinh',
        'sdt',
        'email',
        'diachithuongtru',
        'diachitamtru',
        'chucvu',
        'malopchunhiem',
        'cccd',
        'ngayvaolam',
        'trangthai',
        'anh',
        'user_id',
    ];
    public function lophoc()
    {
        return $this->belongsTo(LopHoc::class, 'malopchunhiem', 'id');
        // 'malopchunhiem' là FK trong giaovien
        // 'id' là PK trong lophoc
    }
    // app/Models/GiaoVien.php
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
