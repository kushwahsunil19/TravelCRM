<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $Suppliers = Supplier::all();
        return view('admin.suppliers.index', compact('Suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.add-Supplier');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits_between:10,15|regex:/^(?:\+?\d{1,3})?\d{10,15}$/',
            'email' => 'required|email|unique:suppliers',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $supplier = new Supplier($request->all());
        
      
        if ($request->hasFile('image')) {
            $file = $request->file('image');
          
            $fileName = time() . '.' . $file->getClientOriginalExtension(); // Create a unique file name
            $file->move(public_path('profile'), $fileName); // Move the file to the public/profile directory
            $supplier->image = $fileName;
        }

        $supplier->save();
        $SupplierDetails = Supplier::latest()->get();
        return response()->json(['status'=>true,'data'=>$SupplierDetails ,'message' => 'Supplier details added successfully']);
 
    }

    public function show(Supplier $Supplier)
    {
        return view('admmin.Suppliers.show', compact('Supplier'));
    }

    public function edit(Supplier $Supplier)
    {
        return response()->json(['status'=>true,'data'=>$Supplier ,'message' => 'Supplier details successfully']);

        // return view('admin.Suppliers.edit-Supplier', compact('Supplier'));
    }

    public function update(Request $request, Supplier $Supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits_between:10,15|regex:/^(?:\+?\d{1,3})?\d{10,15}$/',
            'email' => 'required|email|unique:suppliers,email,' . $Supplier->id,
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $Supplier->update($request->all());

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
        return response()->json(['status'=>true,'data'=>$Supplier ,'message' => 'Supplier details updated successfully']);
        // return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $Supplier)
    {
        $Supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }

}
