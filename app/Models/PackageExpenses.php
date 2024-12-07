<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageExpenses extends Model
{
    use HasFactory;
    protected $table = 'package_expenses';

    protected $fillable = [
        'package_id',
        'quotation_id',
        'title',
        'amount'
    ];
    
    public function package()
    {
        return $this->belongsTo(Supplier::class, 'package_id');
    }
}
