<?php

namespace App\Http\Middleware\Custom\Auth;

use Closure,Auth,Session;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user() && Auth::user()->user_type == 3){
            return $next($request);
        }
        Session::flash('error', 'you are not authorise to move');
        return redirect('/home');
    }
}
