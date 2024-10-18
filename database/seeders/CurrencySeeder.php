<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            ['name' => 'Indian Rupee', 'code' => 'INR', 'symbol' => '₹', 'exchange_rate' => 1,'status'=>1],
            ['name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$', 'exchange_rate' => 74.85 ,'status'=>1],
            ['name' => 'Euro', 'code' => 'EUR', 'symbol' => '€', 'exchange_rate' => 88.50,'status'=>1],
            ['name' => 'Emirati Dirham', 'code' => 'AED', 'symbol' => 'د.إ', 'exchange_rate' => 3.6725,'status'=>1],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
