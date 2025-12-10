<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    function dashboard(){
      $user = Auth::getUser();
      $inactive_schedules_count = DB::table('schedules')
                          ->leftJoin('devices', 'schedules.device_id', '=', 'devices.id')
                          ->select('schedules.*', 'devices.name', 'devices.user_id')
                          ->where('user_id', $user->id)
                          ->where('schedules.active', 0)
                          ->count();
      $active_schedules_count = DB::table('schedules')
                          ->leftJoin('devices', 'schedules.device_id', '=', 'devices.id')
                          ->select('schedules.*', 'devices.name', 'devices.user_id')
                          ->where('user_id', $user->id)
                          ->where('schedules.active', 1)
                          ->count();
      $active_schedules = DB::table('schedules')
                          ->leftJoin('devices', 'schedules.device_id', '=', 'devices.id')
                          ->select('schedules.*', 'devices.name', 'devices.user_id')
                          ->where('user_id', $user->id)
                          ->where('schedules.active', 1)
                          // ->get();
                          ->paginate(4);
      $devices = DB::table('devices')->where('user_id', $user->id)->get();

      return view('home.dashboard',  ['inactive_schedules_count' => $inactive_schedules_count, 'active_schedules_count' => $active_schedules_count, 'active_schedules' => $active_schedules,'devices' => $devices]);
    }
}
