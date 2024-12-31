<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('manageUser', User::class);
        $tag = Tag::all();
        return view('tags.index', compact('tag'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('manageUser', User::class);
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('manageUser', User::class);
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Tag::create([
            'title' => $request->title,
        ]);
        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorize('manageUser', User::class);
        $tag = Tag::findOrFail($id);
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->authorize('manageUser', User::class);
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $tag = Tag::findOrFail($id);
        $tag->update([
            'title' => $request->title,
        ]);
        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorize('manageUser', User::class);
        $tag = tag::findOrFail($id);
        $tag->delete();
        return redirect()->route('tags.index');
    }
}
