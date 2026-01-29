<?php

namespace App\Http\Controllers;

use App\Models\Country;

class CountryController extends Controller
{
    public function getStates(string $code)
    {
        $country = Country::findOrFail($code);

        return response()->json($country->states ?? []);
    }
}
