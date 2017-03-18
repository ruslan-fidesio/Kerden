<?php

namespace App\Http\Middleware;

use Closure;
use App\Garden;
use App\KerdenMailer;

class ValidGardenMiddleware
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
        if($request->isMethod('post')){
            $garden = Garden::find($request->id);
            if( $request->user()->role->role=='admin'){
                if(isset($request->validWarning)){
                    return $next($request);
                }
                return redirect()->action('ValidGardenController@index')->with('inputFrom',$request->all())
                                                                        ->with('requestURL',$request->path());
            }

            if($garden && $garden->state == 'validated'){
                if(isset($request->validWarning)){
                    $garden->state = 'prices_ok';
                    $garden->save();
                    //send a mail to admin
                    KerdenMailer::mailNoReply(env('KERDEN_ADMIN_MAIL'),'validGardenModified',['garden'=>$garden]);
                    return $next($request);
                }
                return redirect()->action('ValidGardenController@index')->with('inputFrom',$request->all())
                                                                        ->with('requestURL',$request->path());
            }
        }
        return $next($request);
    }
}
