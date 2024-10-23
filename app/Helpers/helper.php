<?php

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

if (!function_exists('getPermission')) {
    function getPermission()
    {
        // Return the permissions as an array
        return auth()->user() ? auth()->user()->getAllPermissions()->toArray() : [];
    }
}


if (!function_exists('getRolePermissions')) {
    function getRolePermissions()
    {
        $roles = Role::all();
        $data = []; // Initialize the data array

        foreach ($roles as $role) {
        // Create an array entry for each role with its permissions
         $data[$role->name] = $role->permissions->pluck('name')->toArray(); // Collect permissions for each role
        }
        return $data;
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