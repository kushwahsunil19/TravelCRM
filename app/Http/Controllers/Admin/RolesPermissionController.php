<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
Use DB;
class RolesPermissionController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::get();   
        // Fetch all branches, including soft-deleted ones if needed
        $roles = Role::where('id', '!=', 1)->get();       
        return view('admin.rolesPermission.roles-permission', compact('roles','permissions'));
    }
        /**
          * Display a listing of the resource.
          */
      
        public function getPermission($roleId) {
            // Find the role by ID
            $role = Role::findById($roleId);
            
            // Retrieve all permissions
            $permissions = Permission::all();
        
            // Group permissions by module
            $modules = [];
        
            // Iterate through each permission to group by module
            foreach ($permissions as $permission) {
                // Log the permission name for debugging
                \Log::info("Processing permission: " . $permission->name);
        
                // Assuming permission names are in the format "action-module"
                $parts = explode('-', $permission->name, 2);
        
                // Check if the permission format is valid
                if (count($parts) !== 2) {
                    \Log::warning("Invalid permission format: " . $permission->name);
                    continue; // Skip if not in expected format
                }
        
                // Unpack the array safely
                [$action, $module] = $parts;
        
                // Initialize the module array if it doesn't exist
                if (!isset($modules[$module])) {
                    $modules[$module] = [];
                }
        
                // Add permission to the respective module
                $modules[$module][] = $permission;
            }
        
            // Log the structured modules array for debugging
            \Log::info("Grouped permissions by module: ", $modules);
     // echo "<pre>";  print_r( $modules);die;
            // Pass role and modules data to the view
            return view('admin.rolesPermission.permission', compact('role', 'modules'));
        }
                
        public function updatePermissions(Request $request, Role $role)
        {
            // Get the selected permissions from the form
            $permissions = $request->input('permissions', []);  // Default to empty array if nothing is selected
           //echo "<pre   >"; print_r($permissions);die;
            // Sync permissions for the role
            $role->syncPermissions($permissions);
        
            // Optionally add a success message and redirect
            return redirect()->back()->with('success', 'Permissions updated successfully.');
        }    
        
        
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.branches.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'role_name' => 'required|string|max:255',  
            'permissions' => 'required',          
        ]);
        $role = Role::create(['name' => $request->role_name,'guard_name'=>'web']);
        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();        
        $role->syncPermissions($permissions);

        $roleDetails = Role::where('id', '!=', 1)->latest()->get();     
       
        return response()->json(['status'=>true,'data'=>$roleDetails ,'message' => 'Role details added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return view('admin.branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
      
        $role = Role::where('id', $id)->first();
        $rolePermissions = DB::table("role_has_permissions")->where("role_id",$id)
            ->pluck('permission_id')
            ->all();
         // print_r( $rolePermissions);die;
        return response()->json(['status'=>true,'data'=>$role ,'rolePermissions'=>$rolePermissions,'message' => 'Role details added successfully']);
        //eturn view('admin.branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'role_name' => 'required|string|max:255',  
            'permissions' => 'required',          
        ]);
    
        // Find the role by ID and update its name
        $role = Role::find($request->role_id);
        
        if (!$role) {
            return response()->json(['status' => false, 'message' => 'Role not found'], 404);
        }
    
        $role->update(['name' => $request->role_name]); // Update the role's name
    
        // Get the permissions to sync
        $permissions = Permission::whereIn('id', $request->permissions)->get();
    
        // Sync the permissions with the role
        $role->syncPermissions($permissions); 
    
        return response()->json(['status' => true, 'data' => $role, 'message' => 'Role details updated successfully']);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        // Soft delete the branch
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }

    /**
     * Restore a soft-deleted branch.
     */
    public function restore($id)
    {
        $branch = Branch::withTrashed()->findOrFail($id);
        $branch->restore();

        return redirect()->route('branches.index')->with('success', 'Branch restored successfully.');
    }
}
