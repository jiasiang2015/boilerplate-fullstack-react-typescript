<?php

namespace App\Common\Enums;

use App\Common\Attributes\BaseEnumTrait;

enum AdminRole: string {

    use BaseEnumTrait;

    case Admin = 'admin';
    case SA = 'sa';
    case Staff = 'staff';
    
}
