<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpService extends Model
{
    use HasFactory;
    protected $table = 'tmp_services';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'suplyer_id',
        'quotation_id',       
    ];

    public function suplyer()
    {
        return $this->belongsTo(Supplier::class , 'suplyer_id', 'id');       
    }

    public function qoutaion()
    {
        return $this->belongsTo(Quotation::class , 'quotation_id', 'id');       
    }
}
