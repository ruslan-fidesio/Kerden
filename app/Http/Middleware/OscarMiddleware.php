<?php

namespace App\Http\Middleware;

use Closure;

class OscarMiddleware
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
        if($request->user()->id == env('OSCAR_USER_ID')){
            return $next($request);
        }
        else{
            return redirect('/home')->with('error','Vous ne disposez pas des autorisations nécessaires pour accéder à cette page!');
        }
    }
}
