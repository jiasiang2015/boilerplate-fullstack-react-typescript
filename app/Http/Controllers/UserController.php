<?php

namespace App\Http\Controllers;

use App\Common\AppResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function __construct()
    {
    }

    public function login(Request $request) {

        $userId = $request->post('user_id');
        /** @var User */
        $user = User::find($userId);

        // 建立 Jwt Token
        return AppResponse::wrapWithData([
            'api_token' => User::AuthCreate($user),
            'expired' => User::TOKEN_EXPIRED_MINUTES * 60,
        ]);
    }

    public function me(Request $request) {
        $user = User::AuthInst();

        return AppResponse::wrapWithData($user);
    }

}
