<?php

namespace App\Http\Controllers;

use App\Evidention;
use App\EvidentionItem;
use App\WorkerTypeWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvidentionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($evidention_id)
    {
        return EvidentionItem::with('item')->where('isActive', 1)->where('evidention_id', $evidention_id)->get();
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
            'value' => 'required',
            'item_id' => 'required',
            'vehicle_id' => 'present',
            'evidention_id' => 'required'
        ]);

        // Evidention::updatePermissions($request->evidention_id, Auth::id());

        $evidentionItem = EvidentionItem::where('evidention_id', $request->evidention_id)->where('item_id', $request->item_id)->first();

        if ($evidentionItem != null) {
            if ($evidentionItem->isActive) {
                abort(427, "Item has already been added");
            } else {
                $evidentionItem->isActive = true;
                $evidentionItem->value = $request->value;
                $evidentionItem->update();
                return EvidentionItem::with('item')->where('id', $evidentionItem->id)->first();
            }
        }

        $evidentionItem = EvidentionItem::create([
            'value' => $request->value,
            'item_id' => $request->item_id,
            'vehicle_id' => $request->vehicle_id,
            'evidention_id' => $request->evidention_id,
            'user_id' => Auth::id()
        ]);

        return EvidentionItem::with('item')->where('id', $evidentionItem->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\EvidentionItem $evidentionItem
     * @return \Illuminate\Http\Response
     */
    public function show(EvidentionItem $evidentionItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\EvidentionItem $evidentionItem
     * @return \Illuminate\Http\Response
     */
    public function edit(EvidentionItem $evidentionItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\EvidentionItem $evidentionItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvidentionItem $evidentionItem)
    {
        $request->validate([
            'value' => 'required',
            'item_id' => 'required',
            'vehicle_id' => 'present',
        ]);

        // Evidention::updatePermissions($evidentionItem->evidention_id, Auth::id());
        $evidentionItemUpdate = EvidentionItem::where('evidention_id', $request->evidention_id)->where('item_id', $request->item_id)->where('vehicle_id', $request->vehicle_id)->where('id', '!=', $evidentionItem->id)->first();

        if ($evidentionItemUpdate != null) {
            if ($evidentionItemUpdate->isActive) {
                abort(427, "Item has already been added");
            } else {
                $evidentionItem->isActive = false;
                $evidentionItem->update();

                $evidentionItemUpdate->isActive = true;
                $evidentionItemUpdate->value = $request->value;
                $evidentionItemUpdate->update();
                return EvidentionItem::with('item')->where('id', $evidentionItemUpdate->id)->first();
            }
        }

        $evidentionItem->update([
            'value' => $request->value,
            'item_id' => $request->item_id,
            'vehicle_id' => $request->vehicle_id,
            'evidention_id' => $evidentionItem->evidention_id,
            'isActive' => $evidentionItem->isActive,
            'user_id' => Auth::id()
        ]);

        return EvidentionItem::with('item')->where('id', $evidentionItem->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\EvidentionItem $evidentionItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvidentionItem $evidentionItem)
    {
        // Evidention::updatePermissions($evidentionItem->evidention_id, Auth::id());

        $evidentionItem->update([
            'isActive' => false,
            'user_id' => Auth::id()
        ]);

        return EvidentionItem::with('item')->where('id', $evidentionItem->id)->first();
    }
}
