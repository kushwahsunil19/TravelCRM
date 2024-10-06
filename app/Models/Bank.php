<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    
    protected $table = 'bank_details'; // Specifying the table name

    // The attributes that are mass assignable
    protected $fillable = [
        'bank_name',
        'account_no',
        'branch_name',
        'ifsc_code',
    ];

    
}
