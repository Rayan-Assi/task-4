<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('manageUser', User::class);
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('manageUser', User::class);
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('manageUser', User::class);
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/images/categories'), $imageName);
        }
        Category::create([
            'title' => $request->title,
            'image' => $imageName,
        ]);
        return redirect()->route('categories.index');
    }
    /**
     * Display the specified resource.
     */
    public function show($id) {
        $category = Category::findOrFail($id);
        return view('categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorize('manageUser', User::class);
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $imageName = $category->image;

        if ($request->hasFile('image')) {
            if ($imageName && File::exists(public_path('/images/categories/' . $imageName))) {
                File::delete(public_path('/images/categories/' . $imageName));
            }
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/images/categories'), $imageName);
        }

        $category->update([
            'title' => $request->title,
            'image' => $imageName,
        ]);

        return redirect()->route('categories.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorize('manageUser', User::class);
        $category = category::findOrFail($id);
        $oldImage = $category->image;

        if ($oldImage) {
            $imagePath = public_path('/images/categories/' . $oldImage);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $category->delete();

        return redirect()->route('categories.index');
    }
}
