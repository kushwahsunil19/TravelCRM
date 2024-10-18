<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuotationReport;
use PDF;
use App\Models\{Quotation,Branch,Partner,Package,Bank};
class QuotationReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Quotation::with(['branch', 'partner', 'package', 'bank']);

    // Apply filters based on user input
    if ($request->filled('quotation_no')) {
        $query->where('quotation_no', 'like', '%' . $request->quotation_no . '%');
    }
    if ($request->filled('branch')) {
        $query->whereHas('branch', function ($q) use ($request) {
            $q->where('city', 'like', '%' . $request->branch . '%');
        });
    }
    if ($request->filled('package')) {
        $query->whereHas('package', function ($q) use ($request) {
            $q->where('package_name', 'like', '%' . $request->package . '%');
        });
    }
    if ($request->filled('partner')) {
        $query->whereHas('partner', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->partner . '%');
        });
    }
    if ($request->filled('discount_type')) {
        $query->where('discount_type', $request->discount_type);
    }

    $rowCount = Quotation::count();
    $quotations = $query->paginate($rowCount);

    return view('admin.quotations.quotation-report', compact('quotations'));
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadPDF(Request $request)
    {
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata'); 
        
        // Reuse the filtering logic from index()
        $query = Quotation::with(['branch', 'partner', 'package', 'bank']);
        
        // Apply filters (same as in the index method)
        if ($request->filled('quotation_no')) {
            $query->where('quotation_no', 'like', '%' . $request->quotation_no . '%');
        }
        if ($request->filled('branch')) {
            $query->whereHas('branch', function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->branch . '%');
            });
        }
        if ($request->filled('package')) {
            $query->whereHas('package', function ($q) use ($request) {
                $q->where('package_name', 'like', '%' . $request->package . '%');
            });
        }
        if ($request->filled('partner')) {
            $query->whereHas('partner', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->partner . '%');
            });
        }
        if ($request->filled('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }
    
        // Get the filtered data
        $quotations = $query->get();
    
        // Check if quotations exist before generating the PDF
        if ($quotations->isEmpty()) {
            return redirect()->back()->with('error', 'No quotations found for the selected filters.');
        }
    
        // Load the PDF view with filtered quotations data
        $pdf = PDF::loadView('admin.quotations.quotation-report-pdf', compact('quotations'));
        
        // Format the date for the filename
        $timestamp = date('Y-m-d_H-i-s');
        $filename = 'quotation_report_' . $timestamp . '.pdf';
        
        // Return the PDF download
        return $pdf->download($filename);
    }
    
    

    public function downloadCSV(Request $request)
    {
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata'); 
    
        // Reuse the filtering logic from index()
        $query = Quotation::with(['branch', 'partner', 'package', 'bank']);
    
        // Apply filters (same as in the index method)
        if ($request->filled('quotation_no')) {
            $query->where('quotation_no', 'like', '%' . $request->quotation_no . '%');
        }
        if ($request->filled('branch')) {
            $query->whereHas('branch', function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->branch . '%');
            });
        }
        if ($request->filled('package')) {
            $query->whereHas('package', function ($q) use ($request) {
                $q->where('package_name', 'like', '%' . $request->package . '%');
            });
        }
        if ($request->filled('partner')) {
            $query->whereHas('partner', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->partner . '%');
            });
        }
        if ($request->filled('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }
    
        // Get the filtered data
        $quotations = $query->get();
    
        // Check if quotations exist before generating the CSV
        if ($quotations->isEmpty()) {
            return redirect()->back()->with('error', 'No quotations found for the selected filters.');
        }
    
        // Create a CSV handle
        $handle = fopen('php://output', 'w');
    
        // Format the date for the filename
        $timestamp = date('Y-m-d_H-i-s');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="quotation_report_' . $timestamp . '.csv"');
    
        // Add CSV headers
        fputcsv($handle, [
            'S.No',
            'Quotation No',
            'Branch',
            'Package',
            'Partner',
            'Discount Type',
            'Discount',
            'VAT',
        ]);
        $serialNumber = 1;

        // Add the filtered data rows
        foreach ($quotations as $quotation) {
            fputcsv($handle, [
                $serialNumber++,
                $quotation->quotation_no,
                $quotation->branch ? $quotation->branch->city : 'N/A',
                $quotation->package ? $quotation->package->package_name : 'N/A',
                $quotation->partner->name . ' (' . $quotation->partner->email . ')',
                $quotation->discount_type,
                $quotation->discount . ($quotation->discount_type == 'Fixed' ? '' : '%'),
                $quotation->gst_tax . '%',
            ]);
        }
    
        fclose($handle);
        exit;
    }
    

   

}
