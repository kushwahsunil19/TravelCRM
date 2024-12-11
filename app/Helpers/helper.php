<?php

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Models\{Currency};
if (!function_exists('getPermission')) {
    function getPermission()
    {
        // Return the permissions as an array
        return auth()->user() ? auth()->user()->getAllPermissions()->toArray() : [];
    }
}


if (!function_exists('getRolePermissions')) {
    function getRolePermissions()
    {
        $roles = Role::all();
        $data = []; // Initialize the data array

        foreach ($roles as $role) {
        // Create an array entry for each role with its permissions
         $data[$role->name] = $role->permissions->pluck('name')->toArray(); // Collect permissions for each role
        }
        return $data;
    }
}
if (!function_exists('getAuth')) {
    /**
     * Generate a random string of specified length.
     *
     * @param int $length
     * @return string
     */
    function getAuth()
    {
        $user = Auth::user();

        if (Auth::check() && $user) {
            return $user;
        } else {
           return null;
        }
    }
}

    if (!function_exists('getCurrencyRate')) {
    /**
     * Get the currency conversion rate.
     *
     * @param string $branch Branch name (e.g., 'Dubai').
     * @param string $currency_code Target currency code (e.g., 'USD').
     * @return float|bool The conversion rate, or false on failure.
     */
    function getCurrencyRate( $currency_code = '')
    {
        // Determine base currency based on the branch
        $baseCurrency = ($currency_code) ? $currency_code:'AED';
        
        // API Key and URL
        $apiKey = env('CURRENT_CURRENCY_RATE_KEY');
        if (!$apiKey) {
            throw new \Exception('Currency API key is not set in the environment.');
        }
        $apiUrl = "https://v6.exchangerate-api.com/v6/$apiKey/latest/$baseCurrency";

        // Fetch the conversion rates
        $conversionRates = fetchCurrencyRates($apiUrl);
        return $conversionRates;
        // Return the conversion rate for the requested currency code
        return $conversionRates[$currency_code] ?? false;
    }

    /**
     * Fetch currency rates from an API.
     *
     * @param string $apiUrl API URL to fetch conversion rates.
     * @return array|bool An array of conversion rates, or false on failure.
     */
    function fetchCurrencyRates($apiUrl)
    {
        try {
            
            $response = file_get_contents($apiUrl);
            $data = json_decode($response, true);
        
            if (isset($data['result']) && $data['result'] === 'success') {
                return $data['conversion_rates'];
            }

            return false;
        } catch (\Exception $e) {
            // Log the exception (optional)
            \Log::error('Error fetching currency rates: ' . $e->getMessage());
            return false;
        }
    }

    if (!function_exists('getCurrencyRateAmt')) {
        function getCurrencyRateAmt($fromCurrency = '', $toCurrency = '', $amount = '')
        {
            // Ensure we have both from and to currency
            if (empty($fromCurrency) || empty($toCurrency)) {
                throw new Exception("Both fromCurrency and toCurrency are required.");
            }
    
            // Fetch the rates for the fromCurrency and toCurrency from the Currency model
            $fromRate = Currency::where('code', $fromCurrency)->first();
            $toRate = Currency::where('code', $toCurrency)->first();
    
            // Check if both rates exist
            if (!$fromRate || !$toRate) {
                throw new Exception("Currency rates not found for the given currencies.");
            }
    
            // Base currency rate (assuming AED as the base currency)
            $fromCurrencyRate = $fromRate->exchange_rate; // Assuming the 'rate' column stores the exchange rate
            $toCurrencyRate = $toRate->exchange_rate; // Assuming the 'rate' column stores the exchange rate
    
            // Convert the amount to base currency (AED) first
            $amountInBase = $amount / $fromCurrencyRate;
    
            // Convert the amount from base currency (AED) to the target currency
            $convertedAmount = $amountInBase * $toCurrencyRate;
    
            // Round the converted amount to 2 decimal places
            $roundedAmount = round($convertedAmount, 2);
    
            return $roundedAmount; // Return the rounded converted amount
        }
    }
    
    
}
