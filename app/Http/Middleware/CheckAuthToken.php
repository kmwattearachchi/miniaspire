<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuthToken
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
        if ($request->header('X-AUTH-TOKEN') != env('API_AUTH_TOKEN')) {
            return response()->json(['success'=> false, 'msg' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
