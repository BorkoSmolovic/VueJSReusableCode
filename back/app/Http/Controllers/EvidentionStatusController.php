<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Contract;
use App\Evidention;
use App\EvidentionStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvidentionStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EvidentionStatus::with('status')->get();
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
            'evidention_id' => 'required',
            'status_id' => 'required',
        ]);
        DB::beginTransaction();
        $evidentionStatus = EvidentionStatus::where('evidention_id', $request->evidention_id)->latest()->first();
        if ($request->status_id < $evidentionStatus->status_id) {
            abort(500, "You can't switch to this status");
        } elseif ($evidentionStatus->status_id == 6) {
            abort(500, "This evidention is completed");
        }
        $evidentionStatus = EvidentionStatus::add($request->status_id, $request->evidention_id, Auth::id());
        //ako se odbije snimanje, mora se povecati u contracts recordings_remaining
        if($request->status_id == 3) {
            $evidention = Evidention::find($request->evidention_id);
            $contract = Contract::find($evidention->contract_id);
            $contract->recordings_remaining = $contract->recordings_remaining + 1;
            $contract->update();
        }
        DB::commit();
        return EvidentionStatus::with('status')->where('id', $evidentionStatus->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\EvidentionStatus $evidentionStatus
     * @return \Illuminate\Http\Response
     */
    public function show(EvidentionStatus $evidentionStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\EvidentionStatus $evidentionStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(EvidentionStatus $evidentionStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\EvidentionStatus $evidentionStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvidentionStatus $evidentionStatus)
    {
        $request->validate([
            'status_id' => 'required',
        ]);

        $evidentionStatus->update([
            'evidention_id' => $evidentionStatus->evidention_id,
            'status_id' => $request->status_id,
            'user_id' => Auth::id(),
            'isActive' => $evidentionStatus->isActive,
        ]);

        return EvidentionStatus::with('status')->where('id', $evidentionStatus->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\EvidentionStatus $evidentionStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvidentionStatus $evidentionStatus)
    {
        $evidentionStatus->update([
            'user_id' => Auth::id(),
            'isActive' => !$evidentionStatus->isActive,
        ]);

        return EvidentionStatus::with('status')->where('id', $evidentionStatus->id)->first();
    }
}
