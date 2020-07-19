<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankAccount;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($partner_id)
    {
        return BankAccount::where('isActive', 1)->where('partner_id', '=', $partner_id)->get();
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
            'account_number' => 'required|max:50',
            'bank_id' => 'required',
            'partner_id' => 'required',
        ]);

        $bankAccount = BankAccount::where('bank_id', $request->bank_id)->where('account_number', $request->account_number)->first();
        if($bankAccount != null){
            if($bankAccount->isActive){
                abort(427, "Bank account already exists");
            }else{
                abort(434, "Bank account already exists but it is inactive");
            }
        }

        $bankAccount = BankAccount::create([
            'account_number' => $request->account_number,
            'bank_id' => $request->bank_id,
            'isActive' => 1,
            'partner_id' => $request->partner_id,
            'user_id' => Auth::id(),
        ]);

        return BankAccount::where('id', $bankAccount->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankAccount $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankAccount $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\BankAccount $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'account_number' => 'required|max:50',
            'bank_id' => 'required',
        ]);

        $bankAccountExists = BankAccount::where('bank_id', $request->bank_id)->where('account_number', $request->account_number)->where('id', '!=', $bankAccount->id)->first();
        if($bankAccountExists != null){
            if($bankAccountExists->isActive){
                abort(427, "Bank account already exists");
            }else{
                abort(434, "Bank account already exists but it is inactive");
            }
        }

        $bankAccount->update([
            'account_number' => $request->account_number,
            'bank_id' => $request->bank_id,
            'isActive' => $bankAccount->isActive,
            'user_id' => Auth::id(),
        ]);

        return BankAccount::where('id', $bankAccount->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankAccount $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->update([
            'isActive' => !$bankAccount->isActive,
            'user_id' => Auth::id(),
        ]);

        return BankAccount::where('id', $bankAccount->id)->first();
    }
}
