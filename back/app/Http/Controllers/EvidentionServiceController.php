<?php

namespace App\Http\Controllers;

use App\Evidention;
use App\EvidentionService;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvidentionServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($evidention_id)
    {

        return EvidentionService::with('services')->where('isActive', 1)->where('evidention_id', $evidention_id)->get();
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
            'service_id' => 'required',
            'evidention_id' => 'required'
        ]);

        // Evidention::updatePermissions($request->evidention_id, Auth::id());
        $evidentionService = EvidentionService::where('service_id', $request->service_id)->where('evidention_id', $request->evidention_id)->first();

        if ($evidentionService != null) {
            if ($evidentionService->isActive) {
                abort(427, "Evidention service is already added");
            } else {
                $evidentionService->isActive = true;
                $evidentionService->update();
                return EvidentionService::with('services')->where('id', $evidentionService->id)->first();
            }
        }

        $evidentionService = EvidentionService::create([
            'service_id' => $request->service_id,
            'evidention_id' => $request->evidention_id,
            'user_id' => Auth::id()
        ]);

        return EvidentionService::with('services')->where('id', $evidentionService->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\EvidentionService $evidentionService
     * @return \Illuminate\Http\Response
     */
    public function show(EvidentionService $evidentionService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\EvidentionService $evidentionService
     * @return \Illuminate\Http\Response
     */
    public function edit(EvidentionService $evidentionService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\EvidentionService $evidentionService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvidentionService $evidentionService)
    {
        $request->validate([
            'service_id' => 'required',
            'evidention_id' => 'required'
        ]);

        //Evidention::updatePermissions($request->evidention_id, Auth::id());

        $evidentionService::update([
            'service_id' => $request->service_id,
            'evidention_id' => $request->evidention_id,
            'isActive' => $evidentionService->isActive,
            'user_id' => Auth::id()
        ]);

        return $evidentionService->with('services')->where('id', $evidentionService->id)->get()->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\EvidentionService $evidentionService
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvidentionService $evidentionService)
    {
        $evidentionService->update([
            'isActive' => false,
            'user_id' => Auth::id()
        ]);

        return EvidentionService::with('services')->where('id', $evidentionService->id)->first();
    }
}
