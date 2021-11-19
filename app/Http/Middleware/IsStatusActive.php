<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class IsStatusActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user() && !Auth::user()->status){
            Auth::logout();
            throw ValidationException::withMessages([
                    'email' => (__('flash-messages.Your account is not active')),
                ]);
        }

        if(!Auth::user() || (Auth::user() && Auth::user()->status)){
            return $next($request);
        }
    }
}
