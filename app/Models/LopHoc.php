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
}
