<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'line' => [
        'liff_login_mock_enable' => env('LINE_LIFF_LOGIN_MOCKED_ENABLE'),
        'oa_url' => env('LINE_OA_URL'),
        'liff_login_channel_id' => env('LINE_LOGIN_CHANNEL_ID'),
        'liff_id' => env('LINE_LIFF_ID'),
        'liff_url' => env('LINE_LIFF_URL'),
        'msg_api_channel_access_token' => env('LINE_MESSAGE_API_CHANNEL_ACCESS_TOKEN'),
        'msg_api_channel_secret' => env('LINE_MESSAGE_API_CHANNEL_SECRET'),
    ],
];
