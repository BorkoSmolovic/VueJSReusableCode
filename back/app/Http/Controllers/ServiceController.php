<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Service::orderBy("name")->get();
    }

    /**
     *  Returns active services
     *
     * @return \Illuminate\Http\Response
     */
    public function activeItems()
    {
        return Service::where('isActive', 1)->orderBy("name")->get();
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
        $request->validate(['name' => 'required|unique:services']);
        $serviceFromDB = Service::where('name', $request->name)->first();

        if ($serviceFromDB != null) {
            if ($serviceFromDB->isActive) {
                abort(427, "Item already exists");
            } else {
                abort(434, "Item already exists but it is inactive");
            }
        }

        $service = Service::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return Service::where('id', $service->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|unique:services'
        ]);

        $service->update([
            'name' => $request->name,
            'isActive' => $service->isActive,
            'user_id' => Auth::id(),
        ]);

        return response($service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->update([
            'isActive' => !$service->isActive,
            'user_id' => Auth::id(),
        ]);

        return response($service);
    }
}
