<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
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

        return PostResource::collection($rows);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request, PostService $service)
    {
        $record = $request->validated();

        $model = $service->createData($record);
        return new PostResource($model);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, PostService $service)
    {
        $data = $service->getData($id);
        return new PostResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id, PostService $service)
    {
        $record = $request->validated();

        $model = $service->updateData($id, $record);
        return new PostResource($model);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, PostService $service)
    {
        list($status, $model) = $service->deleteData($id);

        if ($status) {
            return new PostResource($model);
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
        return PostResource::collection($posts);
    }

    /**
     * Like a post.
     */
    public function like(Request $request, PostService $service, int $id)
    {
        $data = $request->method() === 'GET' ?
            $service->likedPosts($id) :
            $service->like($request->user(), $id);

        return response()->json($data);
    }

    /**
     * Unlike a post.
     */
    public function unlike(Request $request, PostService $service, int $id)
    {
        $data = $service->unlike($request->user(), $id);
        return response()->json($data);
    }

    /**
     * Display the liked posts.
     */
    public function liked(Request $request, PostService $service)
    {
        $data = $service->likedPostsByUser($request->user());
        return response()->json($data);
    }
}
