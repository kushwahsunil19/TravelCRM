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
    $query = Quotation::with(['user','branch', 'partner', 'package.expenses', 'bank','currency','services.suplyer.expenses']);

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
        $query = Quotation::with(['branch', 'partner', 'package.expenses', 'bank']);
        
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
        // Set timezone
        date_default_timezone_set('Asia/Kolkata');
    
        // Query with necessary relations
        $query = Quotation::with(['user', 'branch', 'partner', 'package.expenses', 'bank', 'currency']);
    
        // Apply filters
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
    
        $quotations = $query->get();
    
        if ($quotations->isEmpty()) {
            return redirect()->back()->with('error', 'No quotations found for the selected filters.');
        }
    
        // Prepare CSV file
        $timestamp = date('Y-m-d_H-i-s');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="quotation_report_' . $timestamp . '.csv"');
    
        $handle = fopen('php://output', 'w');
    
        // CSV headers
        fputcsv($handle, [
            'S.No',
            'Quotation No',
            'Branch',
            'Package',
            'Partner',
            'Discount Type',
            'Discount',
            'VAT',
            'Gross Amount',
            'Net Cost',
            'Net Profit',
        ]);
    
        $serialNumber = 1;
        $totalGrossAmount = 0;
        $totalNetCost = 0;
        $totalNetProfit = 0;
    
        $symbol = '(AED)';
    
        foreach ($quotations as $quotation) {
            $currencyCode = $quotation->currency->code ?? 'AED';
            $rates = getCurrencyRate($currencyCode);
            $grossAmount = ($quotation->package->amount ?? 0) * ($quotation->no_of_passenger ?? 1);
            $netCost = ($quotation->package->net_amount ?? 0) * ($quotation->no_of_passenger ?? 1);
           
            if($currencyCode == 'INR') {
                $grossAmount *= $rates['AED'];
                $netCost *= $rates['AED'];
            }else if($currencyCode == 'USD'){              
                $grossAmount *= $rates['AED'];
                $netCost *= $rates['AED'];
            }
    
            $discount = $quotation->discount ?? 0;
            $discountAmount = $quotation->discount_type === 'Fixed'
                ? $discount
                : ($grossAmount * $discount) / 100;
    
                $packageExpenses = '';
                $totalExpenses = 0;
                if ($quotation->package && $quotation->package->expenses) {
                    foreach ($quotation->package->expenses as $expense) {
                        $expenseAmount = ($expense->amount * $quotation->no_of_passenger ?? 0) * ($rates['AED'] ?? 1);
                        $packageExpenses .= "{$expense->title}: " . number_format($expenseAmount, 2) . ", ";
                        $totalExpenses += $expenseAmount;
                    }
                    $packageExpenses .= "Total: " . number_format($totalExpenses, 2);
                }
        
            
    
            $netCost += $totalExpenses;
            $vatAmount = ($grossAmount - $discountAmount) * ($quotation->gst_tax / 100);
            $netProfit = $grossAmount - $totalExpenses;
    
            $totalGrossAmount += $grossAmount;
            $totalNetCost += $netCost;
            $totalNetProfit += $netProfit;
    
            fputcsv($handle, [
                $serialNumber++,
                $quotation->quotation_no,
                $quotation->branch->city ?? 'N/A',
                $quotation->package->package_name ?? 'N/A',
                $quotation->partner->name ?? 'N/A',
                $quotation->discount_type ?? 'N/A',
                $quotation->discount . ($quotation->discount_type === 'Fixed' ? '' : '%'),
                $quotation->gst_tax . '%',
                number_format($grossAmount, 2),
                $packageExpenses,
                number_format($netProfit, 2),
            ]);
        }
    
        // Totals row
        fputcsv($handle, [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'Total',
            $symbol . number_format($totalGrossAmount, 2),
            $symbol . number_format($totalNetCost, 2),
            $symbol . number_format($totalNetProfit, 2),
        ]);
    
        fclose($handle);
        exit;
    }
    
    
    
    
    
    

   

}
