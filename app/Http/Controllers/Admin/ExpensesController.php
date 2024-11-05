<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
class ExpensesController extends Controller
{
   
    public function index(Request $request) // Add Request parameter
    {
        // Initialize query
        $query = Supplier::query();

        // Apply filters based on request input
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

        // Get the filtered suppliers
        $Suppliers = $query->get();

        return view('admin.expenses.index', compact('Suppliers'));
    }
    /**
     * Download PDF report.
     */
    public function downloadPDF(Request $request)
    {

    
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata'); 
    
        // Filtering logic
        $query = Supplier::query();
        
        if ($request->filled('supplier_name')) {
            $query->where('name', 'like', '%' . $request->supplier_name . '%');
        }
    
        if ($request->filled('mobile')) {
              $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }
    
        // Get the filtered data
        $suppliers = $query->get();
    // print_r($suppliers);die;
        // Check if suppliers exist before generating the PDF
        if ($suppliers->isEmpty()) {
            return redirect()->back()->with('error', 'No suppliers found for the selected filters.');
         }
     
        // Generate the PDF
        $pdf = PDF::loadView('admin.suppliers.supplier-report-pdf', compact('suppliers'));
    
        // Generate the filename with correct format
        $timestamp = date('Y-m-d_H-i-s');
        $filename = 'supplier_report_' . $timestamp . '.pdf';
    
        // Return the PDF with the correct headers
        return $pdf->download($filename);
    }
    
    

    /**
     * Download CSV report.
     */
    public function downloadCSV(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata'); 

        $query = Supplier::query();

        $suppliers = $query->get();

        if ($suppliers->isEmpty()) {
            return redirect()->back()->with('error', 'No suppliers found for the selected filters.');
        }

        // Create a CSV handle
        $handle = fopen('php://output', 'w');

        $timestamp = date('Y-m-d_H-i-s');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="supplier_report_' . $timestamp . '.csv"');

        // Add CSV headers
        fputcsv($handle, [
            'S.No',
            'Supplier Name',
            'Email',
            'Mobile',
            'City', 
            'State',
            'date',
            'Country',
            'Amount'
          
        ]);
        
        $serialNumber = 1;

        // Add the filtered data rows
        foreach ($suppliers as $supplier) {
            fputcsv($handle, [
                $serialNumber++,
                $supplier->name,
                $supplier->email,
                $supplier->mobile,
                $supplier->city,
                $supplier->state,
                $supplier->country,
                $supplier->amount,
              
            ]);
        }

        fclose($handle);
        exit;
    }
}
