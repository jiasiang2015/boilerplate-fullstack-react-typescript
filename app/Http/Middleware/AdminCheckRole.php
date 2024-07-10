<?php

namespace App\Http\Middleware;

use Closure;
use App\Common\AppError;
use App\Common\AppErrorType;
use App\Models\Admin;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminCheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $acceptRole): Response
    {
        $adminRole = Admin::AuthRole();
        $roles = explode('|', $acceptRole);
    
        if (in_array($adminRole, $roles) === false) {
            return AppError::new(AppErrorType::ADMIN_INVALID_ROLE)->toHttpResponse(403);
        }

        return $next($request);
    }
}
