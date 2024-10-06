<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'branch_id',
        'partner_id',
        'package_id',
        'quotation_no',
        'twin_double_sharing_cost',
        'triple_sharing_cost',
        'child_extra_bed_cost',
        'child_no_extra_bed_cost',
        'gst_tax',       
        'discount_type',
        'discount',
    ];

    /**
     * Get the branch associated with the quotation.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the partner associated with the quotation.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the package associated with the quotation.
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
