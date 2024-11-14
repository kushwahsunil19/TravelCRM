<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    public $timestamps = false; // Disable timestamps

    // Fillable attributes for mass assignment
    protected $fillable = [
        'suplyer_id',
        'invoice_id',       
    ];

    public function suplyer()
    {
        return $this->belongsTo(Supplier::class , 'suplyer_id', 'id');       
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class , 'invoice_id', 'id');       
    }
}
