<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the own profile.
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Display the specified user profile.
     */
    public function profile(string $id, UserService $service)
    {
        $data = $service->getData($id);
        return response()->json($data);
    }

    /**
     * Display the followers of the specified user.
     */
    public function followers(Request $request, UserService $service, int $id = null)
    {
        $data = $service->getFollowers($request->user(), $id);
        return response()->json($data);
    }

    /**
     * Display the following of the specified user.
     */
    public function following(Request $request, UserService $service, int $id = null,)
    {
        $data = $service->getFollowing($request->user(), $id);
        return response()->json($data);
    }

    /**
     * Follow a user.
     */
    public function follow(Request $request, UserService $service, int $id,)
    {
        $data = $service->follow($request->user(), $id);
        return response()->json($data);
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(Request $request, int $id, UserService $service)
    {
        $data = $service->unfollow($request->user(), $id);
        return response()->json($data);
    }
}
