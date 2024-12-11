<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Quotation,Invoice,Branch,Partner,Package,Bank,Currency,City,Country,State,Supplier,Service,TmpService,CompanyBankDetail};
use PDF;
use Spatie\Permission\Models\Role;
use Mpdf\Mpdf;

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

        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $suppliers = Supplier::all();
        $userRole = auth()->user()->roles->first()->name; // Assuming the user has only one role
        $rolePermissions = getRolePermissions();   
        if (in_array('list-quotation', $rolePermissions[$userRole])) { 
         // Get the total number of quotations
         $totalQuotations = Quotation::count();
     
         // Build the query for fetching quotations with the necessary relationships
         $query = Quotation::with(['branch.companyBankDetail', 'partner', 'package', 'bank']);
     
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
         $quotations = $query->paginate( $totalQuotations); // Paginate the filtered results
         
         // Return the view with total quotations and paginated quotations
         return view('admin.quotations.index', compact('quotations', 'totalQuotations','cities','states','countries','suppliers'));
        } else {
            // Redirect if the user lacks permission
            return redirect()->route('dashboard')->with('error', 'You do not have permission. Please contact the admin.');
        }
     }
     


    /**
     * Show the form for creating a new quotation.
     */
    public function create()
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $suppliers = Supplier::all();
        $quotation = Quotation::with(['branch', 'partner', 'package.expenses'])
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
        return view('admin.quotations.create', compact('branches', 'partners', 'packages','quotation_no','bankDetails','currencies','countries','states','cities','suppliers'));
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
            // 'bank_id' => 'nullable|exists:bank_details,id',  
            'quotation_no' => 'required|unique:quotations,quotation_no',  
            'booking_reference_no' => 'required|unique:quotations,booking_reference_no',          
            'no_of_night' => 'nullable|numeric',
            'no_of_passenger' => 'nullable|numeric',
            //  'discount_type' => 'required',
            // 'gst_tax' => 'nullable|numeric',
            // 'discount' => 'nullable|numeric',
        ]);
        $input = $request->all();
       
        $input['gst_tax'] = ($request->gst_tax !='')?$request->gst_tax:0.00;
        $input['currency_rate'] = ($request->currency_rate !='')?$request->currency_rate:0.00;
        $input['discount'] = ($request->discount !='')?$request->discount:0.00;
        $input['user_id'] = auth()->id();
        $quotation = Quotation::create($input);
      
        if (!empty($request->supplier) && is_array($request->supplier)) {
            $data = [];
            foreach ($request->supplier as $val) {
                $data[] = [
                    'suplyer_id' => $val,
                    'quotation_id' => $quotation->id,
                ];
            }
            if (!empty($data)) {
                TmpService::insert($data);
            }
        }
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
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $branches = Branch::all();
        $partners = Partner::all();
        $packages = Package::all();
        $currencies = Currency::all();
        $suppliers = Supplier::all();
        $bankDetails = Bank::latest()->get();
        $selectedSuppliers = $quotation->tmpServices->pluck('suplyer_id')->toArray();
       
        return view('admin.quotations.edit', compact('quotation', 'branches', 'partners', 'packages','bankDetails','currencies','countries','states','cities','suppliers','selectedSuppliers'));
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
            // 'bank_id' => 'nullable|exists:bank_details,id',
            'quotation_no' => 'required|unique:quotations,quotation_no,' . $quotation->id,
                
            'no_of_night' => 'nullable|numeric',
            'no_of_passenger' => 'nullable|numeric',          
            //  'gst_tax' => 'nullable|numeric',
            //  'discount' => 'nullable|numeric',
        ]);
        $input = $request->all();
        $input['gst_tax'] = ($request->gst_tax !='')?$request->gst_tax:0.00;
        $input['currency_rate'] = ($request->currency_rate !='')?$request->currency_rate:0.00;
        $input['discount'] = ($request->discount !='')?$request->discount:0.00;
        // $input['user_id'] = auth()->id();
                // Clear existing tmp_services records for this quotation
                // Delete existing services for the quotation
            TmpService::where('quotation_id', $quotation->id)->delete();

            // Insert new suppliers if not empty
            $suppliers = $request->input('supplier');
            if (!empty($suppliers)) {
                foreach ($suppliers as $supplier_id) {
                    TmpService::create([
                        'suplyer_id' => $supplier_id,
                        'quotation_id' => $quotation->id,
                    ]);
                }
            }

            // Update the quotation with the new input data
            $quotation->update($input);


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

    public function fetchCurrencyRates($apiUrl)
    {
        try {
            $response = file_get_contents($apiUrl);
            $data = json_decode($response, true);
    
            if ($data['result'] == 'success') {
                return $data['conversion_rates'];
            }
    
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
        public function generateQuotationPDF($id)
        {
        
            // Fetch the quotation by ID from the database
            $quotation = Quotation::with(['branch.companyBankDetail', 'partner', 'package.expenses','bank','currency'])->findOrFail($id);
   
            // Get the package amount
           $package_amt = $quotation->package->amount *  $quotation->no_of_passenger;

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
       
            $rates = getCurrencyRate($quotation->currency->code);   
        
            
            if (!empty($rates)) {
            
                $total_in_inr = $total_amt * $rates['INR'];
                $total_in_aed = $total_amt * $rates['AED'];
                $total_in_eur = $total_amt * $rates['EUR'];
                $total_in_usd = $total_amt * $rates['USD'];
                
                // $rate = $conversion_rates[$quotation->currency->code] ?? 0.00; // Pass $conversion_rates to the view
                // $discountType = $quotation->discount_type ?? '';
                // $discountAmt = $quotation->discount ?? 0;
                // $discount = ($discountType === 'Fixed') 
                // ? number_format($discountAmt * $rate, 2) 
                // : number_format($discountAmt, 2);
              
            } else {
                // Default to original amounts if conversion fails
                $totalInINR = $totalInAED = $totalInEUR = $totalInUSD = $total_amt;
            }
        

            $currentDateTime = now()->format('Y-m-d_H-i-s');  // e.g., 2024-10-04_14-30-00
            $items = [];
        
            if ($quotation->package) {
                $items[] = [
                    'package_name' => $quotation->package->package_name,
                    'description' => $quotation->package->description,
                    'amount' => $package_amt,
                ];
            }
            
            // Get the branch ID from the quotation
            $branchId = $quotation->branch_id;
            
            // Fetch the branch and related bank details
           // $branchDetails = Branch::with('companyBankDetail')->findOrFail($branchId);
            $bankDetails = CompanyBankDetail::get();
            $companyBankDetails = [];
            if ($bankDetails->isNotEmpty()) {
                foreach ($bankDetails as $bankDetail) {
                    $companyBankDetails[] = [
                        'bank_name' => $bankDetail->bank_name,
                        'account_holder_name' => $bankDetail->account_holder_name,
                        'account_no' => $bankDetail->account_no,
                        'branch_name' => $bankDetail->branch_name,
                        'ifsc_code' => $bankDetail->ifsc_code,
                        'iban_no' => $bankDetail->iban_no,
                    ];
                }
            }
           
            // Example: Adjust these fields based on your `quotations` table structure
            $data = [
                'currency_code'=>$quotation->currency->code,
                'curreny_symbol'=>$quotation->currency->symbol,
                'branch_address'=>$quotation->branch->address,
                'branch_name'=>$quotation->branch->branch_name,
                'quotation_date' => now()->toDateString(),
                'quotation_number' => $quotation->quotation_no,  // Assume there's an invoice number
                'booking_reference_no'=> $quotation->booking_reference_no,
                'no_of_night' => $quotation->no_of_night,
                'no_of_passenger' => $quotation->no_of_passenger,          
                'bill_to' => $quotation->partner->name,  // Assuming you have customer info in your quotation
                'bill_email' => $quotation->partner->email,  // Assuming you have customer info in your quotation
                'bill_mobile' => $quotation->partner->mobile,  // Assuming you have customer info in your quotation
                'bill_city' => $quotation->partner->city->name,  // Assuming you have customer info in your quotation
                'bill_state' => $quotation->partner->state->name,
                'bill_country' => $quotation->partner->country->name,
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
                'companyBankDetails' => $companyBankDetails,  
                'total_in_inr'=>$total_in_inr,
                'total_in_aed'=>$total_in_aed,
                'total_in_eur'=>$total_in_eur,
                'total_in_usd'=>$total_in_usd,



            ];
            
            // Load the view and pass data to it
            // $pdf = PDF::loadView('admin.quotations.quotation_format', $data);
        // Render the Blade view
            $html = view('admin.quotations.quotation_format', $data)->render();

            // Initialize Mpdf
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P', // Portrait
                'margin_left' => 5,
                'margin_right' => 5,
                // 'margin_top' => 20,
                // 'margin_bottom' => 10,
            ]);

        // Set the footer for each page
        $footer = '<div style="text-align: center; ">
        Estimate # ' . $quotation->quotation_no . '
        </div>';

        // Apply the footer to every page
        $mpdf->SetFooter($footer);

        // Write HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Generate file name with timestamp
        $currentDateTime = now()->format('Y-m-d_H-i-s');
        $fileName = 'Quotation-' . $currentDateTime . '.pdf';

        // Output the PDF (download it)
        return response()->make($mpdf->Output($fileName, 'D'), 200, [
        'Content-Type' => 'application/pdf',
        ]);

            // Return the PDF file
        // return $pdf->download('Quotation-' . $currentDateTime . '.pdf');
        }

    
    public function preview($id)
    {
        // Fetch the quotation by ID from the database
        $quotation = Quotation::with(['branch.companyBankDetail', 'partner', 'package','bank','currency'])->findOrFail($id);
        
        // Get the package amount
        $package_amt = $quotation->package->amount * $quotation->no_of_passenger;
        

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
                'amount' => $package_amt,
            ];
        }


        // Get the branch ID from the quotation
        $branchId = $quotation->branch_id;
        
        // Fetch the branch and related bank details
       // $branchDetails = Branch::with('companyBankDetail')->findOrFail($branchId);        
       $bankDetails = CompanyBankDetail::get();
       $companyBankDetails = [];
       if ($bankDetails->isNotEmpty()) {
           foreach ($bankDetails as $bankDetail) {
                $companyBankDetails[] = [
                    'bank_name' => $bankDetail->bank_name,
                    'account_holder_name' => $bankDetail->account_holder_name,
                    'account_no' => $bankDetail->account_no,
                    'branch_name' => $bankDetail->branch_name,
                    'ifsc_code' => $bankDetail->ifsc_code,
                    'iban_no' => $bankDetail->iban_no,
                ];
            }
        }


        // Example: Adjust these fields based on your `quotations` table structure
        $data = [
            'currency_rate'=>$quotation->currency->rate,
            'currency_code'=>$quotation->currency->code,
            'curreny_symbol'=>$quotation->currency->symbol,
            'branch_address'=>$quotation->branch->address,
            'branch_name'=>$quotation->branch->branch_name,
            'quotation_date' => now()->toDateString(),
            'quotation_number' => $quotation->quotation_no,  // Assume there's an invoice number
            'booking_reference_no'=> $quotation->booking_reference_no,
            'no_of_night' => $quotation->no_of_night,
            'no_of_passenger' => $quotation->no_of_passenger,  
            'bill_to' => $quotation->partner->name,  // Assuming you have customer info in your quotation
            'bill_email' => $quotation->partner->email,  // Assuming you have customer info in your quotation
            'bill_mobile' => $quotation->partner->mobile,  // Assuming you have customer info in your quotation
            'bill_city' => $quotation->partner->city->name,  // Assuming you have customer info in your quotation
            'bill_state' => $quotation->partner->state->name,
            'bill_country' => $quotation->partner->country->name,
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
            'companyBankDetails' => $companyBankDetails ,  
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
            $tmpServices = TmpService::where('quotation_id',$id)->get(); 
            $user_id = auth()->id();
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
                'user_id' => $quotation->user_id,
                'invoice_no' => $invoice_no,
                'no_of_night' => $quotation->no_of_night,
                'no_of_passenger' => $quotation->no_of_passenger,   
                'booking_reference_no'=> $quotation->booking_reference_no,
                'branch_id' => $quotation->branch_id,
                'partner_id' => $quotation->partner_id,
                'package_id' => $quotation->package_id,
                'currency_id' => $quotation->currency_id,
                'currency_rate' => $quotation->currency_rate,
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
                    'no_of_night' => $quotation->no_of_night,
                    'no_of_passenger' => $quotation->no_of_passenger,    
                    'partner_id' => $quotation->partner_id,
                    'package_id' => $quotation->package_id,
                    'currency_id' => $quotation->currency_id,
                    'currency_rate' => $quotation->currency_rate,
                    'bank_id' => $quotation->bank_id,
                    'vat' => $quotation->gst_tax, // Assuming total amount is mapped
                    'discount_type' =>$quotation->discount_type, // Or any other status you want to set                 
                    'discount' =>$quotation->discount,
                    'note' =>$quotation->note,
                    'term_condition' =>$quotation->term_condition,                    

                ]
            );
        }
        if (!empty($tmpServices)) {
            $invicedata = [];
            foreach ($tmpServices as $val) {
                $invicedata[] = [
                    'suplyer_id' => $val->suplyer_id,
                    'invoice_id' => $invoice->id,
                ];
            }
        
            if (!empty($invicedata)) {
                Service::insert($invicedata);
            }
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