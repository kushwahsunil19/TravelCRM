<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\{Invoice,Quotation,Branch,Partner,Package,Bank,Currency,Country,State,City,Supplier,Service,User};

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $userId = $user->id; 
            $role = $user->roles->first()->name ?? 'No role assigned';
            $userIds = User::role( $role)->pluck('id');
            $invoicesQuery = Invoice::with([ 'package', 'currency','services.suplyer.expenses']);
           if($role=='Administrator') {
          
            $userCount = User::where('id', '!=', 1)->count(); // Exclude user with ID = 1 if needed
           }else{
            $invoicesQuery->whereIn('user_id', $userIds);
            $userCount =  User::role($role)->count();
           }
            $invoices = $invoicesQuery->get(); 
            $totalAmount = 0;
            $totalNetAmount = 0;
        
            foreach ($invoices as $invoice) {
                if (isset($invoice['package'])) {
                    $totalAmount += $invoice['package']['amount'] ?? 0;
                    $totalNetAmount += $invoice['package']['net_amount'] ?? 0;
                }
            }
         
            $totalEstimate = Quotation::count();        
            $totalInvoice = Invoice::where('user_id', $userId)->count();
            $totalExpenses = Supplier::where('status', 'active')->sum('amount');

           
            $totalIncome = round((float) $totalAmount, 2);
            $netProfit = round((float) ($totalAmount - $totalNetAmount), 2);
            $totalExpenses = round((float) $totalNetAmount, 2);
       
            return view('admin.dashboard',compact(['userCount','totalEstimate','totalInvoice','totalExpenses','totalIncome','netProfit']));
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
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
