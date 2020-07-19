<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bank::orderBy('name')->get();
    }

    public function activeBanks(){
        return Bank::where('isActive', 1)->get();
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
           'no' => 'required|max:4',
        ]);

        $bankExists = Bank::where('name', $request->name)->where('no', $request->no)->first();

        if($bankExists != null) {
            if($bankExists->isActive) {
                abort(427, "Bank already exists");
            }else{
                abort(434, "Bank already exists but it is inactive");
            }
        }

        $bank = Bank::create([
            'name' => $request->name,
            'no' => $request->no,
            'user_id' => Auth::id(),
        ]);

        return Bank::where('id', $bank->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required|max:100',
            'no' => 'required|max:4',
        ]);

        $bank->update([
            'name' => $request->name,
            'no' => $request->no,
            'user_id' => Auth::id(),
        ]);

        return Bank::where('id', $bank->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->update([
            'isActive' => !$bank->isActive,
            'user_id' => Auth::id(),
        ]);

        return Bank::where('id', $bank->id)->first();
    }
}
