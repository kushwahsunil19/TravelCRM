<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
class BankController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all bank, including soft-deleted ones if needed
        $banks = Bank::latest()->get();

        return view('admin.bank.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bank.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_no' => 'required|numeric',
            'branch_name' => 'nullable|string|min:1',
            'ifsc_code' => 'required|string|min:1',

        ]);

        // Create a new branch
        $bank =   Bank::create($request->all());
        $BankDetails = Bank::latest()->get();
        return response()->json(['status'=>true,'data'=>$BankDetails ,'message' => 'Bank details added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $Bank)
    {
        return view('admin.bank.show', compact('Bank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $Bank)
    {
        return response()->json(['status'=>true,'data'=>$Bank ,'message' => 'Bank details added successfully']);
        //eturn view('admin.bank.edit', compact('Bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $Bank)
    {
        // Validate the incoming data
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_no' => 'required|numeric',
            'branch_name' => 'nullable|string|min:1',
            'ifsc_code' => 'required|string|min:1',
        ]);

        // Update the Bank
        $Bank->update($request->all());
        return response()->json(['status'=>true,'data'=>$Bank ,'message' => 'Bank details updated successfully']);

       // return redirect()->route('bank.index')->with('success', 'Bank updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $Bank)
    {
        // Soft delete the Bank
        $Bank->delete();

        return redirect()->route('banks.index')->with('success', 'Bank deleted successfully.');
    }

    /**
     * Restore a soft-deleted branch.
     */
    public function restore($id)
    {
        $Bank = Bank::withTrashed()->findOrFail($id);
        $Bank->restore();

        return redirect()->route('banks.index')->with('success', 'Bank restored successfully.');
    }

}
