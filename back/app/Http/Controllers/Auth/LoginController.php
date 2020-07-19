<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Partner;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->where('isActive', 1)->first();
        $partner = Partner::find($user->partner_id);

        //if the username was not found
        if (!$user) {
            abort(422, 'User does not exist');
        }

        //if passwords do not match
        if (!Hash::check($request->password, $user->password)) {
            abort(422, 'Wrong password');
        }

        //if everything is ok create token and return response
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ["token" => $token, "expires_in" => 86400000, "partner_id" => $user->partner_id, "language" => $user->language, "partner" => $partner]; //1 Day expires_in
        return response($response, 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been successfully logged out!';
        return response($response, 200);

    }
}
