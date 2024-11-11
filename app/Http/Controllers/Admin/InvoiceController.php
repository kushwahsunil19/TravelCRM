<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Invoice,Branch,Partner,Package,Bank,Currency,Country,State,City};
use PDF;
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
          $invoices = $query->paginate(10); // Paginate the filtered results
      
          // Return the view with total invoices and paginated invoices
          return view('admin.invoices.invoices', compact('invoices', 'totalInvoices','states','countries','cities'));
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
        return view('admin.invoices.create', compact('branches', 'partners', 'packages','invoice_no','bankDetails','currencies','countries','states','cities'));
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
            'bank_id' => 'required',
            'invoice_no' => 'required|unique:invoices,invoice_no',        
            // 'child_no_extra_bed_cost' => 'nullable|numeric',
            'vat' => 'numeric',           
            'discount' => 'numeric',
        ]);
      
        $invoice = Invoice::create($request->all());

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

        return view('admin.invoices.edit', compact('invoice', 'branches', 'partners', 'packages','bankDetails','currencies','countries','states','cities'));
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
            'bank_id' => 'required',
            'invoice_no' => 'required|unique:invoices,invoice_no,' . $invoice->id,
          
            'vat' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $invoice->update($request->all());

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
        $query = Invoice::with(['branch', 'partner', 'package', 'bank']);
    
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
    
        // Check if quotations exist before generating the CSV
        if ($quotations->isEmpty()) {
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
            'Quotation No',
            'Branch',
            'Package',
            'Partner',
            'Discount Type',
            'Discount',
            'VAT',
        ]);
        $serialNumber = 1;

        // Add the filtered data rows
        foreach ($quotations as $quotation) {
            fputcsv($handle, [
                $serialNumber++,
                $quotation->quotation_no,
                $quotation->branch ? $quotation->branch->city : 'N/A',
                $quotation->package ? $quotation->package->package_name : 'N/A',
                $quotation->partner->name . ' (' . $quotation->partner->email . ')',
                $quotation->discount_type,
                $quotation->discount . ($quotation->discount_type == 'Fixed' ? '' : '%'),
                $quotation->gst_tax . '%',
            ]);
        }
    
        fclose($handle);
        exit;
    }
    public function generateQuotationPDF($id)
    {
        // Fetch the quotation by ID from the database
        $invoice = Invoice::with(['branch', 'partner', 'package','bank','currency'])->findOrFail($id);
      
        // Get the package amount
        $package_amt = $invoice->package->amount;

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

        $currentDateTime = now()->format('Y-m-d_H-i-s');  // e.g., 2024-10-04_14-30-00
        $items = [];
    
        if ($invoice->package) {
            $items[] = [
                'package_name' => $invoice->package->package_name,
                'description' => $invoice->package->description,
                'amount' => $invoice->package->amount,
            ];
        }

        // Example: Adjust these fields based on your quotations table structure
        $data = [
            'currency_code'=>$invoice->currency->code,
            'curreny_symbol'=>$invoice->currency->symbol,
            'branch_address'=>$invoice->branch->address,
            'branch_name'=>$invoice->branch->branch_name,
            'invoice_date' => now()->toDateString(),
            'invoice_number' => $invoice->invoice_no,  // Assume there's an invoice number
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
        ];
        
        // Load the view and pass data to it
        $pdf = PDF::loadView('admin.invoices.invoice_format', $data);

        // Return the PDF file
        return $pdf->download('Invoice-' . $currentDateTime . '.pdf');
    }
    
    public function preview($id)
    {
        // Fetch the quotation by ID from the database
        $invoice = Invoice::with(['branch', 'partner', 'package','bank','currency'])->findOrFail($id);
      
        // Get the package amount
        $package_amt = $invoice->package->amount;

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
                'amount' => $invoice->package->amount,
            ];
        }

        // Example: Adjust these fields based on your invoices table structure
        $data = [
            'currency_code'=>$invoice->currency->code,
            'curreny_symbol'=>$invoice->currency->symbol,
            'branch_address'=>$invoice->branch->address,
            'branch_name'=>$invoice->branch->branch_name,
            'invoice_date' => now()->toDateString(),
            'invoice_number' => $invoice->invoice_no,  // Assume there's an invoice number
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