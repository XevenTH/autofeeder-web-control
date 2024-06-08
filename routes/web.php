<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MqttController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ScheduleController;

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
    Route::get('/dashboard', [HomeController::class, 'dashboard'])
    ->name('dashboard');

    Route::delete('/logout', [AuthController::class, 'logout'])
    ->name('logout');

    // Simple Users
    Route::get('/users', [UserController::class, 'simpleShow'])
    ->name('users.simple');
    Route::put('/users/{user}', [UserController::class, 'simpleUpdate'])
    ->name('users.simple.update');

    // Simple Devices
    Route::get('/devices', [DeviceController::class, 'simpleShow'])
    ->name('devices.simple');
    Route::post('/devices', [DeviceController::class, 'simpleStore'])
    ->name('devices.simple.store');
    Route::get('/devices/{device}/edit', [DeviceController::class, 'simpleEdit'])
    ->name('devices.simple.edit');
    Route::put('/devices/{device}', [DeviceController::class, 'simpleUpdate'])
    ->name('devices.simple.update');
    Route::delete('/devices/{device}/delete', [DeviceController::class, 'simpleDestroy'])
    ->name('devices.simple.destroy');

    // Simple Schedules
    Route::get('/schedules', [ScheduleController::class, 'simpleShow'])
    ->name('schedules.simple');
    Route::post('/schedules', [ScheduleController::class, 'simpleStore'])
    ->name('schedules.simple.store');
    Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'simpleEdit'])
    ->name('schedules.simple.edit');
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'simpleUpdate'])
    ->name('schedules.simple.update');
    Route::delete('/schedules/{schedule}/delete', [ScheduleController::class, 'simpleDestroy'])
    ->name('schedules.simple.destroy');

    Route::middleware(['isAdmin'])->group(function () {
        // Route users (admin)
        Route::get('/users/admin', [UserController::class, 'index'])
            ->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create');
        Route::post('/users/admin', [UserController::class, 'store'])
            ->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
            ->name('users.edit');
        Route::put('/users/admin/{user}', [UserController::class, 'update'])
            ->name('users.update');
        Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])
            ->name('users.destroy');
    
        // Route device (admin)
        Route::get('/devices/admin', [DeviceController::class, 'index'])
            ->name('devices.index');
        Route::get('/devices/create', [DeviceController::class, 'create'])
            ->name('devices.create');
        Route::post('/devices/admin', [DeviceController::class, 'store'])
            ->name('devices.store');
        Route::get('/devices/admin/{device}/edit', [DeviceController::class, 'edit'])
            ->name('devices.edit');
        Route::put('/devices/admin/{device}', [DeviceController::class, 'update'])
            ->name('devices.update');
        Route::delete('/devices/admin/{device}/delete', [DeviceController::class, 'destroy'])
            ->name('devices.destroy');
        
        // Route schedule (admin)
        Route::get('/schedules/admin', [ScheduleController::class, 'index'])
            ->name('schedules.index');
        Route::get('/schedules/create', [ScheduleController::class, 'create'])
            ->name('schedules.create');
        Route::post('/schedules/admin', [ScheduleController::class, 'store'])
            ->name('schedules.store');
        Route::get('/schedules/admin/{schedule}', [ScheduleController::class, 'show'])
            ->name('schedules.show');
        Route::get('/schedules/admin/{schedule}/edit', [ScheduleController::class, 'edit'])
            ->name('schedules.edit');
        Route::put('/schedules/admin/{schedule}', [ScheduleController::class, 'update'])
            ->name('schedules.update');
        Route::delete('/schedules/admin/{schedule}/delete', [ScheduleController::class, 'destroy'])
            ->name('schedules.destroy');
    });
    
});