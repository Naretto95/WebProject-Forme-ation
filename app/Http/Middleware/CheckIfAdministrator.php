<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfAdministrator
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
        if(Auth::user() &&  (Auth::user()->status === 'admin' || Auth::user()->status === 'super-admin'))
        {
            return $next($request);
        }

        flash("Vous n'êtes pas ADMIN !", 'danger');

        return redirect()->home();
    }
}
