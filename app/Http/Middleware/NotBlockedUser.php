<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotBlockedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->blocked){
            return abort(403, "Votre compte a été bloqué!... Veuillez contacter un administrateur!");
        }
        return $next($request);
    }
}
