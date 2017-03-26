<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Garden;

class VisibleGarden
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
        if(!empty($request->id)){
            $garden = Garden::find($request->id);
            if ($garden->state != 'dispo_ok' && $garden->state != 'validated' ) {
                return redirect()->back()->with('error', 'Il manque des informations pour prévisualiser le Jardin');
            }
            if($garden->state != 'validated' || $garden->owner->blocked){
                if(Auth::user()->role->role=='admin' || $garden->owner->id == Auth::user()->id){
                    $request->preview = true;
                    $request->message = $garden->owner->blocked?'Utilisateur bloqué...':'Jardin non validé...';
                    return $next($request);
                }
                return redirect('/');
            }
        }
        return $next($request);
    }
}
