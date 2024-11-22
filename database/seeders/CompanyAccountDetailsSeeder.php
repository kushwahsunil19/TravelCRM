<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyAccountDetailsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('company_account_details')->insert([
            [
                'branch_id' => 1, // Assume branch ID 3
                'bank_name' => 'HDFC Bank Limited (hdfcbank.com)',
                'account_holder_name' => 'CENTURION LUXURY TRAVEL AND TOURISM PL',
                'account_no' => '50200062130701',
                'branch_name' => 'New Delhi',
                'ifsc_code' => 'HDFC0006335',
                'iban_no' => null, // Not applicable for some accounts
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_id' => 1, // Assume branch ID 3
                'bank_name' => 'ICIC Bank India (icicibank.com)',
                'account_holder_name' => 'CENTURION LUXURY TRAVEL & TOURISM',
                'account_no' => '004105502019',
                'branch_name' => 'New Delhi',
                'ifsc_code' => 'ICIC0000041',
                'iban_no' => null, // Not applicable for some accounts
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_id' => 2, // Assume branch ID 1
                'bank_name' => 'Rak Bank (rakbank.ae)',
                'account_holder_name' => 'CENTURION LUXURY TRAVEL & TOURISM LLC',
                'account_no' => '0332964062001',
                'branch_name' => 'Dubai',
                'ifsc_code' => 'NRAKAEAK',
                'iban_no' => 'AE39 0400 0003 3296 4062 001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_id' => 2, // Assume branch ID 2
                'bank_name' => 'Abu Dhabi Commercial Bank (adcb.com)',
                'account_holder_name' => 'CENTURION LUXURY TRAVEL & TOURISM LLC',
                'account_no' => '11958710920001',
                'branch_name' => 'Dubai',
                'ifsc_code' => 'ADCBAEAA',
                'iban_no' => 'AE60 0030 0119 5871 0920 001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
