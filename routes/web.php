<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MqttController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ScheduleController;

Route::get('/', function () {
    return view('welcome');
});

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
    Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])
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
    Route::delete('/devices/{device}/delete', [DeviceController::class, 'destroy'])
        ->name('devices.destroy');
    
    // Route schedule (admin)
    Route::get('/schedules', [ScheduleController::class, 'index'])
        ->name('schedules.index');
    Route::get('/schedules/create', [ScheduleController::class, 'create'])
        ->name('schedules.create');
    Route::post('/schedules', [ScheduleController::class, 'store'])
        ->name('schedules.store');
    Route::get('/schedules/{schedule}', [ScheduleController::class, 'show'])
        ->name('schedules.show');
    Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])
        ->name('schedules.edit');
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])
        ->name('schedules.update');
    Route::delete('/schedules/{schedule}/delete', [ScheduleController::class, 'destroy'])
        ->name('schedules.destroy');
    
});