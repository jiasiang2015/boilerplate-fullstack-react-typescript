<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Common\Auth\JwtAuthenticatable;

/**
 * @method static Admin AuthInst()
 * @method static string AuthCreate() */
class Admin extends JwtAuthenticatable
{
    use Notifiable;

    protected $table = 'admins';

    public static $GUARD_NAME = 'admin';

    public const TOKEN_EXPIRED_MINUTES = 43200;   // 60 * 24 * 30 分鐘
    public static $TOKEN_EXPIRED_MINUTES = self::TOKEN_EXPIRED_MINUTES;   // 60 * 24 * 30 分鐘

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'updated_at',
    ];
}
