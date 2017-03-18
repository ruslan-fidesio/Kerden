<?php

namespace App\Http\Middleware;

use Closure;
use App\Garden;

class OwnerMiddleware
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
        $garden = Garden::find($request->id);
        if( ! $garden ){
            return redirect('/home')->with('error',trans('garden.unfound'));
        }
        if( $garden->userid != $request->user()->id){
            if($request->user()->role->role == 'admin'){
                $request->isAdminModifying = true;
                return $next($request);
            }
            return redirect('/home')->with('error',trans('garden.notowner'));
        }

        return $next($request);
    }
}
