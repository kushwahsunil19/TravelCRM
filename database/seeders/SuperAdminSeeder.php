<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([           
            'first_name' => 'Admin',
            'last_name' => '',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
            'mobile' => '123456790',
            'status'=>1
           
        ]);
        $superAdmin->assignRole('Administrator');

        // Creating Salse User
        $sales = User::create([
             'first_name' => 'Syed Ahsan ',
            'last_name' => 'Kamal',
            'email' => 'Syed@gmail.com',
            'password' => Hash::make('syed@123'),
            'mobile' => '123456790',
            'status'=>1
        ]);
        $sales->assignRole('Sales');

        // Creating operation Manager User
         $perations = User::create([
            'first_name' => 'Javed Ahsan',
           'last_name' => 'Kamal',
           'email' => 'javed@gmail.com',
           'password' => Hash::make('javed@123'),
           'mobile' => '123456790',
           'status'=>1
       ]);
         $perations->assignRole('Operations');
    }
}
