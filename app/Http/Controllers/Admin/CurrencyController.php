<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
class CurrencyController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all currencies, including soft-deleted ones if needed
        $currencies = Currency::latest()->get();

        return view('admin.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.currencies.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255|unique:currencies,name',
            'code' => 'required|string|max:3',
            'symbol' => 'nullable|string|max:10',
            // 'exchange_rate' => 'required|numeric',

        ]);

        // Create a new branch
        $currencies =   Currency::create($request->all());
        $currencyDetails = Currency::latest()->get();
        return response()->json(['status'=>true,'data'=>$currencyDetails ,'message' => 'Currency details added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return view('admin.currencies.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        return response()->json(['status'=>true,'data'=>$currency ,'message' => 'Currency details added successfully']);
        //eturn view('admin.currencies.edit', compact('Currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
            'symbol' => 'nullable|string|max:10',
            // 'exchange_rate' => 'required|numeric',
        ]);

        // Update the Currency
        $currency->update($request->all());
        return response()->json(['status'=>true,'data'=>$currency ,'message' => 'Currency details updated successfully']);

       // return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }
    public function getCurrencyRate(Request $request)
    {
        $fromCurrency = $request->input('fromCurrency', 'USD'); // Default to USD if not provided
        $toCurrency = $request->input('toCurrency', 'INR'); // Default to INR if not provided
        $amount = $request->input('amount', 1); // Default to 1 if not provided

        // Call the helper function to get the conversion rate
        $rate = getCurrencyRateAmt($fromCurrency, $toCurrency, $amount);

        // Return the rate as a JSON response
        return response()->json(['rate' => $rate]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        // Soft delete the Currency
        $currency->delete();

        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }

    /**
     * Restore a soft-deleted branch.
     */
    public function restore($id)
    {
        $currency = Currency::withTrashed()->findOrFail($id);
        $currency->restore();

        return redirect()->route('currencies.index')->with('success', 'Currency restored successfully.');
    }
}
