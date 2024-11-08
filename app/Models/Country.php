<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    protected $fillable = ['name','country_code'];

    // Relationship with State
    public function states()
    {
        return $this->hasMany(State::class);
    }

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\CountryFactory::new();
    }
}

