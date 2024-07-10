<?php

namespace App\Common;

use App\Common\Attributes\Error;
use App\Common\Attributes\ErrorEunmTrait;

/**
 * @method int code()
 * @method string message() */
enum AppErrorType {
    use ErrorEunmTrait;

    #[Error(0, 'No Error')]
    case NO_ERROR;

    // ------------------------------------------------------
    // Format Error
    #[Error(101, 'Invalid line reigstration format')]
    case FE_LINE_REGISTRAION;

    // ------------------------------------------------------
    // Not Found Error
    #[Error(201, 'Line ID not found')]
    case NT_LINE_UID;

    // ------------------------------------------------------
    // General Error


    // ------------------------------------------------------
    // User Error

    // ------------------------------------------------------
    // 權限
    #[Error(1101, 'authorized token failed')]
    case UNAUTHORIZED_TOKEN;

    // Admin 相關錯誤
    #[Error(1201, 'Admin permission denied')]
    case ADMIN_PERMISSION_DENIED;

    #[Error(1202, 'This account is inactive')]
    case ADMIN_ACCOUNT_IS_INACTIVE;

    #[Error(1203, 'Invalid permission role')]
    case ADMIN_INVALID_ROLE;

    #[Error(1204, 'Invalid passwowrd')]
    case ADMIN_INVALID_USER_OR_PASSWORD;
}
