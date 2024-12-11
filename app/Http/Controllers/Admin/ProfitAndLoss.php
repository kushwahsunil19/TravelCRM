<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Invoice,Supplier,Branch,Partner,Package,Bank,Currency,User};
use PDF;
use Carbon\Carbon;

class ProfitAndLoss extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user(); // Get the logged-in user
        $roleName = auth()->user()->getRoleNames()->first(); // Returns the first role name
        $userIds = User::role( $roleName)->pluck('id');
      
        $packages = Package::all();
        $branches = Branch::all();
        $currencies =  Currency::all();
        // Initialize a query builder for Partner
        $suppliersQuery = Supplier::query();
        $invoicesQuery = Invoice::with(['user','branch', 'partner', 'package.expenses', 'bank', 'currency','services.suplyer.expenses']);
    
        // Apply filters if present in the request
        $currency_id  = 0;
        if ($request->has('branch') && $request->branch) {            
            $invoicesQuery->where('branch_id', $request->branch);
          
        }

        if ($request->has('user_id') && $request->user_id) {            
            $invoicesQuery->where('user_id', $request->user_id);
          
        }

        if ($request->has('year') && $request->year) {
          //  echo "turfdse";
            $invoicesQuery->whereYear('created_at', $request->year);
            $suppliersQuery->whereYear('created_at', $request->year);
        }
    
        if ($request->has('month') && $request->month) {          
            $invoicesQuery->whereMonth('created_at', $request->month);
            $suppliersQuery->whereMonth('created_at', $request->month);
        }
    
        if ($request->has('package') && $request->package) {       
            $invoicesQuery->where('package_id', $request->package);
        }

        if ($request->has('from_date') && $request->from_date && $request->has('to_date') && $request->to_date) {          
           $fromDate = Carbon::parse($request->from_date)->startOfDay();
           $toDate = Carbon::parse($request->to_date)->endOfDay();
           $invoicesQuery->whereBetween('created_at', [$fromDate, $toDate]);
           $suppliersQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }
        
         // role base 
         $userId = auth()->id(); 
         if($userId !=1){
         $invoicesQuery->where('user_id',  $userId); 
        }
        if ($user->hasRole($roleName) == 'Administrator') {
          // Admin sees all data, no filters applied
        } elseif ($user->hasRole($roleName)) {            
            $invoicesQuery->whereIn('user_id', $userIds);
        }
        $invoices = $invoicesQuery->get(); 
      
        $suppliers = $suppliersQuery->get();
        $users = User::where('id', '!=', 1)->get();
        if ($request->ajax()) {
    
            // Return only the HTML content for the table if it's an AJAX request
            return response()->json([
                'html' => view('admin.profit-loss.profit-loss-table-ajx', compact('invoices', 'suppliers','currencies'))->render()
            ]);
        }
    
        return view('admin.profit-loss.profit-loss-list', compact('invoices', 'suppliers', 'packages', 'branches','users','currencies'));
    }

    
    
    public function filter(Request $request)
    {
        $invoices = Invoice::with(['branch', 'package', 'currency'])
            ->when($request->year, fn($query, $year) => $query->whereYear('created_at', $year))
            ->when($request->month, fn($query, $month) => $query->whereMonth('created_at', $month))
            ->when($request->branch, fn($query, $branch) => $query->where('branch_id', $branch))
            ->when($request->package, fn($query, $package) => $query->where('package_id', $package))
            ->get();

        return view('invoices.partials.table', compact('invoices'))->render();
    }
    public function downloadPDF(Request $request)
    {
        $user = auth()->user(); // Get the logged-in user
        $roleName = auth()->user()->getRoleNames()->first(); // Returns the first role name
        $userIds = User::role( $roleName)->pluck('id');
      
        $packages = Package::all();
        $branches = Branch::all();
        // Initialize a query builder for Partner
        $suppliersQuery = Supplier::query();
        $invoicesQuery = Invoice::with(['branch', 'partner', 'package.expenses', 'bank', 'currency','services.suplyer.expenses']);
    
        // Apply filters if present in the request
        $currency_id  = 0;
        if ($request->has('user_id') && $request->user_id) {            
            $invoicesQuery->where('user_id', $request->user_id);          
        }
        if ($request->has('branch') && $request->branch) {            
            $invoicesQuery->where('branch_id', $request->branch);
          
        }

        if ($request->has('year') && $request->year) {
          //  echo "turfdse";
            $invoicesQuery->whereYear('created_at', $request->year);
            $suppliersQuery->whereYear('created_at', $request->year);
        }
    
        if ($request->has('month') && $request->month) {          
            $invoicesQuery->whereMonth('created_at', $request->month);
            $suppliersQuery->whereMonth('created_at', $request->month);
        }
    
        if ($request->has('package') && $request->package) {       
            $invoicesQuery->where('package_id', $request->package);
        }

        if ($request->has('from_date') && $request->from_date && $request->has('to_date') && $request->to_date) {          
           $fromDate = Carbon::parse($request->from_date)->startOfDay();
           $toDate = Carbon::parse($request->to_date)->endOfDay();
           $invoicesQuery->whereBetween('created_at', [$fromDate, $toDate]);
           $suppliersQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }
        
         // role base 
         $userId = auth()->id(); 
         if($userId !=1){
         $invoicesQuery->where('user_id',  $userId); 
        }
        if ($user->hasRole($roleName) == 'Administrator') {
          // Admin sees all data, no filters applied
        } elseif ($user->hasRole($roleName)) {            
            $invoicesQuery->whereIn('user_id', $userIds);
        }
        $invoices = $invoicesQuery->get(); 
        if ($invoices->isEmpty()) {
            return redirect()->back()->with('error', 'No Data found for the selected filters.');
        }
       
        $suppliers = $suppliersQuery->get();
        $currencies =  Currency::all();
        // Load the view and pass data to it
        $pdf = PDF::loadView('admin.profit-loss.profit-loss-pdf-format', compact('invoices', 'suppliers','currencies'));
    
        // Generate current timestamp for the file name
        $currentDateTime = now()->format('Y-m-d_H-i-s');
    
        // Return the PDF file
        return $pdf->download('Profit&Loss-' . $currentDateTime . '.pdf');
    }
    
    public function downloadCSV(Request $request)
    {
        $user = auth()->user();
        $roleName = auth()->user()->getRoleNames()->first();
        $userIds = User::role($roleName)->pluck('id');
    
        $invoicesQuery = Invoice::with(['branch', 'package.expenses', 'currency', 'user']);
        
        // Apply filters
        if ($request->has('branch') && $request->branch) $invoicesQuery->where('branch_id', $request->branch);
        if ($request->has('year') && $request->year) $invoicesQuery->whereYear('created_at', $request->year);
        if ($request->has('month') && $request->month) $invoicesQuery->whereMonth('created_at', $request->month);
        if ($request->has('package') && $request->package) $invoicesQuery->where('package_id', $request->package);
        if ($request->has('from_date') && $request->from_date && $request->has('to_date') && $request->to_date) {
            $fromDate = Carbon::parse($request->from_date)->startOfDay();
            $toDate = Carbon::parse($request->to_date)->endOfDay();
            $invoicesQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }
    
        if (auth()->id() != 1) $invoicesQuery->where('user_id', auth()->id());
        if ($user->hasRole($roleName) && $roleName != 'Administrator') $invoicesQuery->whereIn('user_id', $userIds);
    
        $invoices = $invoicesQuery->get();
        if ($invoices->isEmpty()) {
            return redirect()->back()->with('error', 'No data found for the selected filters.');
        }
    
        $rates = getCurrencyRate('AED') ?? ['AED' => 1, 'INR' => 1, 'USD' => 1, 'EUR' => 1];
        $csvFilename = 'Profit_Loss_Report_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$csvFilename\"",
        ];
    
        $totalInvoiceAmt = 0;
        $totalNetAmt = 0;
        $netProfitAmt = 0;
    
        $callback = function () use ($invoices, &$totalInvoiceAmt, &$totalNetAmt, &$netProfitAmt, $rates) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF"); // Add BOM for UTF-8
    
               // Write CSV headers
    fputcsv($file, ['Branch', 'Package', 'Month', 'Year', 'User', 'Created Date', 'Gross Amount', 'Net Cost', 'Net Profit']);

    foreach ($invoices as $invoice) {
        $currencyCode = $invoice->currency->code ?? 'AED';
        $packageAmt = ($invoice->package->amount ?? 0) * ($invoice->no_of_passenger ?? 1);
        $netAmtRow = ($invoice->package->net_amount ?? 0) * ($invoice->no_of_passenger ?? 1);
        $rates = getCurrencyRate($currencyCode);
       if ($currencyCode == 'INR') {
            $packageAmt *= $rates['AED'];
            $netAmtRow *= $rates['AED'];
        } elseif ($currencyCode == 'USD') {
            $packageAmt *= $rates['AED'];
            $netAmtRow *= $rates['AED'];
        } elseif ($currencyCode == 'EUR') {
            $packageAmt *= $rates['AED'];
            $netAmtRow *= $rates['AED'];
        }

        $tax = $invoice->vat ?? 0;
        $discount = $invoice->discount ?? 0;
        $discountAmt = ($invoice->discount_type == 'Fixed') ? $discount : ($packageAmt * $discount) / 100;

        $amountAfterDiscount = $packageAmt - $discountAmt;
        $taxAmt = ($amountAfterDiscount * $tax) / 100;
        $totalAmt = $amountAfterDiscount + $taxAmt;

        // Combine expenses and total into one column
        $packageExpenses = '';
        $totalExpenses = 0;
        if ($invoice->package && $invoice->package->expenses) {
            foreach ($invoice->package->expenses as $expense) {
                $expenseAmount = ($expense->amount * $invoice->no_of_passenger ?? 0) * ($rates[$currencyCode] ?? 1);
                $packageExpenses .= "{$expense->title}: " . number_format($expenseAmount, 2) . ", ";
                $totalExpenses += $expenseAmount;
            }
            $packageExpenses .= "Total: " . number_format($totalExpenses, 2);
        }

        // Adjust net cost by adding total expenses
        $netAmtRow += $totalExpenses;

        // Calculate net profit
        $totalInvoiceAmtRow = $totalAmt;
        $netProfitAmtRow = $totalInvoiceAmtRow - $totalExpenses;

        // Update totals
        $totalInvoiceAmt += $totalInvoiceAmtRow;
        $totalNetAmt += $netAmtRow;
        $netProfitAmt += $netProfitAmtRow;

        // Write data to CSV
        fputcsv($file, [
            $invoice->branch->branch_name ?? '',
            $invoice->package->package_name ?? '',
            \Carbon\Carbon::parse($invoice->created_at)->format('F'),
            \Carbon\Carbon::parse($invoice->created_at)->format('Y'),
            $invoice->user->first_name . ' ' . $invoice->user->last_name ?? '',
            \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y h:i A'),
            number_format($totalInvoiceAmtRow, 2),
            $packageExpenses,
            number_format($netProfitAmtRow, 2),
           
        ]);
    }

    // Add total row
    fputcsv($file, []);
    fputcsv($file, [
        '', '', '', '', '', 'Total Amount',
        number_format($totalInvoiceAmt, 2),
        number_format($totalNetAmt, 2),
        number_format($netProfitAmt, 2),
        '',
    ]);

    fclose($file);
};
        return response()->stream($callback, 200, $headers);
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
}
