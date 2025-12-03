<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\GiaoVien;
use App\Models\PhuHuynh;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'vaitro',
        'trangthai',
        'google_id',
        'facebook_id',
        'avatar',
    ];
    public function giaovien()
    {
        return $this->hasOne(GiaoVien::class, 'user_id', 'id');
    }

    public function phuHuynh()
    {
        return $this->hasOne(PhuHuynh::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->vaitro === 'admin';
    }

    public function isTeacher()
    {
        return $this->vaitro === 'teacher';
    }

    public function isParent()
    {
        return $this->vaitro === 'parent';
    }
}
