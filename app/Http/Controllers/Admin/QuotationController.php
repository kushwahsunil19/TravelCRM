<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Quotation,Branch,Partner,Package,Bank};
use PDF;
class QuotationController extends Controller
{
    /**
     * Display a listing of the quotations.
     */
    public function index()
    {
        $quotations = Quotation::with(['branch', 'partner', 'package','bank'])->paginate(10);
        return view('admin.quotations.index', compact('quotations'));
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
            $quotation_no +=  $quotation->quotation_no;
        }       
        $branches = Branch::all();
        $partners = Partner::all();
        $packages = Package::all();
        $bankDetails = Bank::latest()->get();
        return view('admin.quotations.create', compact('branches', 'partners', 'packages','quotation_no','bankDetails'));
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
             'quotation_no' => 'required|unique:quotations,quotation_no',
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
        return view('admin.quotations.edit', compact('quotation', 'branches', 'partners', 'packages'));
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
        $quotation = Quotation::with(['branch', 'partner', 'package'])->findOrFail($id);
        $package_amt = $quotation->package->amount;

        // GST Tax in percentage
        $tax = $quotation->gst_tax;
    
        // Discount in percentage
        $discount = $quotation->discount;
    
        // Calculate discount amount (discount percentage applied to the package amount)
        $discount_amt = ($package_amt * $discount) / 100;
    
        // Amount after discount
        $amount_after_discount = $package_amt - $discount_amt;
    
        // Calculate tax amount (tax percentage applied to the amount after discount)
        // $tax_amt = ($amount_after_discount * $tax) / 100;
    
        // Total amount after applying discount and adding tax
        $total_amt = $amount_after_discount + $tax;
        $currentDateTime = now()->format('Y-m-d_H-i-s');  // e.g., 2024-10-04_14-30-00

        // Example: Adjust these fields based on your `quotations` table structure
        $data = [
            'branch_address'=>$quotation->branch->address,
            'quotation_date' => now()->toDateString(),
            'quotation_number' => $quotation->quotation_no,  // Assume there's an invoice number
            'bill_to' => $quotation->partner->name,  // Assuming you have customer info in your quotation
            'items' => [],  // Assuming a relationship or JSON field for items
            'subtotal' =>  $package_amt ,
            'discount'=> $discount,
            'tax' => $tax,  // Assuming a field for VAT
            'total' =>  $total_amt,
        ];

        // Load the view and pass data to it
        $pdf = PDF::loadView('admin.quotations.quotation_format', $data);

        // Return the PDF file
        return $pdf->download('Estimate-' . $currentDateTime . '.pdf');
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
            ]);
            $bankDetails = Bank::latest()->get();
            return response()->json(['status'=>true,'data'=>$bankDetails ,'message' => 'Bank details added successfully']);
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