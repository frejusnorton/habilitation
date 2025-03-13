<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class OurCheckUsers
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() || session()->has('authUser')) {
            return $next($request);
        }
        return redirect()->route('auth')->with('error', 'Accès refusé. Authentification requise.');
    }
    
}
