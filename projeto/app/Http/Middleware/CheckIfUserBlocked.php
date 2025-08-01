<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfUserBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->blocked) {
            auth()->logout();
            return redirect('/login')->withErrors(['Sua conta está bloqueada.']);
        }

        return $next($request);
    }
}
