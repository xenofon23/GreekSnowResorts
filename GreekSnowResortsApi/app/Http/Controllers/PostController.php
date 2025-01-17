<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('snowResort')->get();
        return response()->json($posts);
    }

    public function store($post)
    {


        $post = Post::create($post);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        $post->load('snowResort'); // Eager load the snowResort relationship
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'snow_resort_id' => 'required|exists:snow_resorts,id', // Ensure the snow_resort_id exists in the snow_resorts table
        ]);

        $post->update($validated);

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
