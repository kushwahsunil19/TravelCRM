<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SupplierExpense;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'suppliers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'address',
        'city',
        'state',
        'country',
        'postal_code',  
        'amount',
        'description',
        'status',     
        'image',
    ];

    /**
     * Get the expenses for the supplier.
     */
    public function expenses()
{
    return $this->hasMany(SupplierExpense::class, 'suplyer_id');
}
}
