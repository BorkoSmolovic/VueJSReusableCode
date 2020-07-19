<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Contract;
use App\Evidention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contract::with('partner')->orderBy("id")->get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function readContractsByPartnerId($partnerId)
    {
        return Contract::where('partner_id', $partnerId)->where('recordings_remaining', '>', 0)->get();
    }
    public function readContractsByPartnerIdActive($partnerId)
    {
        return Contract::where('partner_id', $partnerId)->where('isActive', 1)->where('recordings_remaining', '>', 0)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'partner_id' => 'required',
            'dateFrom' => 'required',
            'contract_name' => 'required',
            'dateTo' => 'required',
            'number_of_recordings' => 'required|integer|min:1'
        ]);
        $contractExists = Contract::where('contract_name', $request->contract_name)->first();
        if($contractExists != null){
            if($contractExists->isActive){
                abort(427, "Contract already exists");
            }else{
                abort(434, "Contract already exists but it is inactive");
            }
        }
        if($request->dateFrom > $request->dateTo){
            abort(435, "Invalid duration of contract");
        }
        $contract = Contract::create([
            'contract_name' => $request->contract_name,
            'partner_id' => $request->partner_id,
            'dateFrom' => $request->dateFrom,
            'dateTo' => $request->dateTo,
            'number_of_recordings' => $request->number_of_recordings,
            'isActive' => 1,
            'recordings_remaining' => $request->number_of_recordings,
            'user_id' => Auth::id(),
        ]);

        return Contract::with('partner')->where('id', $contract->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'partner_id' => 'required',
            'contract_name' => 'required',
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'number_of_recordings' => 'required|integer|min:1'
        ]);

        if(Evidention::where('contract_id', $contract->id)->first() != null){
            abort(436, "You cannot change this contract");
        }

        $contractExists = Contract::where('contract_name', $request->contract_name)->where('id', '!=', $contract->id)->first();
        if($contractExists != null){
            if($contractExists->isActive){
                abort(427, "Contract already exists");
            }else{
                abort(434, "Contract already exists but it is inactive");
            }
        }
        if($request->dateFrom > $request->dateTo){
            abort(435, "Invalid duration of contract");
        }
        $contract->update([
            'contract_name' => $request->contract_name,
            'partner_id' => $request->partner_id,
            'dateFrom' => $request->dateFrom,
            'dateTo' => $request->dateTo,
            'recordings_remaining' => $request->number_of_recordings,
            'number_of_recordings' => $request->number_of_recordings,
            'isActive' => $contract->isActive,
            'user_id' => Auth::id(),
        ]);

        return Contract::with('partner')->where('id', $contract->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        if(Evidention::where('contract_id', $contract->id)->first() != null){
            abort(436, "You cannot change this contract");
        }

        $contract->update([
            'isActive' => !$contract->isActive,
            'user_id' => Auth::id(),
        ]);

        return Contract::with('partner')->where('id', $contract->id)->first();
    }
}
