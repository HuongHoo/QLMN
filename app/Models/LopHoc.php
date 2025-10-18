<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopHoc extends Model
{
    use HasFactory;

    protected $table = 'lophoc';

    protected $fillable = [
        'tenlop',
        'nhomtuoi',
        'siso',
        'sophong',
        'nienkhoa',
        'ghichu',
    ];
}
