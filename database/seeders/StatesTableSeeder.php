<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            // India
            ['name' => 'Andhra Pradesh', 'code' => 'AP', 'country_id' => 1],
            ['name' => 'Arunachal Pradesh', 'code' => 'AR', 'country_id' => 1],
            ['name' => 'Assam', 'code' => 'AS', 'country_id' => 1],
            ['name' => 'Bihar', 'code' => 'BR', 'country_id' => 1],
            ['name' => 'Chhattisgarh', 'code' => 'CG', 'country_id' => 1],
            ['name' => 'Goa', 'code' => 'GA', 'country_id' => 1],
            ['name' => 'Gujarat', 'code' => 'GJ', 'country_id' => 1],
            ['name' => 'Haryana', 'code' => 'HR', 'country_id' => 1],
            ['name' => 'Himachal Pradesh', 'code' => 'HP', 'country_id' => 1],
            ['name' => 'Jharkhand', 'code' => 'JH', 'country_id' => 1],
            ['name' => 'Karnataka', 'code' => 'KA', 'country_id' => 1],
            ['name' => 'Kerala', 'code' => 'KL', 'country_id' => 1],
            ['name' => 'Madhya Pradesh', 'code' => 'MP', 'country_id' => 1],
            ['name' => 'Maharashtra', 'code' => 'MH', 'country_id' => 1],
            ['name' => 'Manipur', 'code' => 'MN', 'country_id' => 1],
            ['name' => 'Meghalaya', 'code' => 'ML', 'country_id' => 1],
            ['name' => 'Mizoram', 'code' => 'MZ', 'country_id' => 1],
            ['name' => 'Nagaland', 'code' => 'NL', 'country_id' => 1],
            ['name' => 'Odisha', 'code' => 'OD', 'country_id' => 1],
            ['name' => 'Punjab', 'code' => 'PB', 'country_id' => 1],
            ['name' => 'Rajasthan', 'code' => 'RJ', 'country_id' => 1],
            ['name' => 'Sikkim', 'code' => 'SK', 'country_id' => 1],
            ['name' => 'Tamil Nadu', 'code' => 'TN', 'country_id' => 1],
            ['name' => 'Telangana', 'code' => 'TG', 'country_id' => 1],
            ['name' => 'Tripura', 'code' => 'TR', 'country_id' => 1],
            ['name' => 'Uttar Pradesh', 'code' => 'UP', 'country_id' => 1],
            ['name' => 'Uttarakhand', 'code' => 'UT', 'country_id' => 1],
            ['name' => 'West Bengal', 'code' => 'WB', 'country_id' => 1],
            // UAE
            ['name' => 'Abu Dhabi', 'code' => 'AD', 'country_id' => 2],
            ['name' => 'Dubai', 'code' => 'DU', 'country_id' => 2],
            ['name' => 'Sharjah', 'code' => 'SH', 'country_id' => 2],
        ];
    
        foreach ($states as $state) {
            $existingState = DB::table('states')
                ->where('name', $state['name'])
                ->first();
    
            if ($existingState) {
                // If the state exists, update the country_id, code, and timestamps
                DB::table('states')
                    ->where('id', $existingState->id)
                    ->update([
                        'country_id' => $state['country_id'],
                        'code' => $state['code'],
                        'updated_at' => now(),
                    ]);
            } else {
                // If the state does not exist, insert it
                DB::table('states')->insert([
                    'name' => $state['name'],
                    'country_id' => $state['country_id'],
                    'code' => $state['code'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
    
}
