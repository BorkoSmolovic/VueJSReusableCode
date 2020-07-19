<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\GeneralTrait;

class UserController extends Controller
{
    use GeneralTrait;
    /**
     * Disisplay a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('language')->with('partner')->get();
    }

    public function getLogedUserData()
    {
        return User::where('id', '=', Auth::id())->with('language')->get();
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
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255|min:8',
            'partner_id' => 'present'
        ]);

        $user = User::where('username', $request->username)->first();
        if($user != null){
            abort(427, "Username already exists");
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'language_id' => 1,
            'partner_id' => $request->partner_id,
            'isActive' => 1,
            'password' => Hash::make($request->password),
        ]);

        return User::where('id', '=', $user->id)->with('language')->with('partner')->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function updateCurrentUser(Request $request)
    {
        $user = User::find(Auth::id());
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
//            'language_id' => 'required',
            'password' => 'present'
        ]);

        $user1 = User::where('username', $request->username)->where('id', '<>', Auth::id())->first();
        if($user1 != null){
            abort(427, "Username already exists");
        }

        if ($request->password != '') {
            $request->validate([
                'password' => 'required|string|max:255|min:8',
            ]);

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'language_id' => 1,
                'password' => Hash::make($request->password),
            ]);

        }
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'language_id' => 1
        ]);

        return User::where('id', '=', $user->id)->with('language')->with('partner')->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'present',
            'partner_id' => 'present'
        ]);

        $user1 = User::where('username', $request->username)->where('id', '<>', $user->id)->first();
        if($user1 != null){
            abort(427, "Username already exists");
        }

        if ($request->password != '') {
            $request->validate([
                'password' => 'required|string|max:255|min:8',
            ]);

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'partner_id' => $request->partner_id
            ]);

            return User::where('id', '=', $user->id)->with('language')->with('partner')->first();
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'partner_id' => $request->partner_id
        ]);


        return User::where('id', '=', $user->id)->with('language')->with('partner')->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $ida
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {

        $user = User::find($id);


        $user->update([
            'isActive' => !$user->isActive,
        ]);

        return User::where('id', '=', $user->id)->with('language')->with('partner')->first();
    }
}
