<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {        
        // dump(Auth::getSession());
        $title = 'Hapus Data?';
        $text = "Harap konfirmasi penghapusan data";
        confirmDelete($title, $text);

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
            'phone'         => 'required',
            'password'      => 'required|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $validateData['name'];
        $user->email = $validateData['email'];
        $user->phone = $validateData['phone'];
        $user->password = Hash::make($validateData['password']);
        $user->save();
                
        return redirect()->route('users.index')->with('toast_success', "Data {$validateData['name']} berhasil ditambahkan");
    }
    public function edit(User $user)
    {
        return view('user.edit', ['user' => $user]);
    }
    public function update(Request $request, User $user)
    {
        $validateData = $request->validate([
            'name'          => 'required|min:3|max:50',
            'email'         => [
                'required',
                Rule::unique('users', 'email')->ignore($request->id),
                'email:rfc,dns'
            ],
            'phone'         => 'required',
            'newpassword'   => 'exclude_without:newpassword_confirmation|min:8|confirmed',
        ]);

        if ($request->newpassword != '') {
            $user->update([
                'name'      => $validateData['name'],
                'email'     => $validateData['email'],
                'phone'     => $validateData['phone'],
                'password'  => Hash::make($request->newpassword),
            ]);
        } else {
            $user->update([
                'name'      => $validateData['name'],
                'email'     => $validateData['email'],
                'phone'     => $validateData['phone'],
            ]);
        }
        
        return redirect()->route('users.index', ['user' => $user->id])->with('toast_success', "Data {$validateData['name']} berhasil diubah");
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('toast_success', "Data $user->name berhasil berhasil dihapus");
    }
    public function simpleShow()
    {
        $user = Auth::getUser();
        return view('user.simple', ['user' => $user]);
    }
    public function simpleUpdate(Request $request, User $user)
    {
        $validateData = $request->validate([
            'name'          => 'required|min:3|max:50',
            'email'         => [
                'required',
                Rule::unique('users', 'email')->ignore($request->id),
                'email:rfc,dns'
            ],
            'phone'         => 'required',
            'newpassword'   => 'exclude_without:newpassword_confirmation|min:8|confirmed',
        ]);

        if ($request->newpassword != '') {
            $user->update([
                'name'      => $validateData['name'],
                'email'     => $validateData['email'],
                'phone'     => $validateData['phone'],
                'password'  => Hash::make($request->newpassword),
            ]);
        } else {
            $user->update([
                'name'      => $validateData['name'],
                'email'     => $validateData['email'],
                'phone'     => $validateData['phone'],
            ]);
        }
        
        return redirect()->route('users.simple')->with('toast_success', "Data Profilmu berhasil diperbarui");
    }
}
