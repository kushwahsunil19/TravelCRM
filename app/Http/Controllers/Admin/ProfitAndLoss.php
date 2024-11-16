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
        // Initialize a query builder for Partner
        $suppliersQuery = Supplier::query();
        $invoicesQuery = Invoice::with(['branch', 'partner', 'package', 'bank', 'currency','services.suplyer.expenses']);
    
        // Apply filters if present in the request
        $currency_id  = 0;
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
        if ($user->hasRole($roleName) === 'Administrator') {
          // Admin sees all data, no filters applied
        } elseif ($user->hasRole($roleName)) {            
            $invoicesQuery->whereIn('user_id', $userIds);
        }
        $invoices = $invoicesQuery->get(); 
      //    echo "<pre>"; print_r( $invoices->toArray());die;
        if (isset($invoices[0])) {
           $currency_id = $invoices[0]->currency_id;
           $suppliersQuery->where('currency_id', $currency_id);
        } else {
            $currency_id = 0;
            $suppliersQuery->where('currency_id', $currency_id);
        }
        $suppliers = $suppliersQuery->get();
        
        if ($request->ajax()) {
    
            // Return only the HTML content for the table if it's an AJAX request
            return response()->json([
                'html' => view('admin.profit-loss.profit-loss-table-ajx', compact('invoices', 'suppliers'))->render()
            ]);
        }
    
        return view('admin.profit-loss.profit-loss-list', compact('invoices', 'suppliers', 'packages', 'branches'));
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
        $invoicesQuery = Invoice::with(['branch', 'partner', 'package', 'bank', 'currency','services']);
    
        // Apply filters if present in the request
        $currency_id  = 0;
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
        if ($user->hasRole($roleName) === 'Administrator') {
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
    
        // Load the view and pass data to it
        $pdf = PDF::loadView('admin.profit-loss.profit-loss-pdf-format', compact('invoices', 'suppliers'));
    
        // Generate current timestamp for the file name
        $currentDateTime = now()->format('Y-m-d_H-i-s');
    
        // Return the PDF file
        return $pdf->download('Profit&Loss-' . $currentDateTime . '.pdf');
    }
    public function downloadCSV(Request $request)
    {
        $user = auth()->user(); // Get the logged-in user
        $roleName = auth()->user()->getRoleNames()->first(); // Returns the first role name
        $userIds = User::role( $roleName)->pluck('id');
      
        $packages = Package::all();
        $branches = Branch::all();
        // Initialize a query builder for Partner
        $suppliersQuery = Supplier::query();
        $invoicesQuery = Invoice::with(['branch', 'partner', 'package', 'bank', 'currency','services']);
    
        // Apply filters if present in the request
        $currency_id  = 0;
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
        if ($user->hasRole($roleName) === 'Administrator') {
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
        // Calculate Total Income and Net Income
        $totalInvoiceAmt = 0;
        foreach ($invoices as $invoice) {
            $package_amt = $invoice->package->amount ?? 0;
            $tax = $invoice->vat ?? 0;
            $discount = $invoice->discount ?? 0;
            $discount_amt = ($invoice->discount_type == 'Fixed') ? $discount : ($package_amt * $discount) / 100;
            $amount_after_discount = $package_amt - $discount_amt;
            $tax_amt = ($amount_after_discount * $tax) / 100;
            $total_amt = $amount_after_discount + $tax_amt;
            $totalInvoiceAmt += $total_amt;
        }
    
        $totalExpenseAmt = $suppliers->sum('amount');
        $netIncome = $totalInvoiceAmt - $totalExpenseAmt;
    
        // Prepare the CSV output
        $csvFilename = 'Profit&Loss-' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$csvFilename\"",
        ];
    
        // Prepare the callback for CSV generation
        $callback = function() use ($invoices, $suppliers, $totalInvoiceAmt, $totalExpenseAmt, $netIncome) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            // Write the headers
            fputcsv($file, ['Branch', 'Package', 'Partner', 'Month', 'Year', 'Amount',]);
    
            // Write the invoices data
            foreach ($invoices as $invoice) {
                $package_amt = $invoice->package->amount ?? 0;
                $symbol = $invoices->first()->currency->symbol ?? '';
                $tax = $invoice->vat ?? 0;
                $discount = $invoice->discount ?? 0;
                $discount_amt = ($invoice->discount_type == 'Fixed') ? $discount : ($package_amt * $discount) / 100;
                $amount_after_discount = $package_amt - $discount_amt;
                $tax_amt = ($amount_after_discount * $tax) / 100;
                $total_amt = $amount_after_discount + $tax_amt;
                $month = \Carbon\Carbon::parse($invoice->created_at)->format('F'); // Full month name
                $year = \Carbon\Carbon::parse($invoice->created_at)->format('Y');
                fputcsv($file, [
                    $invoice->branch->branch_name ?? '',
                    $invoice->package->package_name ?? '',
                    $invoice->partner->name ?? '',
                    $month, // get month 
                    $year, // get year 
                    $symbol . ' ' . number_format($total_amt, 2),
                 
                   
                ]);
            }
    
            // Optionally, write the suppliers data if needed
            // fputcsv($file, []); // Empty row separator (optional)
            // fputcsv($file, ['Suppliers', '', '', '', '', '']);
            // foreach ($suppliers as $supplier) {
            //     fputcsv($file, [
            //         $supplier->name ?? '',
            //         '', // Package column left blank for suppliers
            //         '', // Partner column left blank for suppliers
            //         number_format($supplier->amount, 2),
            //         $supplier->created_at->format('Y-m-d'),
            //         'INR', // Assuming suppliers' currency is INR (change if needed)
            //     ]);
            // }
    
            // Add Total Income, Total Expense, and Net Income to the CSV
            fputcsv($file, []);
         
            fputcsv($file, ['Total Income', '', '','', '', $symbol . ' ' . number_format($totalInvoiceAmt, 2)]);
            fputcsv($file, ['Total Expense', '','', '', '', $symbol . ' ' . number_format($totalExpenseAmt, 2)]);
            fputcsv($file, ['Net Income', '','', '', '',$symbol . ' ' .  number_format($netIncome, 2)]);
    
            fclose($file);
        };
    
        // Return the response to trigger the file download
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
