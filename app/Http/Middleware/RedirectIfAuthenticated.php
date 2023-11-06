<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && Auth::user()->role_id == 1)
            {
                // return redirect(RouteServiceProvider::HOME);
                return redirect()->route('admin.dashboard');
            }
            elseif (Auth::guard($guard)->check() && Auth::user()->role_id == 2)
            {
                return redirect()->route('doctor.dashboard');
            }
            elseif (Auth::guard($guard)->check() && Auth::user()->role_id == 3)
            {
                return redirect()->route('assistant.dashboard');
            }
            elseif (Auth::guard($guard)->check() && Auth::user()->role_id == 4)
            {
                return redirect()->route('patient.dashboard');
            }
            else
            {
                return $next($request);
            }
        }
    }
}
