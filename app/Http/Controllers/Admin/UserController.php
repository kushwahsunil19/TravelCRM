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
use PDF;

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
    public function index(Request $request)
    {
      
        $query = User::with('roles')->whereDoesntHave('roles', function ($query) {
            $query->where('id', 1); // Exclude users with admin role
        });

        // Apply filters based on user input
        if ($request->filled('user_name')) {
                $userName = trim($request->user_name); // Trim the input     
                $names = explode(' ', $userName);  // Split the input by space
                if (count($names)=== 2 || count($names) ===3) {
                    // If there are two parts, assume first and last name
                        $firstName = $names[0]; 
                        $lastName =(!empty($names[2]))? $names[2]: $names[1];         
                    $query->where('first_name', 'LIKE', '%' . $firstName . '%')
                          ->where('last_name', 'LIKE', '%' . $lastName . '%');
                } else {
                    // If there's only one part, search in both first_name and last_name
                    $query->where(function ($subQuery) use ($userName) {
                        $subQuery->where('first_name', 'LIKE', '%' . $userName . '%')
                                 ->orWhere('last_name', 'LIKE', '%' . $userName . '%');
                    });
                }
            
        }        

        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($subQuery) use ($request) {
                $subQuery->where('id', $request->role);
            });
        }
        if ($request->filled('mobile')) {
            $query->where('mobile', 'LIKE', '%' . $request->mobile . '%');
        }

      
        $total = User::count();
        $users = $query->latest()->paginate($total); // Adjust pagination as needed
        $roles = Role::where('id', '!=', 1)->get(); // Fetch roles for filters

        return view('admin.user.users', compact('users', 'roles'));
    }
    public function downloadPDF(Request $request)
    {
       
        // Reuse the filtering logic from index()
        $query = User::with('roles')->whereDoesntHave('roles', function ($query) {
            $query->where('id', 1); // Exclude users with admin role
        });

        // Apply filters (same as in the index method)
           // Apply filters based on user input
           if ($request->filled('user_name')) {
            $userName = trim($request->user_name); // Trim the input     
            $names = explode(' ', $userName);  // Split the input by space
            if (count($names)=== 2 || count($names) ===3) {
                // If there are two parts, assume first and last name
                    $firstName = $names[0]; 
                    $lastName =(!empty($names[2]))? $names[2]: $names[1];         
                $query->where('first_name', 'LIKE', '%' . $firstName . '%')
                      ->where('last_name', 'LIKE', '%' . $lastName . '%');
            } else {
                // If there's only one part, search in both first_name and last_name
                $query->where(function ($subQuery) use ($userName) {
                    $subQuery->where('first_name', 'LIKE', '%' . $userName . '%')
                             ->orWhere('last_name', 'LIKE', '%' . $userName . '%');
                });
            }
        
    }        

    if ($request->filled('email')) {
        $query->where('email', 'LIKE', '%' . $request->email . '%');
    }

    if ($request->filled('role')) {
        $query->whereHas('roles', function ($subQuery) use ($request) {
            $subQuery->where('id', $request->role);
        });
    }
    if ($request->filled('mobile')) {
        $query->where('mobile', 'LIKE', '%' . $request->mobile . '%');
    }


       

        $users = $query->get();

        // Check if users exist before generating the PDF
        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'No users found for the selected filters.');
        }

        $pdf = PDF::loadView('admin.user.user-report-pdf', compact('users'));
        return $pdf->download('user_report_' . Carbon::now()->format('Y_m_d') . '.pdf');
    }

    public function downloadCSV(Request $request)
    {
      
        // Reuse the filtering logic from index()
        $query = User::with('roles')->whereDoesntHave('roles', function ($query) {
            $query->where('id', 1); // Exclude users with admin role
        });

         // Apply filters based on user input
         if ($request->filled('user_name')) {
            $userName = trim($request->user_name); // Trim the input     
            $names = explode(' ', $userName);  // Split the input by space
            if (count($names)=== 2 || count($names) ===3) {
                // If there are two parts, assume first and last name
                    $firstName = $names[0]; 
                    $lastName =(!empty($names[2]))? $names[2]: $names[1];         
                $query->where('first_name', 'LIKE', '%' . $firstName . '%')
                      ->where('last_name', 'LIKE', '%' . $lastName . '%');
            } else {
                // If there's only one part, search in both first_name and last_name
                $query->where(function ($subQuery) use ($userName) {
                    $subQuery->where('first_name', 'LIKE', '%' . $userName . '%')
                             ->orWhere('last_name', 'LIKE', '%' . $userName . '%');
                });
            }
        
    }        

            if ($request->filled('email')) {
                $query->where('email', 'LIKE', '%' . $request->email . '%');
            }

            if ($request->filled('role')) {
                $query->whereHas('roles', function ($subQuery) use ($request) {
                    $subQuery->where('id', $request->role);
                });
            }
            if ($request->filled('mobile')) {
                $query->where('mobile', 'LIKE', '%' . $request->mobile . '%');
            }

       

        $users = $query->get();

        // Check if users exist before generating the CSV
        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'No users found for the selected filters.');
        }

        // Prepare CSV output
        $filename = 'user_report_' . Carbon::now()->format('Y_m_d') . '.csv';
        $handle = fopen('php://output', 'w');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Add CSV headers
        fputcsv($handle, ['User Name', 'Email', 'Mobile', 'Role', 'Created On', 'Status']);
        
        // Add data rows
        foreach ($users as $user) {
            fputcsv($handle, [
                $user->first_name . ' ' . $user->last_name,
                $user->email,
                $user->mobile ?? 'N/A',
                $user->roles->isNotEmpty() ? $user->roles->first()->name : 'No Role',
                $user->created_at->format('Y-m-d'),
                $user->status == 1 ? 'Active' : 'Inactive',
            ]);
        }

        fclose($handle);
        exit;
    }
    /**
     * Display a listing of the resource.
     */
    public function index_old(Request $request)
    {
        $userRole = auth()->user()->roles->first()->name; // Assuming the user has only one role
        $rolePermissions = getRolePermissions();   
        if (in_array('list-user', $rolePermissions[$userRole])) { 
        $userId = Auth::id(); // This will return the ID of the authenticated user.
        $roles = Role::where('id', '!=', 1)->get();
        if ($request->ajax()) {   
            // $userId = Auth::id(); 
            //  $roles = Role::where('id', '!=', 1)->get(); // Fetch roles to pass along with users data

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
    $editPermission = collect(getPermission())->contains('name', 'edit-user'); // Check if user has edit-user permission
    $deletePermission = collect(getPermission())->contains('name', 'delete-user'); // Check for delete permission

    $actions = '<div class="dropdown dropdown-action">
                    <a href="#" class="btn-action-icon" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <ul>';

    // Add Edit option only if the user has edit permission
    if ($editPermission) {
        $actions .= '<li>
                        <a class="dropdown-item edit-user" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_user" data-id="'.$user->id.'">
                            <i class="far fa-edit me-2"></i>Edit
                        </a>
                    </li>';
    }

    // Add Delete option only if the user has delete permission
    if ($deletePermission) {
        $actions .= '<li>
                        <a class="dropdown-item delete-user" href="javascript:void(0);" data-id="'.$user->id.'">
                            <i class="far fa-trash-alt me-2"></i>Delete
                        </a>
                    </li>';
    }

    $actions .= '</ul></div></div>';

    return $actions;
    
})

            ->rawColumns(['first_name', 'role', 'action', 'status']) // Mark 'first_name' as raw HTML
            ->make(true);
        }
        return view('admin.users', compact('roles')); 
    } else {
        // Redirect if the user lacks permission
        return redirect()->route('dashboard')->with('error', 'You do not have permission. Please contact the admin.');
    }
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
            'mobile' => 'required|numeric|digits_between:10,15|regex:/^(?:\+?\d{1,3})?\d{10,15}$/',
            'role' => 'required',
            'password' => 'required|confirmed|min:6',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image file
        ]);
        $fileName = '';
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
            'mobile' => 'required|numeric|digits_between:10,15|regex:/^(?:\+?\d{1,3})?\d{10,15}$/',
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
    public function destroy(User $user)
    {
         // Soft delete the branch
         $user->delete();

         return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    
       // return response()->json(['success' => 'User deleted successfully.']);
    }
}
