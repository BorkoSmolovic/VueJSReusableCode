<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return City::with('country')->orderBy('name')->get();
    }

    public function activeCities(){
        return City::where('isActive', 1)->get();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'post_code' => 'required|string|max:10',
            'country_id' => 'present'
        ]);

        $cityExists = City::where('name', $request->name)->first();
        if($cityExists != null){
            if($cityExists->isActive){
                abort(427, "City already exists");
            }else{
                abort(434, "City already exists but it is inactive");
            }
        }

        $city = City::create([
            'name' => $request->name,
            'post_code' => $request->post_code,
            'isActive' => 1,
            'country_id' => $request->country_id,
            'user_id' => Auth::id(),
        ]);

        return City::with('country')->where('id', '=', $city->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\City $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\City $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'post_code' => 'present|max:10',
            'country_id' => 'present'
        ]);

        $cityExists = City::where('name', $request->name)->where('id', '!=', $city->id)->first();
        if($cityExists != null){
            if($cityExists->isActive){
                abort(427, "City already exists");
            }else{
                abort(434, "City already exists but it is inactive");
            }
        }

        $city->update([
            'name' => $request->name,
            'post_code' => $request->post_code,
            'country_id' => $request->country_id,
            'isActive' => $city->isActive,
            'user_id' => Auth::id(),
        ]);

        return City::with('country')->where('id', '=', $city->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->update([
            'isActive' => !$city->isActive,
            'user_id' => Auth::id(),
        ]);

        return $city;
    }
}
