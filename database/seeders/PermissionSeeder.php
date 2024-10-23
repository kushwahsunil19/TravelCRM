<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
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

        ];
        
        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }
    }
}
