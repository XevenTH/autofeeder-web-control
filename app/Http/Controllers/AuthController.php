<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
<<<<<<< HEAD
use App\Services\MqttService;

class AuthController extends Controller
{
  protected $mqttService;

  public function registerPost(Request $request, MqttService $mqttService)
  {
    $this->mqttService = $mqttService;
=======
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
  public function register()
  {
    return view('register');
  }
  public function registerPost(Request $request)
  {
    $validateData = $request->validate([
      'name'          => 'required|min:3|max:50',
      'email'         => 'required|unique:users,email|email:rfc,dns',
      'phone'         => 'required',
      'password'      => 'required|min:8|confirmed',
    ]);
>>>>>>> 246168af41b5d59b834488cd219e0b1b99750485

    $user = new User();
    $user->name = $validateData['name'];
    $user->email = $validateData['email'];
    $user->phone = $validateData['phone'];
    $user->password = Hash::make($validateData['password']);
    $user->save();
    
    return redirect()->route('login')->with('toast_success', 'Akun berhasil didaftarkan. Silahkan login!');
  }

  public function login()
  {
    return view('login');
  }

  public function loginPost(Request $request)
  {
    $credetials = [
      'email' => $request->email,
      'password' => $request->password,
    ];
    if (Auth::attempt($credetials)) {
      return redirect('/users');
      // return redirect('/users')->with('toast_success', 'Login berhasil');
    }
    return back()->with('toast_success', 'Email atau Password salah');
  }

  public function logout()
  {
    $this->mqttService->PublishSinyalToClose();
    sleep(1);
    Auth::logout();
    return redirect()->route('login');
  }
}
