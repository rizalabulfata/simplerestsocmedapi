<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Responses\ApiResponse;
use App\Services\PostService;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PostService $service)
    {
        $rows = $service->getListData();
        if (empty($rows)) {
            return ApiResponse::error('No data found', 404);
        }

        return ApiResponse::success(PostResource::collection($rows));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request, PostService $service)
    {
        $record = $request->validated();
        try {
            $record['user_id'] = $request->user()?->id;
            $model = $service->createData($record);

            return ApiResponse::success(new PostResource($model), 'Post created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, PostService $service)
    {
        $data = $service->getData($id);

        return ApiResponse::success(new PostResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id, PostService $service)
    {
        $record = $request->validated();

        try {
            $model = $service->updateData($id, $record);

            return ApiResponse::success(new PostResource($model), 'Post updated successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, PostService $service)
    {
        list($status, $model) = $service->deleteData($id);

        if ($status) {
            return ApiResponse::success(new PostResource($model));
        }
    }

    /**
     * Display the author post.
     */
    public function author(Request $request, PostService $service, $id = null)
    {
        $posts = $id ?
            $service->getPostByAuthorId($id) :
            $service->getPostByAuthor($request->user());
        return ApiResponse::success(PostResource::collection($posts));
    }

    /**
     * Like a post.
     */
    public function like(Request $request, PostService $service, int $id)
    {
        $data = $request->method() === 'GET' ?
            PostResource::collection($service->likedPosts($id)) :
            new PostResource($service->like($request->user(), $id));

        return ApiResponse::success($data);
    }

    /**
     * Unlike a post.
     */
    public function unlike(Request $request, PostService $service, int $id)
    {
        $data = $service->unlike($request->user(), $id);
        return ApiResponse::success($data);
    }

    /**
     * Display the liked posts.
     */
    public function liked(Request $request, PostService $service)
    {
        $data = $service->likedPostsByUser($request->user());
        return ApiResponse::success(PostResource::collection($data));
    }
}
