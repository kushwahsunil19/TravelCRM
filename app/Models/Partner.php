<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes; // Import the SoftDeletes trait

class Partner extends Model
{
    use HasFactory;
    protected $table = 'partners';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'city_id',
        'state_id',
        'country_id',
    ];

    public function state()
    {
        return $this->belongsTo(State::class , 'state_id', 'id');       
    }

    public function country()
    {
        return $this->belongsTo(Country::class , 'country_id', 'id');    
    }

    // Relationship with City
    public function city()
    {
        return $this->belongsTo(City::class , 'city_id', 'id');  
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'partner_id', 'id');
    }


}