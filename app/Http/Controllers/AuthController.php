<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Stevebauman\Location\Facades\Location;

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
    // dd($this->detectDevice(request()));
    $validateData = $request->validate([
      'email'         => 'required|exists:users',
      'password'      => 'required|min:8',
    ]);

    $credetials = [
      'email'     => $validateData['email'],
      'password'  => $validateData['password'],
    ];
    if (Auth::attempt($credetials)) {
      // return redirect('/users');
      // Log login activity
      activity('authentication')
            ->causedBy(Auth::user())
            ->withProperties([
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'login_method' => 'email_password',
                'device' => $this->detectDevice($request),
                'location' => $this->getLocationInfo($request),
                'timestamp' => now()->toDateTimeString()
            ])
            ->log('User successfully logged in');
      return redirect()->route('dashboard')->with('toast_success', 'Login berhasil');
    }

    activity('authentication')
            ->withProperties([
                'email' => $request->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'login_method' => 'email_password',
                'failure_reason' => 'Invalid credentials',
                'timestamp' => now()->toDateTimeString()
            ])
            ->log('Login attempt failed');

    return redirect()->route('login')->with('toast_error', 'Email atau Password salah');
  }

  public function forgotPassword()
  {
    return view('recovery');
  }

  public function forgotPasswordPost()
  {
    // return view('passreset');
    return redirect('/password-reset');
  }

  public function resetPassword()
  {
    return view('passreset');
  }

  public function resetPasswordPost(){
    // return view('login');
    return redirect('/');
  }

  // public function resetPasswordPost(){
  //   return view('login');
  // }

  public function logout()
  {
    // dd(request());
    sleep(1);
    activity('authentication')
        ->causedBy(Auth::user())
        ->withProperties([
            'user_id' => Auth::id(),
            'email' => Auth::user()->email,
            'name' => Auth::user()->name,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'logout_method' => 'manual',
            'device' => $this->detectDevice(request()),
            'location' => $this->getLocationInfo(request()),
            'session_duration' => $this->calculateSessionDuration(),
            'timestamp' => now()->toDateTimeString()
        ])
        ->log('User logged out');
    Auth::logout();
    return redirect()->route('login');
  }

  // Metode helper tambahan
  protected function detectDevice(Request $request)
  {
      $agent = new \Jenssegers\Agent\Agent();
      return [
          'platform' => $agent->platform(),
          'browser' => $agent->browser(),
          'device_type' => $agent->deviceType()
      ];
  }

  // protected function getLocationInfo(Request $request)
  // {
  //     try {
  //         // Gunakan service seperti ipapi atau maxmind
  //         $location = \Location::get($request->ip());
  //         return [
  //             'country' => $location->countryName,
  //             'city' => $location->cityName,
  //             'latitude' => $location->latitude,
  //             'longitude' => $location->longitude
  //         ];
  //     } catch (\Exception $e) {
  //         return null;
  //     }
  // }

  // Metode 3: API Eksternal (Lebih Akurat)
  protected function getLocationInfo(Request $request)
  {
      try {
          // $position = Location::get($request->ip());
          $position = Location::get();
          
          return $position ? [
              'country' => $position->countryName,
              'country_code' => $position->countryCode,
              'region' => $position->regionName,
              'city' => $position->cityName,
              'postal_code' => $position->postalCode,
              'latitude' => $position->latitude,
              'longitude' => $position->longitude,
              'timezone' => $position->timezone
          ] : null;
      } catch (\Exception $e) {
          return null;
      }
  }

  protected function calculateSessionDuration()
  {
      $loginTime = session('login_time');
      return now()->diffInSeconds($loginTime);
  }
}
