<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Supplier,Invoice,User};
use PDF;
class ExpensesController extends Controller
{
     /**
     * Display the suppliers with filtering options.
     */
    public function index(Request $request)
    {
        $suppliers = $this->getFilteredSuppliers($request);

        // Filter expenses for total calculation
        foreach ($suppliers as $supplier) {
            $filteredExpenses = $supplier->expenses->filter(function ($expense) use ($request) {
                return !$request->filled('expenses') || stristr(strtolower($expense->title), strtolower($request->expenses));
            });

            $supplier->filtered_expenses = $filteredExpenses;
            $supplier->total_amount = $filteredExpenses->sum('amount');
        }

        return view('admin.expenses.index', compact('suppliers'));
    }

      /**
     * Display the suppliers with filtering options.
     */
    public function profitAndLossExpenses(Request $request)
    {
       
        $user = auth()->user(); // Get the logged-in user
        $roleName = auth()->user()->getRoleNames()->first(); // Returns the first role name
        $userIds = User::role( $roleName)->pluck('id');
         $packages = [];  // Package::all();
         $branches = []; //Branch::all();
        // Initialize a query builder for Partner
        $suppliersQuery = Supplier::query();
        $invoicesQuery = Invoice::with(['branch', 'partner', 'package', 'bank', 'currency','services']);
    
        // Apply filters if present in the request
        $currency_id  = 0;
        if ($request->has('branch') && $request->branch) {            
            $invoicesQuery->where('branch_id', $request->branch);                    
        }
        // role base 
        $userId = auth()->id(); 
        if($userId !=1){
        $invoicesQuery->where('user_id',  $userId); 
       }
      

        if ($request->filled('expenses')) {
            $suppliersQuery->whereHas('expenses', function ($suppliersQuery) use ($request) {
                $suppliersQuery->where('title', 'like', '%' . $request->expenses . '%');
            });
        }   
        if ($request->filled('supplyer_name')) {
            $suppliersQuery->where('name', 'like', '%' . $request->supplyer_name . '%');
        }  

        if ($request->filled('agent_name')) {
            $invoicesQuery->whereHas('partner', function ($invoicesQuery) use ($request) {
                $invoicesQuery->where('name', 'like', '%' . $request->agent_name . '%');
            });
        }  
    
        if ($request->has('package') && $request->package) {       
            $invoicesQuery->where('package_id', $request->package);
        }

        // if ($request->has('from_date') && $request->from_date && $request->has('to_date') && $request->to_date) {          
        //    $fromDate = Carbon::parse($request->from_date)->startOfDay();
        //    $toDate = Carbon::parse($request->to_date)->endOfDay();
        //    $invoicesQuery->whereBetween('created_at', [$fromDate, $toDate]);
        //    $suppliersQuery->whereBetween('created_at', [$fromDate, $toDate]);
        // }
        
         // role base 
         $userId = auth()->id(); 
         if($userId !=1){
         $invoicesQuery->where('user_id',  $userId); 
        }
        if ($user->hasRole($roleName) === 'Administrator') {
          // Admin sees all data, no filters applied
        } elseif ($user->hasRole($roleName)) {            
            $invoicesQuery->whereIn('user_id', $userIds);
        }
        $invoices = $invoicesQuery->get(); 
        // echo "<pre>"; print_r($invoices->toArray());die;
        // if (isset($invoices[0])) {
        //    $currency_id = $invoices[0]->currency_id;
        //    $suppliersQuery->where('currency_id', $currency_id);
        // } else {
        //     $currency_id = 0;
        //     $suppliersQuery->where('currency_id', $currency_id);
        // }

        $suppliers = $suppliersQuery->with(['invoices','expenses'])->get();
        // echo "<pre>";
        // print_r($suppliers->toArray());die;
        // if ($request->ajax()) {
    
        //     // Return only the HTML content for the table if it's an AJAX request
        //     return response()->json([
        //         'html' => view('admin.profit-loss.profit-loss-table-ajx', compact('invoices', 'suppliers'))->render()
        //     ]);
        // }

        
    
        return view('admin.expenses.profilt-and-loss-expenses', compact( 'suppliers', 'packages', 'branches'));
    }

    /**
     * Download the filtered report as a PDF.
     */
    public function downloadPDF(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');

        $suppliers = $this->getFilteredSuppliers($request);

        // Check if suppliers exist before generating the PDF
        if ($suppliers->isEmpty()) {
            return redirect()->back()->with('error', 'No suppliers found for the selected filters.');
        }

        // Apply the expense filter and calculate the filtered total amount for each supplier
        foreach ($suppliers as $supplier) {
            $filteredExpenses = $supplier->expenses->filter(function ($expense) use ($request) {
                return !$request->filled('expenses') || stristr(strtolower($expense->title), strtolower($request->expenses));
            });

            $supplier->filtered_expenses = $filteredExpenses;
            $supplier->total_amount = $filteredExpenses->sum('amount');
        }

        // Generate the PDF with filtered data
        $pdf = PDF::loadView('admin.expenses.expenses-report-pdf', compact('suppliers'));

        // Generate the filename with the correct format
        $timestamp = date('Y-m-d_H-i-s');
        $filename = 'expenses_report_' . $timestamp . '.pdf';

        // Return the PDF with the correct headers
        return $pdf->download($filename);
    }

    /**
     * Download the filtered report as a CSV.
     */
    public function downloadCSV(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');

        $suppliers = $this->getFilteredSuppliers($request);

        // Check if suppliers exist before generating the CSV
        if ($suppliers->isEmpty()) {
            return redirect()->back()->with('error', 'No suppliers found for the selected filters.');
        }

        // Set headers for CSV download
        $timestamp = date('Y-m-d_H-i-s');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="expenses_report_' . $timestamp . '.csv"');

        // Create a CSV handle
        $handle = fopen('php://output', 'w');
        ob_start(); // Start output buffering to prevent conflicts

        // Add CSV headers
        fputcsv($handle, [
            'S.No', 'Name', 'Email', 'Mobile', 'Expenses', 'Total Amount'
        ]);

        $serialNumber = 1;

        // Add the filtered data rows
        foreach ($suppliers as $supplier) {
            // Gather the expenses for each supplier
            $expensesList = [];
            $totalAmount = 0;

            // Filter expenses by title if 'expenses' filter is provided
            foreach ($supplier->expenses as $expense) {
                if (!$request->filled('expenses') || stristr(strtolower($expense->title), strtolower($request->expenses))) {
                    $expensesList[] = $expense->title . ' = ' . number_format($expense->amount, 2);
                    $totalAmount += $expense->amount;
                }
            }

            // Write the supplier's data into the CSV file
            fputcsv($handle, [
                $serialNumber++,
                $supplier->name,
                $supplier->email,
                $supplier->mobile,
             
                implode(', ', $expensesList) ?: 'No items',
                $totalAmount > 0 ? number_format($totalAmount, 2) : 'No items'
            ]);
        }

        fclose($handle);
        ob_end_flush(); // Flush output buffer to send CSV data to the browser
        exit;
    }

    /**
     * Helper method to filter suppliers based on request input.
     */
    private function getFilteredSuppliers(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }
        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }
        if ($request->filled('expenses')) {
            $query->whereHas('expenses', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->expenses . '%');
            });
        }

        return $query->with(['expenses'])->get();
    }
}
