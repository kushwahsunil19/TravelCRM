<?php

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
if (!function_exists('getPermission')) {
    function getPermission()
    {
        // Return the permissions as an array
        return auth()->user() ? auth()->user()->getAllPermissions()->toArray() : [];
    }
}

if (!function_exists('getAuth')) {
    /**
     * Generate a random string of specified length.
     *
     * @param int $length
     * @return string
     */
    function getAuth()
    {
        $user = Auth::user();

        if (Auth::check() && $user) {
            return $user;
        } else {
           return null;
        }
    }
}
