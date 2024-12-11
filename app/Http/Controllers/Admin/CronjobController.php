<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Currency};
use Illuminate\Support\Facades\Http;
class CronjobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $baseCurrency = 'AED'; // Base currency for comparison
        $apiKey = env('CURRENT_CURRENCY_RATE_KEY'); // Get API key from environment
        $apiUrl = "https://v6.exchangerate-api.com/v6/$apiKey/latest/$baseCurrency";
    
        try {
            // Fetch rates from the API
            $response = Http::get($apiUrl);
    
            if ($response->ok()) {
                $data = $response->json();
    
                if ($data['result'] === 'success' && isset($data['conversion_rates'])) {
                    $conversionRates = $data['conversion_rates'];
    
                    // Fetch all currencies and update exchange rates
                    $currencies = Currency::all();
    
                    foreach ($currencies as $currency) {
                        $code = $currency->code;
    
                        if (isset($conversionRates[$code])) {
                            // Update the currency model
                            $currency->update([
                                'exchange_rate' => $conversionRates[$code],
                                'updated_at' => now(),
                            ]);
                        }
                    }
    
                    return response()->json(['message' => 'Currency rates updated successfully.']);
                }
            }
    
            return response()->json(['error' => 'Failed to fetch conversion rates from the API.'], 500);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
