<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Employer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = 'employer')
    {
        if (auth()->guard($guard)->check()) {
            return $next($request);
        } else {
            return redirect('/')->with('warning', 'Login Sebagai Employer');
        }
    }
}
