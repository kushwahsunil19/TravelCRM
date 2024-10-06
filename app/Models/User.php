<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;


    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',        
        'email',
        'password',
        'mobile',       
        'country_id',
        'state_id',
        'city_id',
        'profile',
       'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public function roles()
    // {
    //     return $this->belongsTo(Role::class, 'role_id', 'id');
    // }
    /**
     * Check if the user has a specific role.
     */
    public function hasRole($role)
    {
        return $this->getRoleNames()->contains($role);
    }

    /**
     * Assign a role to the user.
     */
    // public function assignRole($role)
    // {
    //     $this->assignRole($role);
    // }

    /**
     * Remove a role from the user.
     */
    // public function removeRole($role)
    // {
    //     $this->removeRole($role);
    // }
}
