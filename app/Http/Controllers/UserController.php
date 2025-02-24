<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Services\UserService;

class UserController extends Controller
{
    /**
     * Display the own profile.
     */
    public function me(BaseRequest $request)
    {
        return ApiResponse::success(
            new UserResource($request->user())
        );
    }

    /**
     * Display the specified user profile.
     */
    public function profile(string $id, UserService $service)
    {
        $data = $service->getData($id);
        return ApiResponse::success(
            new UserResource($data)
        );
    }

    /**
     * Display the followers of the specified user.
     */
    public function followers(BaseRequest $request, UserService $service, int $id = null)
    {
        $data = $service->getFollowers($request->user(), $id);
        return ApiResponse::success(
            UserResource::collection($data)
        );
    }

    /**
     * Display the following of the specified user.
     */
    public function following(BaseRequest $request, UserService $service, int $id = null,)
    {
        $data = $service->getFollowing($request->user(), $id);
        return ApiResponse::success(
            UserResource::collection($data)
        );
    }

    /**
     * Follow a user.
     */
    public function follow(BaseRequest $request, UserService $service, int $id)
    {
        $data = $service->follow($request->user(), $id);
        return ApiResponse::success($data);
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(BaseRequest $request, int $id, UserService $service)
    {
        $data = $service->unfollow($request->user(), $id);
        return ApiResponse::success($data);
    }
}
