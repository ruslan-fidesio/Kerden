<?php

namespace App\Http\Middleware;

use Closure;
use User;

class AdminMiddleware
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
        if($request->user()){
            if($request->user()->role->role == 'admin'){
                return $next($request);
            }
            return redirect('/home')->with('error',trans('auth.notAdmin'));
        }
    }
}
