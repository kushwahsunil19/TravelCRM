<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all branches, including soft-deleted ones if needed
        $branches = Branch::all();

        return view('admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.branches.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        // Create a new branch
        $branches =   Branch::create($request->all());
        $branchDetails = Branch::latest()->get();
        return response()->json(['status'=>true,'data'=>$branchDetails ,'message' => 'Branch details added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return view('admin.branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        // Validate the incoming data
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        // Update the branch
        $branch->update($request->all());

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        // Soft delete the branch
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }

    /**
     * Restore a soft-deleted branch.
     */
    public function restore($id)
    {
        $branch = Branch::withTrashed()->findOrFail($id);
        $branch->restore();

        return redirect()->route('branches.index')->with('success', 'Branch restored successfully.');
    }
}
