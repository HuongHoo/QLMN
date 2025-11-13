<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhuHuynh extends Model
{
    protected $table = 'phuhuynh';
    protected $primaryKey = 'id';
    protected $fillable = [
        'hoten',
        'quanhe',
        'sdt',
        'email',
        'diachithuongtru',
        'diachitamtru',
        'nghenghiep',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
