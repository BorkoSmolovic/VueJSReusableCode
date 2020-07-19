<?php

namespace App\Http\Controllers;

use App\PartnerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PartnerType::orderBy('name')->get();
    }

    public function activePartnerTypes(){
        return PartnerType::where('isActive', 1)->orderBy('name')->get();
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
            'name' => 'required|max:100',
        ]);

        $partnerTypeExists = PartnerType::where('name',$request->name)->first();

        if($partnerTypeExists != null){
            if($partnerTypeExists->isActive){
                abort(427, "Contact type already exists");
            } else {
                abort(434, "Contact type exists but it is inactive");
            }
        }

        return PartnerType::create([
            'name' => $request->name,
            'isActive' => 1,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PartnerType  $partnerType
     * @return \Illuminate\Http\Response
     */
    public function show(PartnerType $partnerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PartnerType  $partnerType
     * @return \Illuminate\Http\Response
     */
    public function edit(PartnerType $partnerType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PartnerType  $partnerType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartnerType $partnerType)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);

        $partnerType->update([
            'name' => $request->name,
            'isActive' => $partnerType->isActive,
            'user_id' => Auth::id(),
        ]);

        return $partnerType;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PartnerType  $partnerType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartnerType $partnerType)
    {
        $partnerType->update([
            'isActive' => !$partnerType->isActive,
            'user_id' => Auth::id(),
        ]);

        return $partnerType;
    }
}
