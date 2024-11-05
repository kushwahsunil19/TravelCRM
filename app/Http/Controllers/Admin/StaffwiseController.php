<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use PDF;
use Carbon\Carbon;

class StaffwiseController extends Controller
{
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
       // Adjust pagination as needed
        $roles = Role::where('id', '!=', 1)->get(); // Fetch roles for filters

        return view('admin.staff-wise-report.staff-wise-report', compact('users', 'roles'));
    }

    public function downloadPDF(Request $request)
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

        // Check if users exist before generating the PDF
        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'No users found for the selected filters.');
        }

        $pdf = PDF::loadView('admin.staff-wise-report.staff-wise-report-pdf', compact('users'));
        return $pdf->download('staff_report_' . Carbon::now()->format('Y_m_d') . '.pdf');
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
        $filename = 'staff_report_' . Carbon::now()->format('Y_m_d') . '.csv';
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
}
