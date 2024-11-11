<?php
namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;


class LocationController extends Controller
{

    public function index()
    {

        // Fetch all countries
        $countries = Country::all();
    
        // Pass countries to the view
        return view('partners.partners', compact('countries'));
    }
    

    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get();  // Fetch states for the given country
        return response()->json($states);
    }

    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->get();  // Fetch cities for the given state
        return response()->json($cities);
    }
}
