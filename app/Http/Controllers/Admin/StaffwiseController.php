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
        if ($request->filled('staff_name')) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('first_name', 'LIKE', '%' . $request->staff_name . '%')
                         ->orWhere('last_name', 'LIKE', '%' . $request->staff_name . '%');
            });
        }

        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($subQuery) use ($request) {
                $subQuery->where('id', $request->role);
            });
        }

      

        $users = $query->paginate(10); // Adjust pagination as needed
        $roles = Role::where('id', '!=', 1)->get(); // Fetch roles for filters

        return view('admin.staff-wise-report.staff-wise-report', compact('users', 'roles'));
    }

    public function downloadPDF(Request $request)
    {
        // Reuse the filtering logic from index()
        $query = User::with('roles')->whereDoesntHave('roles', function ($query) {
            $query->where('id', 1); // Exclude users with admin role
        });

        // Apply filters (same as in the index method)
        if ($request->filled('staff_name')) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('first_name', 'LIKE', '%' . $request->staff_name . '%')
                         ->orWhere('last_name', 'LIKE', '%' . $request->staff_name . '%');
            });
        }

        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($subQuery) use ($request) {
                $subQuery->where('id', $request->role);
            });
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

        // Apply filters (same as in the index method)
        if ($request->filled('staff_name')) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('first_name', 'LIKE', '%' . $request->staff_name . '%')
                         ->orWhere('last_name', 'LIKE', '%' . $request->staff_name . '%');
            });
        }

        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($subQuery) use ($request) {
                $subQuery->where('id', $request->role);
            });
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
