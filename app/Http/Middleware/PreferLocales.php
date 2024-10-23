<?php

namespace App\Http\Middleware;

use Closure;

class PreferLocales
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
        $preferLanguage = $request->header('X-Prefer-Language', 'zh-tw');
        $preferTimezone = $request->header('X-Prefer-Timezone', 'UTC');
        
        // Set to request.
        $request['preferLanguage'] = empty($preferLanguage) ? 'zh-tw' : $preferLanguage;
        $request['preferTimezone'] = empty($preferTimezone) ? 'UTC'   : $preferTimezone;

        return $next($request);
    }
}
