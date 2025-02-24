<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, CommentService $service, string $id)
    {
        $data = $service->comment($request->user(), $id, $request->comment);
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id, CommentService $service)
    {
        $data = $service->getComments($id);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $postId, int $commentId, CommentService $service)
    {
        $data = $service->uncomment($postId, $commentId);
        return response()->json($data);
    }
}
