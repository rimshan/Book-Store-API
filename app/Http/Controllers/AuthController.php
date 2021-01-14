<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    protected function register(Request $request) {

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'sometimes|nullable|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
            'contact_number' => 'required|string',
        ]);

        $response = $this->userService->createUser($request->toArray());

        return response()->json(['message' => $response['message']],
            $response['status']);
    }


    protected function login(Request $request) {

        $credentials = [
            'email' =>  request('username'),
            'password' =>  request('password'),
        ];

        if (auth()->attempt($credentials)) {
            if(Auth::user()->is_active) {
                $request->request->add([
                    'scope' => 'author',
                    'grant_type' => 'password',
                    'client_id' => config('auth.book_store_client_id'),
                    'client_secret' => config('auth.book_store_client_secret'),
                    'provider' => 'users'
                ]);
                return Route::dispatch(
                    Request::create('/oauth/token', 'post', $request->toArray())
                );
            }
            else {
                return response()->json(['error' => 'Your account is currently not active. Please contact support.'], 401);
            }
        }
        else {
            return response()->json(['error' => 'Your username/password combination was incorrect'], 401);
        }
    }
}
