<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId): RedirectResponse {

        $validated = $request->validate([
            'content' => 'required|string|max:255'
        ]);

        Post::findOrFail($postId)
            ->comments()
            ->create([...$validated, 'post_id' => $postId, 'user_id' => Auth::id()]);
        return redirect()->back();
    }

    public function destroy($postId, $commentId): RedirectResponse {
        Post::findOrFail($postId)
            ->comments()
            ->findOrFail($commentId)
            ->delete();
        return redirect()->back();
    }

    public function update(Request $request, $postId, $commentId): RedirectResponse {
        $validated = $request->validate([
            'content' => 'required|string|max:255'
        ]);

        Post::findOrFail($postId)
            ->comments()
            ->findOrFail($commentId)
            ->update($validated);
        return redirect()->back();
    }

    public function edit($postId, $commentId) {
        $comment = Post::findOrFail($postId)
            ->comments()
            ->findOrFail($commentId);
        return view('comments.edit', compact('comment'));
    }
}
