<?php

namespace App\Http\Controllers;

use App\Common\AppResponse;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function __construct()
    {
    }

    public function login(Request $request) {

        $adminId = $request->post('admin_id');
        /** @var Admin */
        $admin = Admin::find($adminId);

        // 建立 Jwt Token
        return AppResponse::wrapWithData([
            'api_token' => Admin::AuthCreate($admin),
            'expired' => Admin::TOKEN_EXPIRED_MINUTES * 60,
        ]);
    }

    public function me(Request $request) {
        $admin = Admin::AuthInst();

        return AppResponse::wrapWithData($admin);
    }

}
