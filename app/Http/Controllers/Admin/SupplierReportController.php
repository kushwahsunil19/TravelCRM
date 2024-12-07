<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Supplier,Country,State,City};

use PDF;

class SupplierReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $Suppliers = $query->with('expenses','currency','country','state','city','invoices.package')->get();
       
        return view('admin.suppliers.supplier-report', compact('Suppliers'));
    }
    /**
     * Download PDF report.
     */public function downloadPDF(Request $request)
{
    // Set the timezone to Indian Standard Time (IST)
    date_default_timezone_set('Asia/Kolkata'); 
    
    // Filtering logic
    $query = Supplier::query();
    
    // Apply filters based on request input (same logic as in index)
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

    // Get the filtered data
    $suppliers = $query->with('expenses','currency','country','state','city','invoices.package')->get();

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

public function downloadCSV(Request $request)
{
    date_default_timezone_set('Asia/Kolkata'); 

    $query = Supplier::query();

    // Apply filters based on request input (same logic as in index)
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

    // Get the filtered data
    $suppliers = $query->with('expenses', 'currency', 'country', 'state', 'city', 'invoices.package')->get();

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
        'Country',
        'Gross Amount',
        'Net Amount',
        'Net Profit'
    ]);

    $serialNumber = 1;

    // Initialize totals
    $totalGrossAmount = 0;
    $totalNetAmount = 0;
    $totalNetProfit = 0;

    // Add the filtered data rows
    foreach ($suppliers as $supplier) {
        $grossAmount = 0;
        $netAmount = 0;
        $netProfit = 0;

        // Calculate amounts based on invoices
        foreach ($supplier->invoices as $invoice) {
            $grossAmount += $invoice->package->amount;
            $netAmount += $invoice->package->net_amount;
        }

        $netProfit = $grossAmount - $netAmount;

        // Accumulate totals
        $totalGrossAmount += $grossAmount;
        $totalNetAmount += $netAmount;
        $totalNetProfit += $netProfit;

        // Add supplier data to CSV (without currency symbol)
        fputcsv($handle, [
            $serialNumber++,
            $supplier->name,
            $supplier->email,
            $supplier->mobile,
            $supplier->city->name,
            $supplier->state->name,
            $supplier->country->name,
            number_format($grossAmount, 2),
            number_format($netAmount, 2),
            number_format($netProfit, 2)
        ]);
    }

    // Add total row at the end (without currency symbol)
    fputcsv($handle, [
        '',
        '',
        '',
        '',
        '',
        '',
        'Total Amount:',
        number_format($totalGrossAmount, 2),
        number_format($totalNetAmount, 2),
        number_format($totalNetProfit, 2)
    ]);

    fclose($handle);
    exit;
}



}
