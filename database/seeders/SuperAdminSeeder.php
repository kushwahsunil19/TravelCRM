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
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'info@cltt.co.in',
            'password' => Hash::make('superadmin@001'),
            'mobile' => '1234567900',
            'status'=>1
           
        ]);
        $superAdmin->assignRole('Administrator');

        // Creating Salse User
        $sales = User::create([
             'first_name' => 'Sales',
            'last_name' => 'User',
            'email' => 'sales@cltt.co.in',
            'password' => Hash::make('admin@123'),
            'mobile' => '1234567909',
            'status'=>1
        ]);
        $sales->assignRole('Sales');

        // Creating operation Manager User
         $operations = User::create([
           'first_name' => 'Operation',
           'last_name' => 'User',
           'email' => 'operations@cltt.co.in',
           'password' => Hash::make('admin@123'),
           'mobile' => '1234567906',
           'status'=>1
       ]);
         $operations->assignRole('Operations');

           // Creating operation Manager User
           $account = User::create([
            'first_name' => 'Account',
           'last_name' => 'User',
           'email' => 'accounts@gmail.com',
           'password' => Hash::make('admin@123'),
           'mobile' => '1234567906',
           'status'=>1
       ]);
         $account->assignRole('Accounts');

    //      $admin = User::create([
    //         'first_name' => 'Admin',
    //        'last_name' => 'Ji',
    //        'email' => 'dosm@cltt.co.in',
    //        'password' => Hash::make('admin@123'),
    //        'mobile' => '1234567906',
    //        'status'=>1
    //    ]);
    //      $admin->assignRole('Admin');

    }
}
