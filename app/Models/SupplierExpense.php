<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierExpense extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supplier_expenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'suplyer_id',
        'title',
        'amount'
    ];

    /**
     * Get the supplier that owns the expense.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'suplyer_id', 'id'); // foreign key is 'suplyer_id'
    }
}
