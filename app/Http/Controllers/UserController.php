<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', ['users' => $users]);
    }
    public function create()
    {
        return view('user.create');
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'          => 'required|min:3|max:50',
            'email'         => 'required|unique:users,email|email:rfc,dns',
            'password'      => 'required|min:8|confirmed',
        ]);
        
        User::create([
            'name'      => $validateData['name'],
            'email'     => $validateData['email'],
            'password'  => Hash::make($validateData['password'])
        ]);

        return redirect()->route('users.index')->with('pesan', "Data {$validateData['name']} berhasil ditambahkan");
    }
    public function show(User $user)
    {
        return view('user.show', ['user' => $user]);
    }
    public function edit(User $user)
    {
        return view('user.edit', ['user' => $user]);
    }
    public function update(Request $request, User $user)
    {
        $validateData = $request->validate([
            'name'          => 'required|min:3|max:50',
        ]);
        $user->update($validateData);
        return redirect()->route('users.index', ['user' => $user->id])->with('pesan', "Data {$validateData['name']} berhasil diubah");
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('pesan', "Data $user->name berhasil berhasil dihapus");
    }
}
