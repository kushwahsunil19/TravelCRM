<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

     protected $table = 'cities';
      protected $fillable = [
        'state_id',
        'name',
        'zipcode'
        
    ];
    
    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\CityFactory::new();
    }
}
