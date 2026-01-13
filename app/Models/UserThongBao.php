<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserThongBao extends Model
{
    protected $table = 'user_thongbao';

    protected $fillable = [
        'user_id',
        'thongbao_id',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with ThongBao
     */
    public function thongbao()
    {
        return $this->belongsTo(ThongBao::class);
    }
}
