<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
          /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';
        /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'branch_id',
        'partner_id',
        'package_id',
        'currency_id',
        'currency_rate',
        'bank_id',
        'invoice_no',   
        'no_of_night',
        'no_of_passenger', 
        'vat',       
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

    public function services()
    {
        return $this->hasMany(Service::class, 'invoice_id', 'id');
    }

    // Alternative method to retrieve supplier IDs directly (optional)
    public function supplierIds()
    {
        return $this->services()->pluck('suplyer_id')->toArray();
    }
}
