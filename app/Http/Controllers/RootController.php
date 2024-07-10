<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RootController extends Controller
{
    public function show(Request $request)
    {
        return view('app', [
            'appUrl' => config('app.url'),
            'appTitle' => config('app.title'),
            'assetUrl' => rtrim(secure_asset('/'), '/'),
            'appTimeZone' => config('app.timezone'),
            'appVerison' => config('app.version'),
            'appDebugVconsole' => config('app.debug.vconsole'),

            // Liff 相關
            'liffId' => config('services.line.liff_id'),
            'liffLoginMockEnable' => config('services.line.liff_login_mock_enable'),
            'liffUrl' => config('services.line.liff_url'),
        ]);
    }
}
