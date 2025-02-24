<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(AuthRegisterRequest $request, AuthService $service)
    {
        $record = $request->validated();

        $register = $service->registerUser($record);

        return $register;
    }

    /**
     * Login a user.
     */
    public function login(AuthLoginRequest $request, AuthService $service)
    {
        $record = $request->validated();

        $login = $service->loginUser($record);
        if (!$login) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return $login;
    }

    /**
     * Logout a user.
     */
    public function logout(Request $request, AuthService $service)
    {
        $logout = $service->logoutUser($request->user());

        return $logout;
    }
}
