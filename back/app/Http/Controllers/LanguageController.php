<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Language::all();
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
            'name' => 'required',
            'value' => 'required',
            'flag' => 'required'
        ]);

        return Language::create([
            'name' => $request->name,
            'value' => $request->value,
            'user_id' => Auth::id(),
            'flag' => $request->flag,
            'isActive' => 1
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Language $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Language $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Language $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required',
            'flag' => 'required'
        ]);

        $language->update([
            'name' => $request->name,
            'value' => $request->value,
            'user_id' => Auth::id(),
            'flag' => $request->flag,
            'isActive' => $language->isActive
        ]);

        return $language;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Language $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        $language->update([
            'isActive' => !$language->isActive,
            'user_id' => Auth::id()
        ]);

        return $language;
    }
}
