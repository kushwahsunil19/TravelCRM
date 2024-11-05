<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use PDF;
class ExpensesReportController extends Controller
{
   
   
    public function index(Request $request)
    {
        // Initialize the query
        $query = Supplier::query();

        // Apply filters based on request input
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('title')) {
            $query->whereHas('expenses', function($query) use ($request) {
                $query->where('title', 'like', '%' . $request->title . '%');
            });
        }

        // New email filter
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Get the filtered suppliers with their expenses
        $Suppliers = $query->with('expenses')->get();

        return view('admin.expenses.index', compact('Suppliers'));
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

        if ($request->filled('title')) {
            $query->whereHas('expenses', function($query) use ($request) {
                $query->where('title', 'like', '%' . $request->title . '%');
            });
        }

        // New email filter
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Get the filtered data
        $suppliers = $query->with('expenses')->get();

        // Check if suppliers exist before generating the PDF
        if ($suppliers->isEmpty()) {
            return redirect()->back()->with('error', 'No suppliers found for the selected filters.');
        }

        // Generate the PDF
        $pdf = PDF::loadView('admin.expenses.Expenses-report-pdf', compact('suppliers'));

        // Generate the filename with correct format
        $timestamp = date('Y-m-d_H-i-s');
        $filename = 'Expenses_report' . $timestamp . '.pdf';

        // Return the PDF with the correct headers
        return $pdf->download($filename);
    }

    public function downloadCSV(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');

        // Initialize the query
        $query = Supplier::query();

        // Apply filters based on request input
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('title')) {
            $query->whereHas('expenses', function($query) use ($request) {
                $query->where('title', 'like', '%' . $request->title . '%');
            });
        }

        // New email filter
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Get the filtered data with expenses
        $suppliers = $query->with('expenses')->get();

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
            'date',
            'Amount'
        ]);

        $serialNumber = 1;

        // Add the filtered data rows
        foreach ($suppliers as $supplier) {
            $supplierTotal = 0; // Initialize total for each supplier

            // Check if the supplier has expenses
            if ($supplier->expenses->isEmpty()) {
                fputcsv($handle, [
                    $serialNumber++,
                    $supplier->name,
                    'No expenses',
                    '0.00'
                ]);
                continue;
            }

            // Display supplier name
            fputcsv($handle, [
                $serialNumber++,
                $supplier->name,
                '', // Blank for expense title initially
                ''  // Blank for amount initially
            ]);

            // Add the expenses for the supplier
            foreach ($supplier->expenses as $expense) {
                if ($expense->amount > 0) {
                    $expenseAmount = number_format($expense->amount, 2); // Format amount
                    fputcsv($handle, [
                        '',
                        '',
                        $expense->title . ' = ' . $expenseAmount,
                        $expenseAmount
                    ]);
                    $supplierTotal += $expense->amount; // Track total amount for the supplier
                }
            }

            // Show the total for the supplier
            if ($supplierTotal > 0) {
                fputcsv($handle, [
                    '',
                    '',
                    'Total = ' . number_format($supplierTotal, 2),
                    number_format($supplierTotal, 2)
                ]);
            }
        }

        fclose($handle);
        exit;
    }
}
