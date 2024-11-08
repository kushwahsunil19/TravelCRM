<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class State extends Model
{
    use HasFactory;

    protected $table = 'states';
    protected $fillable = ['country_id', 'name', 'code'];

    // Relationship with Country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Relationship with City
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\StateFactory::new();
    }
}
