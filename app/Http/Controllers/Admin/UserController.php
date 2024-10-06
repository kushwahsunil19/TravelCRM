<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
        // $this->middleware('permission:create-user', ['only' => ['create','store']]);
        // $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $userId = Auth::id(); // This will return the ID of the authenticated user.
        $roles = Role::where('id', '!=', 1)->get();
        return view('admin.users', compact('roles')); 
    }
      
 
    public function getUsers(Request $request)
    {
             $userId = Auth::id(); 
             $roles = Role::where('id', '!=', 1)->get(); // Fetch roles to pass along with users data

             $users = User::with('roles')->where('id', '!=', $userId)->latest()->get(); // Make sure to eager load the roles to avoid N+1 query issue
             return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('first_name', function($user) {
               
                $avatar = $user->profile ? url('public/profile/' . $user->profile) : url('public/assets/img/profiles/default.png');

                $profileUrl = '#'; // Route to the user's profile page
                
                // Adding email for display
                $email = '';
                
                return '
                <h2 class="table-avatar">
                    <a href="' . $profileUrl . '" class="avatar avatar-sm me-2">
                        <img class="avatar-img rounded-circle" src="' . $avatar . '" alt="User Image">
                    </a>
                    <a href="' . $profileUrl . '">' . $user->first_name . ' ' . $user->last_name . '
                        <span>' . $email . '</span>
                    </a>
                </h2>';
            })
            ->addColumn('role', function($user) {
                // Check if the user has any roles assigned
                if ($user->roles->isNotEmpty()) {
                    // Get the first role name (you can change this logic if needed)
                    $roleName = $user->roles->first()->name; // Get the name of the first role
                    return '<span class="badge bg-success-light">' . $roleName . '</span>';
                } else {
                    return '<span class="badge bg-danger-light">No Role Assigned</span>';
                }
            })
            ->addColumn('created_at', function($user) {
                return \Carbon\Carbon::parse($user->created_at)->format('Y-m-d'); // Format date to Y-m-d
            })
            ->addColumn('status', function($user) {
                if ($user->status) {
                    return '<span class="badge  bg-success-light">Active</span>';
                } else {
                    return '<span class="badge  bg-danger-light">Inactive</span>';
                }
            })
            
          
            ->addColumn('action', function($user) {
                return '
                <div class="dropdown dropdown-action">
                    <a href="#" class="btn-action-icon" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <ul>
                            <li>
                                <a class="dropdown-item edit-user" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_user" data-id="'.$user->id.'">
                                    <i class="far fa-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item delete-user" href="javascript:void(0);"  data-id="'.$user->id.'">
                                    <i class="far fa-trash-alt me-2"></i>Delete
                                </a>
                            </li>
                          
                        </ul>
                    </div>
                </div>';
            })
            
            ->rawColumns(['first_name', 'role', 'action', 'status']) // Mark 'first_name' as raw HTML
            ->make(true);
    
    }
    
    


    public function updateRole (Request $request, User $user)
    {
     
        // Validate the incoming request
        $request->validate([
            'role_id' => 'required|exists:roles,id', // Ensure the role exists in the roles table
        ]);

        // Check if the role exists before assigning it
     // Find the user by ID
        $user = User::findOrFail($request->user_id);
         

     if ($user) {
       // Assign the role to the user

       $role = Role::findOrFail($request->role);

       // Update the user's role, replacing any existing roles
        $user->syncRoles([$role->name]); // syncRoles expects role names or IDs

         // Return a JSON response
         return response()->json(['message' => 'Role assigned successfully.'], 200);
        } else {
         return response()->json(['message' => 'User not found.'], 404);
     }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|string|max:15',
            'role' => 'required',
            'password' => 'required|confirmed|min:6',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image file
        ]);
        // Handle file upload
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
          
            $fileName = time() . '.' . $file->getClientOriginalExtension(); // Create a unique file name
            $file->move(public_path('profile'), $fileName); // Move the file to the public/profile directory
        }
    
    
        // Create a new user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
           
            'status' => $request->status,
            'profile' => $fileName, // Save the file name in the database
        ]);
    
        // Assign role if needed
        if ($request->role) {
            $user->roles()->attach($request->role); // Ensure you have a roles relationship defined
        }
    
        return response()->json(['message' => 'User created successfully.']);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $user = User::find($id);
        $role_id =  $user->roles->first()->id;
        $roles = Role::where('id', '!=', 1)->get();
    
        return response()->json([
            'user' => $user,
            'roles' => $roles,
            'role_id'=> $role_id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate incoming data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'required|string|max:15',
            'role' => 'required|exists:roles,id',
            'status' => 'required|boolean',
            'password' => 'nullable|string|min:6|confirmed', // Password fields are optional
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Profile image validation
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Update user data
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;        
        $user->status = $request->status;
        $role = Role::findOrFail($request->role);

        // Update the user's role, replacing any existing roles
        $user->syncRoles([$role->name]); // syncRoles expects role names or IDs
        // Check if password is provided, if so, hash and update it
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
    
        // Handle profile image upload if provided
        if ($request->hasFile('profile')) {
            // Check if the user already has a profile image
            if ($user->profile && file_exists(public_path('profile/' . $user->profile))) {
                // Delete the old profile image
                unlink(public_path('profile/' . $user->profile));
            }
    
            // Upload the new profile image
            $file = $request->file('profile');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile'), $fileName); // Move the file to public/profile directory
            $user->profile = $fileName; // Save file name in the database
           
        }
    
        // Save the updated user data
        $user->save();
    
        // Return a success response
        return response()->json([
            'message' => 'User updated successfully!',
            'user' => $user
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Optionally, check for authorization here
    
        // Delete the user
        $user->delete();
    
        return response()->json(['success' => 'User deleted successfully.']);
    }
}
