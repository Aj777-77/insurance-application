<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user code exists in session
        if (!session()->has('user_code')) {
            return redirect()->route('insurance.landing')
                ->with('error', 'Please enter your user code to continue.');
        }

        return $next($request);
    }
}
