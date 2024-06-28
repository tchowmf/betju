<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse as HttpRedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): RedirectResponse
    {
        if (Auth::check() && Auth::user()->role->name == $role){
            return $next($request);
        }

        return redirect('/home')->with('error', 'Você não tem acesso a esta ação.');
    }
}
