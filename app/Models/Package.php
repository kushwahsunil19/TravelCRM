<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'currency_id',
        'rate',       
        'package_name',
        'description',
        'infant_amount',
        'child_amount',
        'adult_amount',
        'amount',
        'net_amount',
    ];

    /**
     * Get the User associated with the quotation.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
    public function expenses()
    {
        return $this->hasMany(PackageExpense::class, 'package_id', 'id');
       
    }
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['deleted_at'];
}
