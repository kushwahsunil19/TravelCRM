<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{User};

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.profile');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     // Update User Profile
     public function update(Request $request,string $id)
     {
       
         // Validate the form data
         $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users',
            'mobile' => 'required|string|max:15',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image file
        ]);

         // Find the user by ID
         $user = User::findOrFail($id);
       
         // Handle the profile picture upload if exists
         if ($request->hasFile('profile')) {
            // Check if the user already has a profile image
            if ($user->profile && file_exists(public_path('profile/' . $user->profile))) {
                // Delete the old profile image
                unlink(public_path('profile/' . $user->profile));
            }
    
            // Upload the new profile image
            $file = $request->file('profile');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile'), $fileName); // Move the file to public/profile directory
            $user->profile = $fileName; // Save file name in the database
           
        }
 
         // Update user details
         $user->first_name = $request->first_name;
         $user->last_name = $request->last_name;
         $user->mobile = $request->mobile;
 
         // Save changes
         $user->save();
 
         // Return a success response (could be a redirect or JSON response)
         return redirect()->back()->with('success', 'Profile updated successfully!');
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
