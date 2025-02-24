<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Resources\AuthResource;
use App\Http\Responses\ApiResponse;
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

        try {
            list($user, $token) = $service->registerUser($record);

            $response = new AuthResource([$user, $token]);
            return ApiResponse::success($response, 'User registered successfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * Login a user.
     */
    public function login(AuthLoginRequest $request, AuthService $service)
    {
        $record = $request->validated();

        try {
            $login = $service->loginUser($record);
            if (!$login) {
                return ApiResponse::error('Invalid credentials', 401);
            }

            return ApiResponse::success($login, 'User logged in successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return $login;
    }

    /**
     * Logout a user.
     */
    public function logout(Request $request, AuthService $service)
    {
        try {
            $logout = $service->logoutUser($request->user());

            return ApiResponse::success($logout, 'User logged out successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }

        return $logout;
    }
}
