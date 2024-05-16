<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Parsedown;

class PostController extends Controller
{
    /**
     * Makes db data available to API
     */

    public function getData(): JsonResponse
    {
        $posts = Post::all();
        $parsedown = new Parsedown();

        foreach ($posts as $post) {
            $post->content = $parsedown->text($post->content);
        }

        return response()->json($posts);
    }

    public function getDataByID(int $id): JsonResponse
    {
        $post = Post::find($id);
        $parsedown = new Parsedown();
        $post->content = $parsedown->text($post->content);
        return response()->json($post);
    }

    public function getRawData(): JsonResponse
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function getRawDataByID(int $id): JsonResponse
    {
        $post = Post::find($id);
        return response()->json($post);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'img' => 'required|string'
        ]);

        // Create post
        Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'img' => $request->input('img'),
            'user_id' => auth()->id()
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'img' => 'required|string'
        ]);

        $post = Post::findOrFail($id);

        // Update post
        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'img' => $request->input('img'),
            'user_id' => auth()->id()
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
