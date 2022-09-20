<?php

namespace App\Http\Middleware;
use Closure;
class VisitorCounterMiddleware
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
        store_ip();
//        dd($request);
        return $next($request);
    }
}
