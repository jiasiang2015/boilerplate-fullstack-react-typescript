<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;
use App\Common\AppError;
use App\Common\AppErrorType;

class AdminLoginAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty(Admin::AuthId())) {
            return AppError::new(AppErrorType::ADMIN_PERMISSION_DENIED)->toHttpResponse(403);
        }

        // Check the active flag.
        if (Admin::AuthActive() == false) {
            return AppError::new(AppErrorType::ADMIN_ACCOUNT_IS_INACTIVE)->toHttpResponse(400);
        }

        // Check role.
        if (empty(Admin::AuthRole())) {
            return AppError::new(AppErrorType::ADMIN_INVALID_ROLE)->toHttpResponse(403);
        }

        return $next($request);
    }
}