<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import the SoftDeletes trait

class Partner extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'partners';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'city',
        'state',
        'country',
    ];
}
