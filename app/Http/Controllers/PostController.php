<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        /* return view("posts.index")->with("posts".$posts); */
        return view("posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /*        $this->authorize('manageUser', User::class); 
 */
        return view("posts.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:55',
            'description' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'tags' => 'required|array',
            'category_id' => 'required|exists:categories,id',

        ]);

        $imageName = "";
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = $file->getClientOriginalName() . "-" . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('/images/posts'), $imageName);
        }
        $user_id = Auth::id();
        /*     
        dd($request); */
        $post = Post::create([
            "title" => $request->title,
            "description" => $request->description,
            "image" => $imageName,
            'user_id' => $user_id,
            'category_id' => $request->category_id,

        ]);
        $post->tags()->attach($request->tags);
        return redirect()->route("posts.index");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with('comments')->findOrFail($id); 
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $posts = Post::findOrFail($id);
        $this->authorize('update', $posts);
        return view('posts.edit', compact('posts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:55',
            'description' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', // تغيير إلى nullable
            'tags' => 'required|array',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        $post = Post::findOrFail($id);
        $imageName = $post->image;
    
        if ($request->hasFile('image')) {
            if ($imageName && File::exists(public_path('/images/posts/' . $imageName))) {
                File::delete(public_path('/images/posts/' . $imageName));
            }
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/images/posts'), $imageName);
        }
    
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
            'category_id' => $request->category_id,
        ]);
        $post->tags()->sync($request->tags);
    
        return redirect()->route('posts.index');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        $oldImage = $post->image;

        if ($oldImage) {
            $imagePath = public_path('/images/posts/' . $oldImage);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $post->tags()->detach();
            $post->delete();
            return redirect()->route("posts.index");
        }
    }
}
