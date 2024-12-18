<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Package;
use App\Models\PackageExpense;

class HotelReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::query();
    
        // Apply filters based on request input
        if ($request->filled('name')) {
            $query->where('package_name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->filled('email')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->email . '%');
            });
        }
    
        // Get the filtered packages with their hotel-related expenses
        $packages = $query->with(['expenses' => function ($query) {
            $query->where('title', 'like', '%hotel%'); // Filter for hotel-related expenses
        }])->get();
    
        // Calculate the total hotel expenses for each package
        foreach ($packages as $package) {
            $package->totalHotelAmount = $package->expenses->sum('amount');
        }
    
        $Packages = Package::with(['user', 'expenses'])->get();

        return view('admin.expenses.hotel-report', compact('Packages'));
        
    }
    

    /**
     * Download PDF report.
     */
    public function downloadPDF(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');

        $query = Package::query();

        if ($request->filled('name')) {
            $query->where('package_name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->email . '%');
            });
        }

        $packages = $query->with(['expenses' => function ($query) {
            $query->where('title', 'like', '%hotel%');
        }])->get();

        if ($packages->isEmpty()) {
            return redirect()->back()->with('error', 'No packages found for the selected filters.');
        }

        foreach ($packages as $package) {
            $package->totalHotelAmount = $package->expenses->sum('amount');
        }

        $pdf = PDF::loadView('admin.expenses.hotel-report-pdf', compact('packages'));

        $timestamp = date('Y-m-d_H-i-s');
        $filename = 'hotel_report_' . $timestamp . '.pdf';

        return $pdf->download($filename);
    }

    public function downloadCSV(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');

        $query = Package::query();

        if ($request->filled('name')) {
            $query->where('package_name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->email . '%');
            });
        }

        $packages = $query->with(['expenses' => function ($query) {
            $query->where('title', 'like', '%hotel%');
        }])->get();

        if ($packages->isEmpty()) {
            return redirect()->back()->with('error', 'No packages found for the selected filters.');
        }

        $handle = fopen('php://output', 'w');
        $timestamp = date('Y-m-d_H-i-s');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="hotel_report_' . $timestamp . '.csv"');

        fputcsv($handle, ['S.No', 'Package Name', 'Expense Title', 'Amount']);

        $serialNumber = 1;

        foreach ($packages as $package) {
            $hotelExpenses = $package->expenses->filter(function ($expense) {
                return strpos(strtolower($expense->title), 'hotel') !== false;
            });

            $packageTotal = 0;

            if ($hotelExpenses->isEmpty()) {
                fputcsv($handle, [$serialNumber++, $package->package_name, 'No hotel expenses', '0.00']);
                continue;
            }

            fputcsv($handle, [$serialNumber++, $package->package_name, '', '']);

            foreach ($hotelExpenses as $expense) {
                $packageTotal += $expense->amount;
                fputcsv($handle, ['', '', $expense->title, number_format($expense->amount, 2)]);
            }

            fputcsv($handle, ['', '', 'Total', number_format($packageTotal, 2)]);
        }

        fclose($handle);
        exit;
    }
}
