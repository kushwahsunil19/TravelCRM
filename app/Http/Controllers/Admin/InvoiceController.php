<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Invoice,Branch,Partner,Package,Bank,Currency};
use PDF;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $totalInvoice = Invoice::count();
      $invoices = Invoice::with(['branch', 'partner', 'package','bank','currency'])->paginate( $totalInvoice);
      return view('admin.invoices.invoices',compact('invoices'));
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
        return view('admin.invoices.create', compact('branches', 'partners', 'packages','invoice_no','bankDetails','currencies'));
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
            'vat' => 'nullable|numeric',
            'discount_type' => 'required',            
            'discount' => 'nullable|numeric',
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
      
        $branches = Branch::all();
        $partners = Partner::all();
        $packages = Package::all();
        $currencies = Currency::all();
        $bankDetails = Bank::latest()->get();

        return view('admin.invoices.edit', compact('invoice', 'branches', 'partners', 'packages','bankDetails','currencies'));
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

        // Example: Adjust these fields based on your `quotations` table structure
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
            'bill_city' => $invoice->partner->city,  // Assuming you have customer info in your invoice
            'bill_state' => $invoice->partner->state,
            'bill_country' => $invoice->partner->country,
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

        // Example: Adjust these fields based on your `invoices` table structure
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
            'bill_city' => $invoice->partner->city,  // Assuming you have customer info in your invoice
            'bill_state' => $invoice->partner->state,
            'bill_country' => $invoice->partner->country,
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
