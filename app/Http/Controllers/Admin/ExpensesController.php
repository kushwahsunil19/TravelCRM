<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
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
