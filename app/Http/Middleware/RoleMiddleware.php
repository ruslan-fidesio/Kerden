<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if($request->user()){
            if($request->user()->blocked){
                return redirect('/home')->with('error','Impossible : votre compte a été bloqué par un administrateur.');
            }

            $myRole = $request->user()->role->role;
            //admin ByPass
            if($myRole == 'admin'){
                return $next($request);
            }
            if($myRole == 'new'){
                return redirect('/home')->with('error',trans('auth.notConfirmed'));
            }
            if($myRole == 'confirmed' && $role!='confirmed'){
                return redirect('/home')->with('error',trans('auth.notDetailed'));
            }
            if($role == 'regular' && $myRole != $role){
                return redirect('/home')->with('error',trans('auth.proofNeeded'));
            }
            return $next($request);
        }
    }
}
