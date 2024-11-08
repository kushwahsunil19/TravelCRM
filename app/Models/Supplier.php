<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SupplierExpense;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'currency_id',
        'currency_rate',
        'name',
        'email',
        'mobile',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'postal_code',
        'amount',
        'description',
        'status',
        'image',
    ];

    public function expenses()
    {
        return $this->hasMany(SupplierExpense::class, 'suplyer_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class , 'currency_id', 'id');
    }
   
    public function country()
    {
        return $this->belongsTo(Country::class , 'country_id', 'id');    
    }
    public function state()
    {
        return $this->belongsTo(State::class , 'state_id', 'id');       
    }
    // Relationship with City
    public function city()
    {
        return $this->belongsTo(City::class , 'city_id', 'id');  
    }

}
