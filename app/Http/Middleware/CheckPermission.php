<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (!Auth::check() || !Auth::user()->hasAnyPermission($permissions)) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
