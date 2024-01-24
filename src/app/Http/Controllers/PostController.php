<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $data = Post::get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Data found',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ], 404);
        }

    }

    public function store(PostRequest $request)
    {
        try {
            Post::create($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Post Created Successfully',
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function update(PostRequest $request,Post $post)
    {
        try {
            $post->update($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Post Updated Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function destroy(Post $post)
    {
        if ($post->delete() == true) {
            return response()->json([
                'status' => true,
                'message' => 'Post Deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ], 404);
        }
    }

}
