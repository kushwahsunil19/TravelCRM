<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\{Partner};
use Yajra\DataTables\Facades\DataTables;
class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::all();
        return view('admin.partners.partners', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.add-partner');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:partners',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $partner = new Partner($request->all());
        
      
        if ($request->hasFile('image')) {
            $file = $request->file('image');
          
            $fileName = time() . '.' . $file->getClientOriginalExtension(); // Create a unique file name
            $file->move(public_path('profile'), $fileName); // Move the file to the public/profile directory
            $partner->image = $fileName;
        }

        $partner->save();
        $partnerDetails = Partner::latest()->get();
        return response()->json(['status'=>true,'data'=>$partnerDetails ,'message' => 'Partner details added successfully']);
 
    }

    public function show(Partner $partner)
    {
        return view('admmin.partners.show', compact('partner'));
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit-partner', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:partners,email,' . $partner->id,
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $partner->update($request->all());

        if ($request->hasFile('image')) {
            // Check if the user already has a profile image
            if ($partner->image && file_exists(public_path('profile/' . $partner->image))) {
                // Delete the old profile image
                unlink(public_path('profile/' . $partner->image));
            }
    
            // Upload the new profile image
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile'), $fileName); // Move the file to public/profile directory
            $partner->image = $fileName; // Save file name in the database
           
        }

        $partner->save();
        return redirect()->route('partners.index')->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('partners.index')->with('success', 'Partner deleted successfully.');
    }

}
