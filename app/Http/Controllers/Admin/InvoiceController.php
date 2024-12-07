<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Invoice,Branch,Partner,Package,Bank,Currency,Country,State,City,Supplier,Service,CompanyBankDetail};
use PDF;
use Mpdf\Mpdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //   $totalInvoice = Invoice::count();
    //   $invoices = Invoice::with(['branch', 'partner', 'package','bank'])->paginate( $totalInvoice);
    //   return view('admin.invoices.invoices',compact('invoices'));

      public function index(Request $request)
      {

        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $suppliers = Supplier::all();
        $userRole = auth()->user()->roles->first()->name; // Assuming the user has only one role
        $rolePermissions = getRolePermissions();   
        if (in_array('list-invoice', $rolePermissions[$userRole])) { 
          // Build the query for fetching invoices with the necessary relationships
          $query = Invoice::with(['branch', 'partner', 'package', 'bank','currency']);
      
          // Apply filters based on request parameters
          if ($request->filled('invoice_no')) {
              $query->where('invoice_no', 'like', '%' . $request->invoice_no . '%');
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
      
          // Get the total number of invoices after applying filters
          $totalInvoices = $query->count();
      
          // Paginate the filtered results (you can adjust the number per page as needed)
          $invoices = $query->paginate($totalInvoices); // Paginate the filtered results
      
          // Return the view with total invoices and paginated invoices
          return view('admin.invoices.invoices', compact('invoices', 'totalInvoices','states','countries','cities','suppliers'));
        } else {
            // Redirect if the user lacks permission
            return redirect()->route('dashboard')->with('error', 'You do not have permission. Please contact the admin.');
        }
      }
    
     /**
     * Display a listing of the resource.
     */
    public function getInvoicesPaid()
    {
      $totalInvoice = Invoice::count();
      $invoices = Invoice::with(['branch', 'partner', 'package','bank','currency'])->paginate( $totalInvoice);
   
      return view('admin.invoices.invoices-paid',compact('invoices'));
    }
     /**
     * Display a listing of the resource.
     */
    public function getInvoicesOverdue()
    {
      $totalInvoice = Invoice::count();
      $invoices = Invoice::with(['branch', 'partner', 'package','bank','currency'])->where('status',6)->paginate( $totalInvoice);

      return view('admin.invoices.invoices-overdue',compact('invoices'));
    }
       /**
     * Display a listing of the resource.
     */
    public function getInvoicesCancelled()
    {
      $totalInvoice = Invoice::count();
      $invoices = Invoice::with(['branch', 'partner', 'package','bank','currency'])->where('status',0)->paginate( $totalInvoice);
 
      return view('admin.invoices.invoices-cancelled',compact('invoices'));
    }
     /**
     * Display a listing of the resource.
     */
    public function getInvoicesRecurring()
    {
      $totalInvoice = Invoice::count();
      
      $invoices = Invoice::with(['branch', 'partner', 'package','bank','currency'])->where('status',1)->paginate( $totalInvoice);

      return view('admin.invoices.invoices-recurring',compact('invoices'));
    }
     /**
     * Display a listing of the resource.
     */
    public function getInvoicesUnpaid()
    {
      $totalInvoice = Invoice::count();
      $invoices = Invoice::with(['branch', 'partner', 'package','bank','currency'])->where('status',4)->paginate( $totalInvoice);
    
      return view('admin.invoices.invoices-unpaid',compact('invoices'));
    }
     /**
     * Display a listing of the resource.
     */
    public function getInvoicesRefunded()
    {
      $totalInvoice = Invoice::count();
      $invoices = Invoice::with(['branch', 'partner', 'package','bank','currency'])->where('status',5)->paginate( $totalInvoice);
  
      return view('admin.invoices.invoices-refunded',compact('invoices'));
    }
     /**
     * Display a listing of the resource.
     */
    public function getInvoicesDraft()
    {
      $totalInvoice = Invoice::count();
      $invoices = Invoice::with(['branch', 'partner', 'package','bank','currency'])->where('status',3)->paginate( $totalInvoice);
     
      return view('admin.invoices.invoices-draft',compact('invoices'));
    }
 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $suppliers = Supplier::all();
          
        $invoice = Invoice::with(['branch', 'partner', 'package'])
                      ->latest('id')  // Sort by the latest ID
                      ->first(); 
         $invoice_no = 100;           
        if(isset( $invoice->id)){
            $invoice_no =  $invoice->invoice_no +1 ;
        }   
       
        $branches = Branch::all();
        $partners = Partner::all();
        $packages = Package::all();
        $currencies = Currency::all();
        $bankDetails = Bank::latest()->get();
        return view('admin.invoices.create', compact('branches', 'partners', 'packages','invoice_no','bankDetails','currencies','countries','states','cities','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     // print_r($request->all());
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'partner_id' => 'required|exists:partners,id',
            'package_id' => 'required|exists:packages,id',
            'currency_id' => 'required|exists:currencies,id',
            // 'bank_id' => 'required',
            'invoice_no' => 'required|unique:invoices,invoice_no',   
            'booking_reference_no' => 'required|unique:invoices,booking_reference_no',        
            'no_of_night' => 'nullable|numeric',
            'no_of_passenger' => 'nullable|numeric',          
            //  'vat' => 'nullable|numeric',           
            // 'discount' => 'nullable|numeric',
        ]);     
      
        $input = $request->all();
        $input['vat'] = ($request->vat !='')?$request->vat:0.00;
        $input['discount'] = ($request->discount !='')?$request->discount:0.00;
        $input['currency_rate'] = ($request->currency_rate !='')?$request->currency_rate:0.00;       
        $invoice = Invoice::create($input);
        
     // Check if $request->supplier is not empty
        if (!empty($request->supplier) && is_array($request->supplier)) {
            $data = [];
            foreach ($request->supplier as $val) {
                // Add each supplier's data to the $data array
                $data[] = [
                    'suplyer_id' => $val,
                    'invoice_id' => $invoice->id,
                ];
            }

            // Only insert data if $data array is not empty
            if (!empty($data)) {
                Service::insert($data);
            }
        }
        return redirect()->route('invoices.edit', $invoice->id)
                         ->with('success', 'Invioce created successfully and you are now editing it.');
    
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
    public function edit(Invoice $invoice)
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
    
      
        $branches = Branch::all();
        $partners = Partner::all();
        $packages = Package::all();
        $currencies = Currency::all();
        $bankDetails = Bank::latest()->get();
        $suppliers = Supplier::all();
        $selectedSuppliers = $invoice->services->pluck('suplyer_id')->toArray();

        return view('admin.invoices.edit', compact('invoice', 'branches', 'partners', 'packages','bankDetails','currencies','countries','states','cities','suppliers','selectedSuppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'partner_id' => 'required|exists:partners,id',
            'package_id' => 'required|exists:packages,id',
            'currency_id' => 'required|exists:currencies,id',
            // 'bank_id' => 'required',
            'invoice_no' => 'required|unique:invoices,invoice_no,' . $invoice->id,
            'no_of_night' => 'nullable|numeric',
            'no_of_passenger' => 'nullable|numeric',          
            // 'vat' => 'nullable|numeric',
            // 'discount' => 'nullable|numeric',
        ]);
        
            // Clear existing tmp_services records for this quotation
        Service::where('invoice_id', $invoice->id)->delete();

        // Get the suppliers from the request
        $suppliers = $request->input('supplier');

        // Check if suppliers are not empty before processing
        if (!empty($suppliers) && is_array($suppliers)) {
            foreach ($suppliers as $supplier_id) {
                Service::create([
                    'suplyer_id' => $supplier_id,
                    'invoice_id' => $invoice->id,
                ]);
            }
        }
        $input = $request->all();
      
        $input['vat'] = ($request->vat !='')?$request->vat:0.00;
        $input['discount'] = ($request->discount !='')?$request->discount:0.00;
        $input['currency_rate'] = ($request->currency_rate !='')?$request->currency_rate:0.00;
        $invoice->update($input);

        return redirect()->route('invoices.edit', $invoice->id)
                         ->with('success', 'Invoice updated successfully.');
    }
    /**
     * Remove the specified quotation from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')
                         ->with('success', 'Invoice deleted successfully.');
    }
    public function downloadPDF(Request $request)
    {
        
    
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');
    
        // Build the query for fetching invoices with the necessary relationships
        $query = Invoice::with(['branch', 'partner', 'package', 'bank']);
    
        // Apply filters based on request parameters
        if ($request->filled('invoice_no')) {
            $query->where('invoice_no', 'like', '%' . $request->invoice_no . '%');
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
        $invoices = $query->get();
    
        // Check if invoices exist before generating the PDF
        if ($invoices->isEmpty()) {
            return redirect()->back()->with('error', 'No invoices found for the selected filters.');
        }
    
        // Load the PDF view with filtered invoices data
        $pdf = PDF::loadView('admin.invoices.invoice-pdf', compact('invoices'));
    
        // Format the date for the filename
        $timestamp = date('Y-m-d_H-i-s');
        $filename = 'invoice_report_' . $timestamp . '.pdf';
    
        // Return the PDF download
        return $pdf->download($filename);
    }
    public function downloadCSV(Request $request)
    {
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata'); 
    
        // Reuse the filtering logic from index()
        $query = Invoice::with(['branch', 'partner', 'package', 'bank', 'currency']);
    
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
        $invoices = $query->get();
    
        // Check if invoices exist before generating the CSV
        if ($invoices->isEmpty()) {
            return redirect()->back()->with('error', 'No invoices found for the selected filters.');
        }
    
        // Create a CSV handle
        $handle = fopen('php://output', 'w');
    
        // Format the date for the filename
        $timestamp = date('Y-m-d_H-i-s');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Invoice_report_' . $timestamp . '.csv"');
    
        // Add CSV headers
        fputcsv($handle, [
            'S.No',
            'Invoice No',
            'Branch',
            'Package',
            'Partner',
            'Discount Type',
            'Discount',
            'VAT',
            'Amount'
        ]);
    
        $serialNumber = 1;
    
        // Add the filtered data rows
        foreach ($invoices as $invoice) {
            $symbol = isset($invoice->currency->code) ? '(' . $invoice->currency->code . ')' : '(INR)';

            $package_amt = $invoice->package->amount * $invoice->no_of_passenger;
            $tax = $invoice->vat;
            $discount = $invoice->discount;
    
            // Calculate discount
            $discount_amt = $invoice->discount_type == 'Fixed' ? $discount : ($package_amt * $discount) / 100;
            $amount_after_discount = $package_amt - $discount_amt;
    
            // Calculate tax
            $tax_amt = ($amount_after_discount * $tax) / 100;
    
            // Calculate total
            $total_amt = $amount_after_discount + $tax_amt;
    
            // Write data to CSV
            fputcsv($handle, [
                $serialNumber++,
                $invoice->invoice_no,
                $invoice->branch ? $invoice->branch->city : 'N/A',
                $invoice->package ? $invoice->package->package_name : 'N/A',
                $invoice->partner->name . ' (' . $invoice->partner->email . ')',
                $invoice->discount_type?$invoice->discount_type:'N/A',
                $invoice->discount . ($invoice->discount_type == 'Fixed' ? '' : '%'),
                $invoice->vat . '%',
                $symbol . number_format($total_amt, 2),
            ]);
        }
    
        fclose($handle);
        exit;
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
        $invoice = Invoice::with(['branch', 'partner', 'package','bank','currency'])->findOrFail($id);
      
        // Get the package amount
        $package_amt = $invoice->package->amount *  $invoice->no_of_passenger;;

        // GST Tax in percentage
        $tax = $invoice->vat;

        // Discount in percentage
        $discount = $invoice->discount;
        if($invoice->discount_type=='Fixed'){
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
        // Currency conversion logic
        $rates = getCurrencyRate($invoice->currency->code); 
        if (!empty($rates)) {
            $total_in_inr = $total_amt * $rates['INR'];
            $total_in_aed = $total_amt * $rates['AED'];
            $total_in_eur = $total_amt * $rates['EUR'];
            $total_in_usd = $total_amt * $rates['USD'];
        } else {
            // Default to original amounts if conversion fails
            $totalInINR = $totalInAED = $totalInEUR = $totalInUSD = $total_amt;
        }
        $currentDateTime = now()->format('Y-m-d_H-i-s');  // e.g., 2024-10-04_14-30-00
        $items = [];
    
        if ($invoice->package) {
            $items[] = [
                'package_name' => $invoice->package->package_name,
                'description' => $invoice->package->description,
                'amount' =>  $package_amt ,
            ];
        }
         // Get the branch ID from the quotation
         $branchId = $invoice->branch_id;
        
         // Fetch the branch and related bank details
         //$branchDetails = Branch::with('companyBankDetail')->findOrFail($branchId);
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
        // Example: Adjust these fields based on your quotations table structure
        $data = [
            'currency_code'=>$invoice->currency->code,
            'curreny_symbol'=>$invoice->currency->symbol,
            'branch_address'=>$invoice->branch->address,
            'branch_name'=>$invoice->branch->branch_name,
            'invoice_date' => now()->toDateString(),
            'invoice_number' => $invoice->invoice_no,  // Assume there's an invoice number
            'booking_reference_no'=> $invoice->booking_reference_no,
            'no_of_night' => $invoice->no_of_night,
            'no_of_passenger' => $invoice->no_of_passenger, 
            'bill_to' => $invoice->partner->name,  // Assuming you have customer info in your invoice
            'bill_email' => $invoice->partner->email,  // Assuming you have customer info in your invoice
            'bill_mobile' => $invoice->partner->mobile,  // Assuming you have customer info in your invoice
            'bill_city' => $invoice->partner->city->name,  // Assuming you have customer info in your invoice
            'bill_state' => $invoice->partner->state->name,
            'bill_country' => $invoice->partner->country->name,
            'items' => $items ,  // Assuming a relationship or JSON field for items
            'subtotal' =>  $package_amt ,
            'discount'=> $discount,
            'discount_type'=> $invoice->discount_type,
            'tax' => $tax,  // Assuming a field for VAT
            'total' =>  $total_amt,
            'bank_name'=> isset($invoice->bank->bank_name)?$invoice->bank->bank_name:'',
            'account_no'=> isset($invoice->bank->account_no)?$invoice->bank->account_no:'',
            'bank_branch'=> isset($invoice->bank->branch_name)?$invoice->bank->branch_name:'',
            'ifsc_code'=> isset($invoice->bank->ifsc_code)?$invoice->bank->ifsc_code:'',
            'iban_no'=> isset($invoice->bank->iban_no)?$invoice->bank->iban_no:'',
            'companyBankDetails' => $companyBankDetails,
            'total_in_inr'=>$total_in_inr,
            'total_in_aed'=>$total_in_aed,
            'total_in_eur'=>$total_in_eur,
            'total_in_usd'=>$total_in_usd,
        ];
        
        // Load the view and pass data to it
      //  $pdf = PDF::loadView('admin.invoices.invoice_format', $data);
            // Render the Blade view
            $html = view('admin.invoices.invoice_format', $data)->render();

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
        Invoice # ' . $invoice->invoice_no . '
        </div>';

        // Apply the footer to every page
        $mpdf->SetFooter($footer);

        // Write HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Generate file name with timestamp
        $currentDateTime = now()->format('Y-m-d_H-i-s');
        $fileName = 'Invoice-' . $currentDateTime . '.pdf';

        // Output the PDF (download it)
        return response()->make($mpdf->Output($fileName, 'D'), 200, [
        'Content-Type' => 'application/pdf',
        ]);

        // Return the PDF file
      //  return $pdf->download('Invoice-' . $currentDateTime . '.pdf');
    }
    
    public function preview($id)
    {
        // Fetch the quotation by ID from the database
        $invoice = Invoice::with(['branch', 'partner', 'package','bank','currency'])->findOrFail($id);
      
        // Get the package amount
        $package_amt = $invoice->package->amount *  $invoice->no_of_passenger;;

        // GST Tax in percentage
        $tax = $invoice->vat;

        // Discount in percentage
        $discount = $invoice->discount;

        // Calculate discount amount (discount percentage applied to the package amount)
        if($invoice->discount_type=='Fixed'){
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
    
        if ($invoice->package) {
            $items[] = [
                'package_name' => $invoice->package->package_name,
                'description' => $invoice->package->description,
                'amount' => $package_amt,
            ];
        }
        // Get the branch ID from the quotation
        $branchId = $invoice->branch_id;
        
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

        // Example: Adjust these fields based on your invoices table structure
        $data = [
            'currency_code'=>$invoice->currency->code,
            'curreny_symbol'=>$invoice->currency->symbol,
            'branch_address'=>$invoice->branch->address,
            'branch_name'=>$invoice->branch->branch_name,
            'invoice_date' => now()->toDateString(),
            'invoice_number' => $invoice->invoice_no,  // Assume there's an invoice number
            'booking_reference_no'=> $invoice->booking_reference_no,
            'no_of_night' => $invoice->no_of_night,
            'no_of_passenger' => $invoice->no_of_passenger, 
            'bill_to' => $invoice->partner->name,  // Assuming you have customer info in your invoice
            'bill_email' => $invoice->partner->email,  // Assuming you have customer info in your invoice
            'bill_mobile' => $invoice->partner->mobile,  // Assuming you have customer info in your invoice
            'bill_city' => $invoice->partner->city->name,  // Assuming you have customer info in your invoice
            'bill_state' => $invoice->partner->state->name,
            'bill_country' => $invoice->partner->country->name,
            'items' => $items ,  // Assuming a relationship or JSON field for items
            'subtotal' =>  $package_amt ,
            'discount'=> $discount,
            'discount_type'=> $invoice->discount_type,
            'tax' => $tax,  // Assuming a field for VAT
            'total' =>  $total_amt,
            'bank_name'=> isset($invoice->bank->bank_name)?$invoice->bank->bank_name:'',
            'account_no'=> isset($invoice->bank->account_no)?$invoice->bank->account_no:'',
            'bank_branch'=> isset($invoice->bank->branch_name)?$invoice->bank->branch_name:'',
            'ifsc_code'=> isset($invoice->bank->ifsc_code)?$invoice->bank->ifsc_code:'',
            'iban_no'=> isset($invoice->bank->iban_no)?$invoice->bank->iban_no:'',
            'companyBankDetails' => $companyBankDetails,  
        ];
        
        // Load the view and pass data to it
     return view('admin.invoices.preview', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore($id)
    {
        $package = Invoice::withTrashed()->findOrFail($id);
        $package->restore();

        return redirect()->route('invoices.index')->with('success', 'Invoice restored successfully.');
    }
}