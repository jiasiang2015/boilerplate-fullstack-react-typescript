<?php

namespace App\Models;

use App\Common\Auth\JwtAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static User AuthInst()
 * @method static string AuthCreate() */
class User extends JwtAuthenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'users';

    public static $GUARD_NAME = 'user';

    public const TOKEN_EXPIRED_MINUTES = 43200;   // 60 * 24 * 30 分鐘
    public static $TOKEN_EXPIRED_MINUTES = self::TOKEN_EXPIRED_MINUTES;   // 60 * 24 * 30 分鐘

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
