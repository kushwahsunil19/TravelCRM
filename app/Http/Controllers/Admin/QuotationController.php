<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Quotation,Invoice,Branch,Partner,Package,Bank,Currency};
use PDF;
use Spatie\Permission\Models\Role;

class QuotationController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    //    $this->middleware('permission:list-quotation', ['only' => ['index']]);

    //    $this->middleware('permission:create-quotation|edit-quotation|delete-quotation', ['only' => ['index','show']]);
    //    $this->middleware('permission:create-quotation', ['only' => ['create','store']]);
    //    $this->middleware('permission:edit-quotation', ['only' => ['edit','update']]);
    //    $this->middleware('permission:delete-quotation', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the quotations.
     */

     public function index(Request $request)
     {
         // Get the total number of quotations
         $totalQuotations = Quotation::count();
     
         // Build the query for fetching quotations with the necessary relationships
         $query = Quotation::with(['branch', 'partner', 'package', 'bank']);
     
         // Apply filters based on request parameters
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
         $totalQuotations = Quotation::count();
     
         // Paginate the filtered results (you can adjust the number per page as needed)
         $quotations = $query->paginate(10); // Paginate the filtered results
     
         // Return the view with total quotations and paginated quotations
         return view('admin.quotations.index', compact('quotations', 'totalQuotations'));
     }
     


    /**
     * Show the form for creating a new quotation.
     */
    public function create()
    {
        $quotation = Quotation::with(['branch', 'partner', 'package'])
                      ->latest('id')  // Sort by the latest ID
                      ->first(); 
         $quotation_no = 100;           
        if(isset( $quotation->id)){
            $quotation_no =  $quotation->quotation_no +1 ;
        }   
       
        $branches = Branch::all();
        $partners = Partner::all();
        $packages = Package::all();
        $currencies = Currency::all();
        $bankDetails = Bank::latest()->get();
        return view('admin.quotations.create', compact('branches', 'partners', 'packages','quotation_no','bankDetails','currencies'));
    }

    /**
     * Store a newly created quotation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'partner_id' => 'required|exists:partners,id',
            'package_id' => 'required|exists:packages,id',
            'currency_id' => 'required|exists:currencies,id',
            'bank_id' => 'required|exists:bank_details,id',           
            'twin_double_sharing_cost' => 'nullable|numeric',
            'triple_sharing_cost' => 'nullable|numeric',
            'child_extra_bed_cost' => 'nullable|numeric',
            // 'child_no_extra_bed_cost' => 'nullable|numeric',
            'gst_tax' => 'nullable|numeric',
            'discount_type' => 'required',            
            'discount' => 'nullable|numeric',
        ]);
       
        $quotation = Quotation::create($request->all());

        return redirect()->route('quotations.edit', $quotation->id)
                         ->with('success', 'Quotation created successfully and you are now editing it.');
    
    }

    /**
     * Display the specified quotation.
     */
    public function show(Quotation $quotation)
    {
        return view('admin.quotations.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified quotation.
     */
    public function edit(Quotation $quotation)
    {
      
        $branches = Branch::all();
        $partners = Partner::all();
        $packages = Package::all();
        $currencies = Currency::all();

        $bankDetails = Bank::latest()->get();

        return view('admin.quotations.edit', compact('quotation', 'branches', 'partners', 'packages','bankDetails','currencies'));
    }

    /**
     * Update the specified quotation in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'partner_id' => 'required|exists:partners,id',
            'package_id' => 'required|exists:packages,id',
            'currency_id' => 'required|exists:currencies,id',
            'bank_id' => 'required|exists:bank_details,id',
            'quotation_no' => 'required|unique:quotations,quotation_no,' . $quotation->id,
            'twin_double_sharing_cost' => 'nullable|numeric',
            'triple_sharing_cost' => 'nullable|numeric',
            'child_extra_bed_cost' => 'nullable|numeric',
            'child_no_extra_bed_cost' => 'nullable|numeric',
            'gst_tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $quotation->update($request->all());

        return redirect()->route('quotations.edit', $quotation->id)
                         ->with('success', 'Quotation updated successfully.');
    }

    /**
     * Remove the specified quotation from storage.
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->delete();

        return redirect()->route('quotations.index')
                         ->with('success', 'Quotation deleted successfully.');
    }


    public function generateQuotationPDF($id)
    {
        // Fetch the quotation by ID from the database
        $quotation = Quotation::with(['branch', 'partner', 'package','bank','currency'])->findOrFail($id);
      
        // Get the package amount
        $package_amt = $quotation->package->amount;

        // GST Tax in percentage
        $tax = $quotation->gst_tax;

        // Discount in percentage
        $discount = $quotation->discount;
        if($quotation->discount_type=='Fixed'){
            $discount_amt =  $discount;
        }else{
            $discount_amt = ($package_amt * $discount) / 100;
        }
        // Calculate discount amount (discount percentage applied to the package amount)
       

        // Amount after discount
        $amount_after_discount = $package_amt - $discount_amt;

        // Calculate tax amount (GST percentage applied to the amount after discount)
        $tax_amt = ($amount_after_discount * $tax) / 100;

        // Total amount after applying discount and adding tax
        $total_amt = $amount_after_discount + $tax_amt;

        $currentDateTime = now()->format('Y-m-d_H-i-s');  // e.g., 2024-10-04_14-30-00
        $items = [];
    
        if ($quotation->package) {
            $items[] = [
                'package_name' => $quotation->package->package_name,
                'description' => $quotation->package->description,
                'amount' => $quotation->package->amount,
            ];
        }

        // Example: Adjust these fields based on your `quotations` table structure
        $data = [
            'currency_code'=>$quotation->currency->code,
            'curreny_symbol'=>$quotation->currency->symbol,
            'branch_address'=>$quotation->branch->address,
            'branch_name'=>$quotation->branch->branch_name,
            'quotation_date' => now()->toDateString(),
            'quotation_number' => $quotation->quotation_no,  // Assume there's an invoice number
            'bill_to' => $quotation->partner->name,  // Assuming you have customer info in your quotation
            'bill_email' => $quotation->partner->email,  // Assuming you have customer info in your quotation
            'bill_mobile' => $quotation->partner->mobile,  // Assuming you have customer info in your quotation
            'bill_city' => $quotation->partner->city,  // Assuming you have customer info in your quotation
            'bill_state' => $quotation->partner->state,
            'bill_country' => $quotation->partner->country,
            'items' => $items ,  // Assuming a relationship or JSON field for items
            'subtotal' =>  $package_amt ,
            'discount'=> $discount,
            'discount_type'=> $quotation->discount_type,
            'tax' => $tax,  // Assuming a field for VAT
            'total' =>  $total_amt,
            'bank_name'=> isset($quotation->bank->bank_name)?$quotation->bank->bank_name:'',
            'account_no'=> isset($quotation->bank->account_no)?$quotation->bank->account_no:'',
            'bank_branch'=> isset($quotation->bank->branch_name)?$quotation->bank->branch_name:'',
            'ifsc_code'=> isset($quotation->bank->ifsc_code)?$quotation->bank->ifsc_code:'',
            'iban_no'=> isset($quotation->bank->iban_no)?$quotation->bank->iban_no:'',
        ];
        
        // Load the view and pass data to it
        $pdf = PDF::loadView('admin.quotations.quotation_format', $data);

        // Return the PDF file
        return $pdf->download('Quotation-' . $currentDateTime . '.pdf');
    }
    
    public function preview($id)
    {
        // Fetch the quotation by ID from the database
        $quotation = Quotation::with(['branch', 'partner', 'package','bank','currency'])->findOrFail($id);
      
        // Get the package amount
        $package_amt = $quotation->package->amount;

        // GST Tax in percentage
        $tax = $quotation->gst_tax;

        // Discount in percentage
        $discount = $quotation->discount;

        // Calculate discount amount (discount percentage applied to the package amount)
        if($quotation->discount_type=='Fixed'){
            $discount_amt =  $discount;
        }else{
            $discount_amt = ($package_amt * $discount) / 100;
        }

        // Amount after discount
        $amount_after_discount = $package_amt - $discount_amt;

        // Calculate tax amount (GST percentage applied to the amount after discount)
        $tax_amt = ($amount_after_discount * $tax) / 100;

        // Total amount after applying discount and adding tax
        $total_amt = $amount_after_discount + $tax_amt;

        $currentDateTime = now()->format('Y-m-d_H-i-s');  // e.g., 2024-10-04_14-30-00
        $items = [];
    
        if ($quotation->package) {
            $items[] = [
                'package_name' => $quotation->package->package_name,
                'description' => $quotation->package->description,
                'amount' => $quotation->package->amount,
            ];
        }

        // Example: Adjust these fields based on your `quotations` table structure
        $data = [
            'currency_code'=>$quotation->currency->code,
            'curreny_symbol'=>$quotation->currency->symbol,
            'branch_address'=>$quotation->branch->address,
            'branch_name'=>$quotation->branch->branch_name,
            'quotation_date' => now()->toDateString(),
            'quotation_number' => $quotation->quotation_no,  // Assume there's an invoice number
            'bill_to' => $quotation->partner->name,  // Assuming you have customer info in your quotation
            'bill_email' => $quotation->partner->email,  // Assuming you have customer info in your quotation
            'bill_mobile' => $quotation->partner->mobile,  // Assuming you have customer info in your quotation
            'bill_city' => $quotation->partner->city,  // Assuming you have customer info in your quotation
            'bill_state' => $quotation->partner->state,
            'bill_country' => $quotation->partner->country,
            'items' => $items ,  // Assuming a relationship or JSON field for items
            'subtotal' =>  $package_amt ,
            'discount'=> $discount,
            'discount_type'=> $quotation->discount_type,
            'tax' => $tax,  // Assuming a field for VAT
            'total' =>  $total_amt,
            'bank_name'=> isset($quotation->bank->bank_name)?$quotation->bank->bank_name:'',
            'account_no'=> isset($quotation->bank->account_no)?$quotation->bank->account_no:'',
            'bank_branch'=> isset($quotation->bank->branch_name)?$quotation->bank->branch_name:'',
            'ifsc_code'=> isset($quotation->bank->ifsc_code)?$quotation->bank->ifsc_code:'',
            'iban_no'=> isset($quotation->bank->iban_no)?$quotation->bank->iban_no:'',
        ];
        
        // Load the view and pass data to it
     return view('admin.quotations.preview', compact('data'));
    }
        public function addBankDetail(Request $request){

            $request->validate([
                'bank_name' => 'required|string|max:255',
                'account_no' => 'required|numeric',
                'branch_name' => 'required|string|max:255',
                'ifsc_code' => 'required',
            ]);
    
            // Create new bank detail
            $bankDetail = Bank::create([
                'bank_name' => $request->bank_name,
                'account_no' => $request->account_no,
                'branch_name' => $request->branch_name,
                'ifsc_code' => $request->ifsc_code,
                'iban_no' => $request->iban_no,
            ]);
            $bankDetails = Bank::latest()->get();
            return response()->json(['status'=>true,'data'=>$bankDetails ,'message' => 'Bank details added successfully']);
        }
        public function convertToInvoice($id){

            $quotation = Quotation::with(['branch', 'partner', 'package','bank'])->findOrFail($id);
            $invoice = Invoice::with(['branch', 'partner', 'package'])
            ->latest('id')  // Sort by the latest ID
            ->first(); 
            $invoice_no = 100;           
            if(isset( $invoice->id)){
            $invoice_no =  $invoice->invoice_no +1 ;
            }   
            $existingInvoice = Invoice::where('branch_id', $quotation->branch_id)
            ->where('partner_id', $quotation->partner_id)
            ->where('package_id', $quotation->package_id)
            ->where('bank_id', $quotation->bank_id)
            ->where('vat', $quotation->gst_tax)
            ->where('discount_type', $quotation->discount_type)
            ->where('note', $quotation->note)
            ->where('term_condition', $quotation->term_condition)
            ->first();
    
        // If an invoice with the same invoice_no and attributes exists, avoid updating it
        if (!$existingInvoice) {
            $invoice = Invoice::create([
                'invoice_no' => $invoice_no,
                'branch_id' => $quotation->branch_id,
                'partner_id' => $quotation->partner_id,
                'package_id' => $quotation->package_id,
                'currency_id' => $quotation->currency_id,
                'bank_id' => $quotation->bank_id,
                'vat' => $quotation->gst_tax, // Assuming total amount is mapped
                'discount_type' => $quotation->discount_type,               
                'discount' => $quotation->discount,
                'note' => $quotation->note,
                'term_condition' => $quotation->term_condition,
            ]);
        }else{
            $invoice = Invoice::updateOrCreate(
                [  
                    'id' => $existingInvoice->id,                     
                ], // The unique key for the invoice (could be quotation_id)
                [
                  
                    'branch_id' => $quotation->branch_id,
                    'partner_id' => $quotation->partner_id,
                    'package_id' => $quotation->package_id,
                    'currency_id' => $quotation->currency_id,
                    'bank_id' => $quotation->bank_id,
                    'vat' => $quotation->gst_tax, // Assuming total amount is mapped
                    'discount_type' =>$quotation->discount_type, // Or any other status you want to set                 
                    'discount' =>$quotation->discount,
                    'note' =>$quotation->note,
                    'term_condition' =>$quotation->term_condition,                    

                ]
            );
        }
            return redirect()->route('invoices.edit', $invoice->id);
          
        }
      /**
     * Restore a soft-deleted package.
     */
    public function restore($id)
    {
        $package = Quotation::withTrashed()->findOrFail($id);
        $package->restore();

        return redirect()->route('quotations.index')->with('success', 'Quotation restored successfully.');
    }
}