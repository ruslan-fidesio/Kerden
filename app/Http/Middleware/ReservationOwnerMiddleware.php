<?php

namespace App\Http\Middleware;

use Closure;
use App\Reservation;

class ReservationOwnerMiddleware
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
        $id = $request->route('id');
        $reservation = Reservation::findOrFail($id);

        if($request->user()->id != $reservation->user_id ){
            return redirect('/home')->with('error','Ceci n\'est pas une réservation qui vous concerne.');
        }
        return $next($request);
    }
}
