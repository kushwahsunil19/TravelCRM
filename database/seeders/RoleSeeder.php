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
            'create-user',
            'edit-user',
            'view-user',
            'delete-user',          
            'create-quotation',
            'edit-quotation',
            'view-quotation',
            'delete-quotation'
        ]);

        $salse->givePermissionTo([
            'create-quotation',
            'edit-quotation',
            'view-quotation',
            'delete-quotation'
        ]); 
       
    }
}
