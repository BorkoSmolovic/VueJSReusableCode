<?php

namespace App\Http\Controllers;

use App\Country;
use DemeterChain\C;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Country::with('city')->orderBy('name')->get();
    }

    public function activeCountries()
    {
        return Country::with('city')->where('isActive', 1)->orderBy('name')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $country = Country::where('name', $request->name)->first();
        if ($country != null) {
            if ($country->isActive) {
                abort(427, "Country already exists");
            } else {
                abort(434, "Country already exists but it is inactive");
            }
        }

        return Country::create([
            'name' => $request->name,
            'isActive' => 1,
            'user_id' => Auth::id(),
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Country $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Country $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Country $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $countryExists = Country::where('name', $request->name)->where('id', '!=', $country->id)->first();
        if ($countryExists != null) {
            if ($countryExists->isActive) {
                abort(427, "Country already exists");
            } else {
                abort(434, "Country already exists but it is inactive");
            }
        }

        $country->update([
            'name' => $request->name,
            'isActive' => $country->isActive,
            'user_id' => Auth::id(),
        ]);

        return $country;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Country $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->update([
            'isActive' => !$country->isActive,
            'user_id' => Auth::id(),
        ]);
        return $country;
    }
}
