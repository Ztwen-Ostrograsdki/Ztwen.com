<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Master
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
        if($request->user()->role == 'master' || $request->user()->id == 1){
            return $next($request);
        }
        return abort(403, "Vous n'êtes pas authorisé!");
        
    }
}
