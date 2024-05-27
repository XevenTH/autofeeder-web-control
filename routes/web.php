<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MqttController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'register'])
        ->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])
        ->name('register');
    Route::get('/', [AuthController::class, 'login'])
        ->name('login');
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])
        ->name('login');
    Route::get('/mqtt-subs', [MqttController::class, 'GetSubsMessage'])
        ->name('MqttView');
});

Route::group(['middleware' => 'auth'], function () {
    // Route::get('/home', [HomeController::class, 'index']);
    Route::delete('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Route users (admin)
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');
    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])
        ->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('users.update');
    Route::get('/users/{user}/delete', [UserController::class, 'destroy'])
        ->name('users.destroy');
    
    // Route device (admin)
    Route::get('/devices', [DeviceController::class, 'index'])
        ->name('devices.index');
    Route::get('/devices/create', [DeviceController::class, 'create'])
        ->name('devices.create');
    Route::post('/devices', [DeviceController::class, 'store'])
        ->name('devices.store');
    Route::get('/devices/{device}', [DeviceController::class, 'show'])
        ->name('devices.show');
    Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])
        ->name('devices.edit');
    Route::put('/devices/{device}', [DeviceController::class, 'update'])
        ->name('devices.update');
    Route::get('/devices/{device}/delete', [DeviceController::class, 'destroy'])
        ->name('devices.destroy');
    
});