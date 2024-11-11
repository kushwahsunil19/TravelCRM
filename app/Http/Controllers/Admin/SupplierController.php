<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplierExpense;
use Illuminate\Http\Request;
use App\Models\{Supplier,Currency,Country,State,City};


class SupplierController extends Controller
{
    public function index(Request $request) // Add Request parameter
    {
        $currencies = Currency::all();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        // Initialize query
        $query = Supplier::query();

        // Apply filters based on request input
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }

        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        // Get the filtered suppliers
        $Suppliers = $query->with('expenses','currency','country','state','city')->get();

        return view('admin.suppliers.index', compact('Suppliers','currencies','countries','states','cities'));
    }

    public function create()
    {
        return view('admin.suppliers.add-Supplier');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
            
    //         'name' => 'required|string|max:255',
    //         'mobile' => 'required|numeric|digits_between:10,15|regex:/^(?:\+?\d{1,3})?\d{10,15}$/',
    //         'email' => 'required|email|unique:suppliers',
    //         'city' => 'nullable|string|max:255',
    //         'state' => 'nullable|string|max:255',
    //         'country' => 'nullable|string|max:255',
    //         'total_amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',

    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);
    //    $input = $request->all();
    //    $input['amount'] = $input['total_amount'];
    //    $supplier = new Supplier($input);
        
      
    //     if ($request->hasFile('image')) {
    //         $file = $request->file('image');
          
    //         $fileName = time() . '.' . $file->getClientOriginalExtension(); // Create a unique file name
    //         $file->move(public_path('profile'), $fileName); // Move the file to the public/profile directory
    //         $supplier->image = $fileName;
    //     }

    //     $supplier->save();
    //     $titles = $request->title; // Titles array from form
    //     $amount = $request->amount; // Rupees array from form
    
      
    //     foreach ($titles as $key => $title) {
    //         $data[] = [
    //             'suplyer_id' => $supplier->id,
    //             'title' => $title,
    //             'amount' => $amount[$key] ?? 0,
    //         ];
    //     }

    //     // print_r($data); die;
       
        
    //     SupplierExpense::insert($data);
    //     $SupplierDetails = Supplier::latest()->get();
    //     return response()->json(['status'=>true,'data'=>$SupplierDetails ,'message' => 'Supplier details added successfully']);
 
    // }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'mobile' => 'required|numeric|digits_between:10,15|regex:/^(?:\+?\d{1,3})?\d{10,15}$/',
        'email' => 'required|email|unique:suppliers',
        'city_id' => 'required|string|max:255',
        'state_id' => 'required|string|max:255',
        'country_id' => 'required|string|max:255',
        'total_amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Create a new supplier
    $input = $request->all();
    $input['amount'] = $input['total_amount'];
    $supplier = new Supplier($input);

    // Handle the image upload
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension(); // Create a unique file name
        $file->move(public_path('profile'), $fileName); // Move the file to the public/profile directory
        $supplier->image = $fileName;
    }

    // Save the supplier
    $supplier->save();

    // Process expense titles and amounts
    $titles = $request->title; // Titles array from form
    $amounts = $request->amount; // Amount array from form

    // Prepare expense data for batch insert
    $data = [];
    foreach ($titles as $key => $title) {
        $data[] = [
            'suplyer_id' => $supplier->id,
            'title' => $title,
            'amount' => $amounts[$key] ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
 
    // Insert all expenses at once
    SupplierExpense::insert($data);

    // Return success response
    $SupplierDetails = Supplier::latest()->get();
    return response()->json(['status' => true, 'data' => $SupplierDetails, 'message' => 'Supplier details added successfully']);
}


    public function show(Supplier $Supplier)
    {
        return view('admmin.Suppliers.show', compact('Supplier'));
    }

    public function edit(Supplier $Supplier)
    {
        $Supplier->load(relations: 'expenses');

      
        
        return response()->json(['status'=>true,'data'=>$Supplier ,'message' => 'Supplier details successfully']);

        // return view('admin.Suppliers.edit-Supplier', compact('Supplier'));
    }

    public function update(Request $request, Supplier $Supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits_between:10,15|regex:/^(?:\+?\d{1,3})?\d{10,15}$/',
            'email' => 'required|email|unique:suppliers,email,' . $Supplier->id,
            'city_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'country_id' => 'nullable|integer',
            // 'total_amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $input = $request->all();
        $input['amount'] = $input['total_amount'];
        $Supplier->update($input);

        if ($request->hasFile('image')) {
            // Check if the user already has a profile image
            if ($Supplier->image && file_exists(public_path('profile/' . $Supplier->image))) {
                // Delete the old profile image
                unlink(public_path('profile/' . $Supplier->image));
            }
    
            // Upload the new profile image
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile'), $fileName); // Move the file to public/profile directory
            $Supplier->image = $fileName; // Save file name in the database
           
        }

        $Supplier->save();
            // Process expense titles and amounts
            $titles = $request->title; // Titles array from form
            $amounts = $request->amount; // Amount array from form
            $ids = $request->exp_id ?? []; // Expense IDs from form, if provided
            if(!empty($titles)){
                // Loop through the titles and amounts to create or update each expense
                foreach ($titles as $key => $title) {  
                    // Prepare the matching conditions (for updating)
                    $matchThese = [
                        'id' => $ids[$key] ?? 0, // Use the expense ID for matching, or 0 if not provided
                        'suplyer_id' => $Supplier->id,
                    ];

                    // Prepare the data to insert or update
                    $updateData = [
                        'suplyer_id' => $Supplier->id,
                        'title' => $title,
                        'amount' => $amounts[$key] ?? 0,
                    ];

                    // Call updateOrCreate for each expense entry
                    SupplierExpense::updateOrCreate($matchThese, $updateData);
                }
            }
          
            
        return response()->json(['status'=>true,'data'=>$Supplier ,'message' => 'Supplier details updated successfully']);
        // return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $Supplier)
    {
        $Supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
    public function deleteExp($id)
    {
      
        try {
            // Find the SupplierExpense by its ID and delete it
            $expense = SupplierExpense::findOrFail($id); // Throws exception if not found
            $expense->delete();
    
            // Return success response if deletion is successful
            return response()->json(['success' => true, 'message' => 'Expense deleted successfully']);
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json(['success' => false, 'message' => 'Error deleting expense']);
        }
    }

}
