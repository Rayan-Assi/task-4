<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('manageUser', User::class);
        $users = User::all();
        return view('users.index', compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('manageUser', User::class);
        return view('users.login2');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('manageUser', User::class);
        $request->validate([
            'UserName' => 'required|string|max:55',
            'UserEmail' => 'required|string|email|max:255',
            'UserPassword' => 'required|string|min:8|confirmed',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',

        ]);
        $imageName = "";
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = $file->getClientOriginalName() . "-" . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('/images/users'), $imageName);
        }


        /* dd($request); */
        User::create([
            'name' => $request->UserName,
            'email' => $request->UserEmail,
            'password' => Hash::make($request->UserPassword),
            'image' => $imageName,
            'is_admin' => false
        ]);

        return redirect()->route("users.index");
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
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->authorize('manageUser', User::class);
        $request->validate([
            'UserName' => 'required|string|max:55',
            'UserEmail' => 'required|string|email|max:255',
            'UserPassword' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|image',
        ]);

        $user = User::findOrFail($id);
        $imageName = $user->image;
        if ($request->hasFile('image')) {
            if ($imageName && File::exists(public_path('/images/users/' . $imageName))) {
                File::delete(public_path('/images/users/' . $imageName));
            }

            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/images/users'), $imageName);
        }

        $userData = [
            'name' => $request->UserName,
            'email' => $request->UserEmail,
            'image' => $imageName,
        ];

        if ($request->filled('UserPassword')) {
            $userData['password'] = Hash::make($request->UserPassword);
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $this->authorize('manageUser', User::class);
        $user = User::findOrFail($id);
        $oldImage = $user->image;

        if ($oldImage) {
            $imagePath = public_path('/images/users/' . $oldImage);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $user->delete();

        return redirect()->route('users.index');
    }
}
