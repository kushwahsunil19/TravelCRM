<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory; 
    //use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'branch_id',
        'partner_id',
        'package_id',        
        'bank_id',
        'quotation_no',
        'no_of_night',
        'no_of_infant', 
        'no_of_child', 
        'no_of_adult', 
        'no_of_passenger', 
        'booking_reference_no',            
        'gst_tax',       
        'discount_type',
        'discount',
        'status',
        'note',
        'term_condition'
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
    // Defining the relationship with the Back model
    public function bank()
    {
        return $this->belongsTo(Bank::class , 'bank_id', 'id');    

    }
    public function currency()
    {
        return $this->belongsTo(Currency::class , 'currency_id', 'id');    

    }
    public function tmpServices()
    {
        return $this->hasMany(TmpService::class, 'quotation_id', 'id');
    }

    // Alternative method to retrieve supplier IDs directly (optional)
    public function supplierIds()
    {
        return $this->tmpServices()->pluck('suplyer_id')->toArray();
    }
    /**
     * Get the User associated with the quotation.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
    
    public function services()
    {
        return $this->hasMany(Service::class, 'invoice_id', 'id');
    }
}
