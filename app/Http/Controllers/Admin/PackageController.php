<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all packages, including soft-deleted ones if needed
        $packages = Package::latest()->get();

        return view('admin.packages.index', compact('packages'));
    }
    public function getPackageDetails($id)
    {
        $package = Package::find($id);
    
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
            'package_name' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);
        // Create a new package
        Package::create($request->all());
        $packageDetails = Package::latest()->get();
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

        return redirect()->route('quotations.create')->with('success', 'Package updated successfully.');
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
