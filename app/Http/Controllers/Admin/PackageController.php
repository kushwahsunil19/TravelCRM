<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Package,PackageExpense};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all packages, including soft-deleted ones if needed
        $packages = Package::with('user')->where('user_id', auth()->id())->latest()->get();

        return view('admin.packages.index', compact('packages'));
    }
    public function getPackageDetails($id)
    {
        $package = Package::with('expenses','currency')->find($id);
    
        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found.',
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'data' => $package, // Return the entire package
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        // Validate the incoming data
        $request->validate([
            'package_name' => 'required|string|max:255|unique:packages,package_name',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);
        // Create a new package
        $input = $request->all();
        $input['user_id'] = auth()->id();
      
      
        $pkg_id = Package::create($input)->id;
         // Process expense titles and amounts
    $titles = $request->title; // Titles array from form
    $amounts = $request->exp_amount; // Amount array from form

    // Prepare expense data for batch insert
    $data = [];
    if (!empty($title)) {  
            foreach ($titles as $key => $title) {
                // Skip empty titles
            
                $data[] = [
                    'package_id' => $pkg_id,
                    'title' => $title,
                    'amount' => $amounts[$key] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        
    }
    // Insert data into the database (optional step)
    if (!empty($data)) {
        PackageExpense::insert($data);
    }
    // Insert all expenses at once
  

        $packageDetails = Package::with('user')->latest()->get();
        return response()->json(['status'=>true,'data'=>$packageDetails ,'message' => 'Package details added successfully']);
   
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        $package->load(relations: 'expenses');
        return response()->json(['status'=>true,'data'=>$package ,'message' => 'Package details added successfully']);

        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        // Validate the incoming data
        $request->validate([
            'package_name' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);
       

     // Update the package
        $package->update($request->all());
          // Process expense titles and amounts
          $titles = $request->title; // Titles array from form
          $amounts = $request->exp_amount; // Amount array from form
          $ids = $request->exp_id ?? []; // Expense IDs from form, if provided
        
          if(!empty($titles)){
              // Loop through the titles and amounts to create or update each expense
              foreach ($titles as $key => $title) {  
                  // Prepare the matching conditions (for updating)
                  $matchThese = [
                      'id' => $ids[$key] ?? 0, // Use the expense ID for matching, or 0 if not provided
                      'package_id' => $package->id,
                  ];

                  // Prepare the data to insert or update
                  $updateData = [
                      'package_id' => $package->id,
                      'title' => $title,
                      'amount' => $amounts[$key] ?? 0,
                  ];

                  // Call updateOrCreate for each expense entry
                  PackageExpense::updateOrCreate($matchThese, $updateData);
              }
          }
          $package->load(relations: 'expenses');
        return response()->json(['status'=>true,'data'=>$package ,'message' => 'Package details updated successfully']);


        // return redirect()->route('quotations.create')->with('success', 'Package updated successfully.');
    }
    public function deleteExp($id)
    {
      
        try {
            // Find the PackageExpense by its ID and delete it
            $expense = PackageExpense::findOrFail($id); // Throws exception if not found
            $expense->delete();
    
            // Return success response if deletion is successful
            return response()->json(['success' => true, 'message' => 'Expense deleted successfully']);
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json(['success' => false, 'message' => 'Error deleting expense']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        // Soft delete the package
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Package deleted successfully.');
    }
    

    /**
     * Restore a soft-deleted package.
     */
    public function restore($id)
    {
        $package = Package::withTrashed()->findOrFail($id);
        $package->restore();

        return redirect()->route('packages.index')->with('success', 'Package restored successfully.');
    }
}
