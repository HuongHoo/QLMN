<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LopHoc extends Model
{
    protected $table = 'lophoc';

    protected $fillable = [
        'tenlop',
        'nhomtuoi',
        'siso',
        'sophong',
        'nienkhoa',
        'giobatdau',
        'gioketthuc',
        'ghichu',
    ];

    /**
     * Get all students in this class.
     */
    public function hocsinh()
    {
        return $this->hasMany(HocSinh::class, 'malop', 'id');
    }

    /**
     * Get the teacher (giáo viên chủ nhiệm) for this class.
     */
    public function giaovien()
    {
        return $this->hasOne(GiaoVien::class, 'malopchunhiem', 'id');
    }
}
