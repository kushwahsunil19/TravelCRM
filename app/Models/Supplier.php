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

    public function expenses()
    {
        return $this->hasMany(SupplierExpense::class, 'suplyer_id');
    }
}
