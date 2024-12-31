<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comment = Comment::all();
        return view("comments.index", compact("comment"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("comments.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $postId)
    {
        $request->validate([
            'description' => 'required|string|max:500',
        ]);
        $post = Post::findOrFail($postId);
        $user_id = Auth::id();

        $comment = Comment::create([
            "description" => $request->description,
            'user_id' => $user_id,
            'post_id' => $post->id,
        ]);

        return redirect()->route('post.show', $post->id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function edit($postId, $id)
    {
        $post = Post::findOrFail($postId);
        $comment = Comment::findOrFail($id);
        $this->authorize('update', $comment);
        return view('comments.edit', compact('post', 'comment'));
    }

    public function update(Request $request, $postId, $id)
    {
        $request->validate([
            'description' => 'required|string|max:500',
        ]);

        $comment = Comment::findOrFail($id);
        $this->authorize('update', $comment);
        $comment->description = $request->description;
        $comment->save();
        return redirect()->route('post.show', $postId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($postId, $id)
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect()->route('post.show', $postId);
    }
}
