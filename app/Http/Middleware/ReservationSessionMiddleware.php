<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ReservationSessionMiddleware
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
        if(Auth::check()){
            return $next($request);
        }
        else{
            foreach($request->all() as $k=>$v){
                if($k == '_token') continue;
                $request->session()->put($k,$v);
            }
            return $next($request);
        }
    }
}
