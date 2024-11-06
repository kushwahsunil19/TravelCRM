<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Supplier;



class HotelReportController extends Controller
{
    public function index(Request $request)
{
    $query = Supplier::query();

    // Apply filters based on request input
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    // Get the filtered suppliers with their hotel expenses
    $Suppliers = $query->with(['expenses' => function ($query) {
        $query->where('title', 'like', '%hotel%'); // Use LIKE operator to filter for any hotel-related expenses
    }])->get();

    // Calculate the total hotel expenses for each supplier
    foreach ($Suppliers as $Supplier) {
        $Supplier->totalHotelAmount = $Supplier->expenses->sum('amount');
    }

    return view('admin.expenses.hotel-report', compact('Suppliers'));
}




    /**
     * Download PDF report.
     */
    public function downloadPDF(Request $request)
{
    date_default_timezone_set('Asia/Kolkata');

    // Initialize the query
    $query = Supplier::query();

    // Apply filters based on request input
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    // Get the filtered suppliers with their hotel expenses
    $suppliers = $query->with(['expenses' => function ($query) {
        $query->where('title', 'like', '%hotel%'); // Use LIKE operator to filter for any hotel-related expenses
    }])->get();

    // Check if suppliers exist before generating the PDF
    if ($suppliers->isEmpty()) {
        return redirect()->back()->with('error', 'No suppliers found for the selected filters.');
    }

    // Calculate the total hotel expenses for each supplier
    foreach ($suppliers as $supplier) {
        $supplier->totalHotelAmount = $supplier->expenses->sum('amount');
    }

    // Generate the PDF
    $pdf = PDF::loadView('admin.expenses.hotel-report-pdf', compact('suppliers'));

    // Generate the filename with correct format
    $timestamp = date('Y-m-d_H-i-s');
    $filename = 'hotel_report_' . $timestamp . '.pdf';

    // Return the PDF with the correct headers
    return $pdf->download($filename);
}

public function downloadCSV(Request $request)
{
    date_default_timezone_set('Asia/Kolkata');

    // Initialize the query for suppliers
    $query = Supplier::query();

    // Apply filters based on request input
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    // Get the filtered suppliers with their hotel expenses (filter expenses with 'hotel' in title)
    $suppliers = $query->with(['expenses' => function ($query) {
        $query->where('title', 'like', '%hotel%'); // Filtering hotel-related expenses
    }])->get();

    // Check if suppliers exist before generating the CSV
    if ($suppliers->isEmpty()) {
        return redirect()->back()->with('error', 'No suppliers found for the selected filters.');
    }

    // Create a CSV handle
    $handle = fopen('php://output', 'w');

    // Set headers for CSV download
    $timestamp = date('Y-m-d_H-i-s');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="hotel_report_' . $timestamp . '.csv"');

    // Add CSV headers
    fputcsv($handle, [
        'S.No',
        'Supplier Name',
        'Expense Title',
        'Amount'
    ]);

    $serialNumber = 1;

    // Loop through suppliers
    foreach ($suppliers as $supplier) {
        // Filter out hotel-related expenses
        $hotelExpenses = $supplier->expenses->filter(function ($expense) {
            return strpos(strtolower($expense->title), 'hotel') !== false;
        });

        $supplierTotal = 0; // Initialize total for each supplier

        // If no hotel expenses are found
        if ($hotelExpenses->isEmpty()) {
            // Write the supplier name with "No hotel expenses"
            fputcsv($handle, [
                $serialNumber++,
                $supplier->name,
                'No hotel expenses',
                '0.00'
            ]);
            continue; // Skip to next supplier if no hotel expenses
        }

        // Write supplier name and leave the rest of the fields blank for the first row
        fputcsv($handle, [
            $serialNumber++,
            $supplier->name,
            '',  // Blank for expense title initially
            ''   // Blank for amount initially
        ]);

        // Loop through hotel expenses for the supplier
        foreach ($hotelExpenses as $expense) {
             $supplierTotal += $expense->amount;
            if ($expense->amount > 0) {
                $expenseAmount = number_format($expense->amount, 2); // Format amount
                fputcsv($handle, [
                    '',  // Blank for serial number
                    '',  // Blank for supplier name
                    $expense->title . ' = ' . $expenseAmount, // Expense title and amount
                   

                ]);
               
                // Track total for the supplier
            }
           
        }

        // Write the total amount for the supplier in the required format
        if ($supplierTotal > 0) {
            fputcsv($handle, [
                '', // Blank for serial number
                '',// Blank for supplier name,
               
                '',
                'Total = ' . number_format($supplierTotal, 2), // Total label
            ]);
        }
    }

    fclose($handle); // Close the CSV handle
    exit;  // Stop further processing
}





}
