<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Responses\ApiResponse;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, CommentService $service, string $id)
    {
        try {
            $data = $service->comment($request->user(), $id, $request->comment);

            return ApiResponse::success(new CommentResource($data), 'Comment successfully created', 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id, CommentService $service)
    {
        $data = $service->getComments($id);
        return ApiResponse::success(new CommentResource($data));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $postId, int $commentId, CommentService $service)
    {
        list($status, $comment) = $service->uncomment($postId, $commentId);

        return $status ?
            ApiResponse::success(new CommentResource($comment)) :
            ApiResponse::error('Failed uncomment');
    }
}
