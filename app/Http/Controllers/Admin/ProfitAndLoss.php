<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Invoice,Supplier,Branch,Partner,Package,Bank,Currency};
use PDF;
use Carbon\Carbon;

class ProfitAndLoss extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::all();
        $packages = Package::all();
        $branches = Branch::all();
    
        $invoicesQuery = Invoice::with(['branch', 'partner', 'package', 'bank', 'currency']);
    
        // Apply filters if present in the request
        if ($request->has('year') && $request->year) {
          //  echo "turfdse";
            $invoicesQuery->whereYear('created_at', $request->year);
        }
    
        if ($request->has('month') && $request->month) {
          
            $invoicesQuery->whereMonth('created_at', $request->month);
        }
    
        if ($request->has('branch') && $request->branch) {
            
            $invoicesQuery->where('branch_id', $request->branch);
        }
    
        if ($request->has('package') && $request->package) {
       
            $invoicesQuery->where('package_id', $request->package);
        }
        if ($request->has('from_date') && $request->from_date && $request->has('to_date') && $request->to_date) {
          
           $fromDate = Carbon::parse($request->from_date)->startOfDay();
           $toDate = Carbon::parse($request->to_date)->endOfDay();
           $invoicesQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }
        $totalInvoice = $invoicesQuery->count();
        $invoices = $invoicesQuery->paginate($totalInvoice);
     
        if ($request->ajax()) {
    //    print_r($invoices);
    //     print_r($request->all());
    //   die;
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
