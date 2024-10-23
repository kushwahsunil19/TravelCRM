<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Administrator']);
        $salse = Role::create(['name' => 'Sales']);
        $operationsManager = Role::create(['name' => 'Operations']);

        $admin->givePermissionTo([
            'list-role',
            'create-role',
            'edit-role',
            'view-role',
            'delete-role',
            'list-user',
            'create-user',
            'edit-user',
            'view-user',
            'delete-user',      
            'list-quotation',    
            'create-quotation',
            'edit-quotation',
            'view-quotation',
            'delete-quotation',
            'list-invoice', 
            'create-invoice',
            'edit-invoice',
            'view-invoice',
            'delete-invoice'
        ]);

        // $salse->givePermissionTo([
        //     'list-quotation',
        //     'create-quotation',
        //     'edit-quotation',
        //     'view-quotation',
        //     'delete-quotation'
        // ]); 
       
    }
}
