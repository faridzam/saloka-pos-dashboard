<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\user_role_list_desktop;

class userRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$cekRole)
    {
        $myRole = Auth::user()->role;
        $authorization = user_role_list_desktop::where('role', $myRole)->value(implode($cekRole));

        if ($authorization == 1) {
            return $next($request);
        }

        return redirect()->back();
    }
}
