<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('countries')->insert([
            ['name' => 'India', 'country_code' => 'IN'],
            ['name' => 'United Arab Emirates', 'country_code' => 'AE'],
        ]);
        
    }
}

