<?php

namespace App\Http\Middleware;

use App\Models\Business;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class setSessionData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if session data is set for user and business
        if (!$request->session()->has('user')) {

            $auth = Auth::user();

            $user = User::find($auth->id);

            $business = Business::find($auth->business_id);

            $request->session()->put('user', $user);

            $request->session()->put('business', $business);
        }

        return $next($request);
    }
}
