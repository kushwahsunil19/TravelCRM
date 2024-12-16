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
            $userData = User::with(['invoices'])->get();
            $totalEstimate = Quotation::count(); // Count total quotations
           if($role=='Administrator') {          
            $userCount = User::where('id', '!=', 1)->count(); // Exclude user with ID = 1 if needed
            
            }else{          
            $userCount =  User::role($role)->count();
            $totalEstimate = Quotation::where('user_id', '=', $userId)->count(); // Count total quotations
            $userData = User::with(['invoices' => function($query) use ($userId) {
                $query->where('user_id', '=', $userId);  // Filter invoices where user_id is not equal to the provided userId
            }])->get();
           }    
         
           $totalAmount = 0;
           $totalNetAmount = 0;
           
           foreach ($userData as $user) { // Loop through each user
               $grossAmountRow = 0;
               $netAmountRow = 0;
           
               if ($user->invoices->isNotEmpty()) { // Check if the user has invoices
                   foreach ($user->invoices as $invoice) { // Loop through each invoice of the user
                       $grossAmount = ($invoice->package->amount ?? 0) * ($invoice->no_of_passenger ?? 1);                                 
                       // Currency Conversion
                       $grossAmount = getCurrencyRateAmt($invoice->currency->code, 'AED', ($grossAmount));
                       $netAmount = getCurrencyRateAmt($invoice->currency->code, 'AED', ($invoice->package->net_amount ?? 0));
           
                       // Apply Discounts
                       $discount = $invoice->discount ?? 0;
                       $discountAmount = ($invoice->discount_type === 'Fixed') 
                           ? getCurrencyRateAmt($invoice->currency->code, 'AED', $discount) 
                           : ($grossAmount * $discount) / 100;
           
                       // Apply Tax
                       $taxRate = $invoice->vat ?? 0;
                       $amountAfterDiscount = $grossAmount - $discountAmount;
                       $taxAmount = ($amountAfterDiscount * $taxRate) / 100;
           
                       $grossAmount = $amountAfterDiscount + $taxAmount;
           
                       // Accumulate totals for the current user
                       $grossAmountRow += $grossAmount;
                       $netAmountRow += $netAmount;
                   }
               }
           
               // Accumulate totals across all users
               $totalAmount += $grossAmountRow;
               $totalNetAmount += $netAmountRow;
           }
           
           // Total Estimates and Invoices
          
           $totalInvoice = $userData->sum(fn($user) => $user->invoices->count()); // Sum of all invoices for all users
           
     
           
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
