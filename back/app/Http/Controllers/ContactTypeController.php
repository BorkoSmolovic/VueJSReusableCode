<?php

namespace App\Http\Controllers;

use App\ContactType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ContactType::orderBy('name')->get();
    }

    public function activeContactTypes()
    {
        return ContactType::where('isActive', 1)->get();
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
            'name' => 'required|max:100',
            'icon' => 'present'
        ]);

        $contactTypeExists = ContactType::where('name', $request->name)->first();

        if ($contactTypeExists != null) {
            if ($contactTypeExists->isActive) {
                abort(427, "Contact type already exists");
            } else {
                abort(434, "Contact type exists but it is inactive");
            }
        }

        $contactType = ContactType::create([
            'name' => $request->name,
            'isActive' => 1,
            'icon' => $request->icon,
            'user_id' => Auth::id(),
        ]);

        return ContactType::where('id', $contactType->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ContactType $contactType
     * @return \Illuminate\Http\Response
     */
    public function show(ContactType $contactType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ContactType $contactType
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactType $contactType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ContactType $contactType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactType $contactType)
    {
        $request->validate([
            'name' => 'required|max:100',
            'icon' => 'present'
        ]);

        $contactType->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'isActive' => $contactType->isActive,
            'user_id' => Auth::id(),
        ]);

        return ContactType::where('id', $contactType->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ContactType $contactType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactType $contactType)
    {
        $contactType->update([
            'isActive' => !$contactType->isActive,
            'user_id' => Auth::id(),
        ]);

        return ContactType::where('id', $contactType->id)->first();
    }
}
