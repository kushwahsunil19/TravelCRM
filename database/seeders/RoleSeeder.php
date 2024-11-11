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
            'delete-invoice',

            'list-expenses',  
            'create-expenses',
            'edit-expenses',         
            'view-expenses',
            'delete-expenses',
            
            'list-staff-report', 
            'create-staff-report',
            'edit-staff-report',             
            'view-staff-report',
            'delete-staff-report',

            'list-hotel-report', 
            'create-hotel-report',
            'edit-hotel-report',    
            'view-hotel-report',
            'delete-hotel-report',

            'list-supplier-report',
            'create-supplier-report',
            'edit-supplier-report',    
            'view-supplier-report',
            'delete-supplier-report',

            'list-quotation-report', 
            'create-quotation-report',
            'edit-quotation-report',    
            'view-quotation-report',
            'delete-quotation-report',

            'list-partners-report', 
            'create-partners-report',
            'edit-partners-report',    
            'view-partners-report',
            'delete-partners-report',

            'list-profit-loss',
            'create-profit-loss',
            'edit-profit-loss',               
            'view-profit-loss',
            'delete-profit-loss',

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
