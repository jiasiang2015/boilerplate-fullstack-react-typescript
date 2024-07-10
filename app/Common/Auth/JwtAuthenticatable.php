<?php

namespace App\Common\Auth;

use Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

abstract class JwtAuthenticatable extends Authenticatable implements JWTSubject {
    use Notifiable;

    protected static $GUARD_NAME = 'user';

    protected static $TOKEN_EXPIRED_MINUTES = 43200;   // 60 * 24 * 30 分鐘

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /** Request 用的的，可以取出當前的 User 資料 */
    public static function AuthInst() {
        return Auth::guard(static::$GUARD_NAME)->user();
    }

    /** 使用此 User 建立 API Token */
    public static function AuthCreate(JwtAuthenticatable $user): string {
        return Auth::guard(static::$GUARD_NAME)->setTTL(static::$TOKEN_EXPIRED_MINUTES)->login($user);
    }

    public static function AuthId(): int {
        return Auth::guard(static::$GUARD_NAME)->id();
    }

    /** 登出 User */
    public static function AuthLogut()
    {
        Auth::guard(static::$GUARD_NAME)->logout();
    }

}