<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branches')->insert([
            [
                'branch_name' => 'New Delhi',
                'city' => 'New Delhi',
                'address' => 'New Delhi',
                'phone' => '+971-4-1234587',
                'email' => 'newdelhi@centuriontravel.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_name' => 'Dubai',
                'city' => 'Dubai',
                'address' => 'Dubai',
                'phone' => '+971-4-1234567',
                'email' => 'dubai@centuriontravel.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
