<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBankDetail extends Model
{
    use HasFactory;
    protected $table = 'company_account_details'; // Specifying the table name

    // The attributes that are mass assignable
    protected $fillable = [
        'branch_id',
        'bank_name',
        'account_hoder_name',
        'account_no',
        'branch_name',
        'ifsc_code',
        'iban_no',
    ];
}
