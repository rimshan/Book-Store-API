<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\Authenticator;


class AuthController extends Controller
{

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }


    protected function login(Request $request) {

        $request->request->add([
            'provider' => 'admins'
        ]);

        $credentials = array_values($request->only('username', 'password', 'provider'));

        if ($user = $this->authenticator->attempt(...$credentials)) {
            $request->request->add([
                'scope' => 'admin',
                'grant_type' => 'password',
                'client_id' => config('auth.admin_client_id'),
                'client_secret' => config('auth.admin_client_secret'),
            ]);

            return Route::dispatch(
                Request::create('/oauth/token', 'post', $request->toArray())
            );
        }
        else {
            return response()->json(['error' => 'Your username/password combination was incorrect'], 401);
        }
    }
}
