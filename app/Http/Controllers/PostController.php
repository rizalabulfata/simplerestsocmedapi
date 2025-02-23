<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Exception;

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
}
