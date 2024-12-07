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
        $invoicesQuery = Invoice::with(['user','branch', 'partner', 'package', 'bank', 'currency','services.suplyer.expenses']);
    
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
        // echo "<pre>"; print_r( $invoices->toArray());die;
        if (isset($invoices[0])) {
           $currency_id = $invoices[0]->currency_id;
           $suppliersQuery->where('currency_id', $currency_id);
        } else {
            $currency_id = 0;
            $suppliersQuery->where('currency_id', $currency_id);
        }
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
        $invoicesQuery = Invoice::with(['branch', 'partner', 'package', 'bank', 'currency','services.suplyer.expenses']);
    
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
        if (isset($invoices[0])) {
           $currency_id = $invoices[0]->currency_id;
           $suppliersQuery->where('currency_id', $currency_id);
        } else {
            $currency_id = 0;
            $suppliersQuery->where('currency_id', $currency_id);
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
        // Fetch user and role information
        $user = auth()->user();
        $roleName = auth()->user()->getRoleNames()->first();
        $userIds = User::role($roleName)->pluck('id');

        // Initialize queries
        $invoicesQuery = Invoice::with(['branch', 'package', 'currency', 'user']);
        
        // Apply filters
        if ($request->has('branch') && $request->branch) {
            $invoicesQuery->where('branch_id', $request->branch);
        }

        if ($request->has('year') && $request->year) {
            $invoicesQuery->whereYear('created_at', $request->year);
        }

        if ($request->has('month') && $request->month) {
            $invoicesQuery->whereMonth('created_at', $request->month);
        }

        if ($request->has('package') && $request->package) {
            $invoicesQuery->where('package_id', $request->package);
        }

        if ($request->has('from_date') && $request->from_date && $request->has('to_date') && $request->to_date) {
            $fromDate = Carbon::parse($request->from_date)->startOfDay();
            $toDate = Carbon::parse($request->to_date)->endOfDay();
            $invoicesQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        // Role-based filtering
        $userId = auth()->id();
        if ($userId != 1) {
            $invoicesQuery->where('user_id', $userId);
        }

        if ($user->hasRole($roleName) === 'Administrator') {
            // Admin sees all data
        } elseif ($user->hasRole($roleName)) {
            $invoicesQuery->whereIn('user_id', $userIds);
        }

        $invoices = $invoicesQuery->get();
        if ($invoices->isEmpty()) {
            return redirect()->back()->with('error', 'No data found for the selected filters.');
        }

        // Initialize totals
        $totalInvoiceAmt = 0;
        $totalNetAmt = 0;
        $netProfitAmt = 0;
      
        // Prepare CSV output
        $csvFilename = 'Profit_Loss_Report_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$csvFilename\"",
        ];

        $callback = function () use ($invoices, &$totalInvoiceAmt, &$totalNetAmt, &$netProfitAmt) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF"); // Add BOM for UTF-8

            // Write CSV headers
            fputcsv($file, ['Branch', 'Package', 'Month', 'Year', 'User', 'Created Date', 'Gross Amount', 'Net Cost', 'Net Profit']);
          
            $rates = getCurrencyRate('AED' );      
            // Calculate and write invoice data
            foreach ($invoices as $invoice) {
                // $packageAmt = $invoice->package->amount ?? 0;
                // $netAmtRow = $invoice->package->net_amount ?? 0;
                $currency_code = $invoice->currency->code ?? 'AED';
                $packageAmt = ($invoice->package->amount ?? 0) * ($invoice->no_of_passenger ?? 1);
                $netAmtRow = ($invoice->package->net_amount ?? 0) * ($invoice->no_of_passenger ?? 1);
                if($currency_code =='AED'){
                    $packageAmt = $packageAmt * $rates['AED'];
                    $netAmtRow =   $netAmtRow * $rates['AED'];
                }else if($currency_code =='INR'){
                    $packageAmt = $packageAmt * $rates['INR'];
                    $netAmtRow =   $netAmtRow * $rates['INR'];
                }else if($currency_code =='USD'){
                    $packageAmt = $packageAmt * $rates['USD'];
                    $netAmtRow =   $netAmtRow * $rates['USD'];
                }
                $tax = $invoice->vat ?? 0;
                $discount = $invoice->discount ?? 0;
                $discountAmt = ($invoice->discount_type == 'Fixed') ? $discount : ($packageAmt * $discount) / 100;

                $amountAfterDiscount = $packageAmt - $discountAmt;
                $taxAmt = ($amountAfterDiscount * $tax) / 100;
                $totalAmt = $amountAfterDiscount + $taxAmt;

                $totalInvoiceAmtRow = $totalAmt;
                $netProfitAmtRow = $totalInvoiceAmtRow - $netAmtRow;

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
                    number_format($netAmtRow, 2),
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
