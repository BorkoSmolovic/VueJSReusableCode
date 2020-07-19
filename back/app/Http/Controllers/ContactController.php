<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contact::all();
    }

    public function getContactByPartnerId($partner_id){
        return Contact::where('partner_id', $partner_id)->where('isActive', 1)->get();
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

    public function activeContactByPartnerId($partner_id){
        return Contact::where('isActive', 1)->where('partner_id',$partner_id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact' => 'required|max:100',
            'partner_id' => 'required',
            'contact_type_id' => 'required'
        ]);

        $contactExists = Contact::where('contact', $request->contact)->first();
        if($contactExists != null){
            if($contactExists->is_active){
                abort(427, "Contact already exists");
            }else{
                abort(434, "Contact already exists but it is inactive");
            }
        }

        $contact = Contact::addContact($request->contact, $request->partner_id, $request->contact_type_id, Auth::id());
        return Contact::where('id', $contact->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'contact' => 'required|max:100',
            'contact_type_id' => 'required'
        ]);

        $contactExists = Contact::where('contact', $request->contact)->where('id', '!=', $contact->id)->first();
        if($contactExists != null){
            if($contactExists->is_active){
                abort(427, "Contact already exists");
            }else{
                abort(434, "Contact already exists but it is inactive");
            }
        }

        $contact->update([
            'contact' => $request->contact,
            'contact_type_id' => $request->contact_type_id,
            'user_id' => Auth::id()
        ]);

        return Contact::where('id', $contact->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->update([
            'isActive' => 0,
            'user_id' => Auth::id()
        ]);
        return Contact::where('id', $contact->id)->first();
    }
}
