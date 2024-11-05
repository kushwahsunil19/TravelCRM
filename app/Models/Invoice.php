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
        'branch_id',
        'agent_id',
        'package_id',
        'currency_id',
        'bank_id',
        'invoice_no',      
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
     * Get the agent associated with the quotation.
     */
    public function agent()
    {
        return $this->belongsTo(agent::class);
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
}
