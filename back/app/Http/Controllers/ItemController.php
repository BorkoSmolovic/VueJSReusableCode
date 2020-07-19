<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::all();
    }

    public function activeItems()
    {
        return Item::where('isActive', 1)->get();
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
            'name' => 'required'
        ]);

        $itemExists = Item::where('name', $request->name)->first();
        if ($itemExists != null) {
            if ($itemExists->isActive) {
                abort(427, "Item already exists");
            } else {
                abort(434, "Item already exists but it is inactive");
            }
        }

        $item = Item::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return Item::where('id', $item->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $itemExists = Item::where('name', $request->name)->where('id', '!=', $item->id)->first();
        if ($itemExists != null) {
            if ($itemExists->isActive) {
                abort(427, "Item already exists");
            } else {
                abort(434, "Item already exists but it is inactive");
            }
        }

        $item->update([
            'name' => $request->name,
            'isActive' => $item->isActive,
            'user_id' => Auth::id(),
        ]);

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->update([
            'isActive' => !$item->isActive,
            'user_id' => Auth::id(),
        ]);

        return $item;
    }
}
