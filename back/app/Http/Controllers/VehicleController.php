<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Vehicle::all();
    }

    public function activeVehicles(){
        return Vehicle::where('isActive', 1)->get();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'plates' => 'present',
        ]);

        $vehicleExists = Vehicle::where('plates', $request->plates)->first();
        if($vehicleExists != null){
            if($vehicleExists->isActive){
                abort(427, "Vehicle already exists");
            }else{
                abort(434, "Vehicle already exists but it is inactive");
            }
        }

        $vehicle = Vehicle::create([
            'type' => $request->type,
            'plates' => $request->plates,
            'user_id' => Auth::id()
        ]);

        return Vehicle::where('id', $vehicle->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'type' => 'required',
            'plates' => 'present',
        ]);

        $vehicleExists = Vehicle::where('plates', $request->plates)->where('id', '!=', $vehicle->id)->first();
        if($vehicleExists != null){
            if($vehicleExists->isActive){
                abort(427, "Vehicle already exists");
            }else{
                abort(434, "Vehicle already exists but it is inactive");
            }
        }

        $vehicle->update([
            'type' => $request->type,
            'plates' => $request->plates,
            'user_id' => Auth::id(),
            'isActive' => $vehicle->isActive
        ]);

        return Vehicle::where('id', $vehicle->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->update([
            'user_id' => Auth::id(),
            'isActive' => !$vehicle->isActive
        ]);

        return Vehicle::where('id', $vehicle->id)->first();
    }
}
