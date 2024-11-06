<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierExpense extends Model
{
    use HasFactory;

    protected $table = 'supplier_expenses';

    protected $fillable = [
        'suplyer_id',
        'title',
        'amount'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'suplyer_id');
    }
}
