<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return view('schedule.index', ['schedules' => $schedules]);
    }
    public function create()
    {
        $devices = Device::all();
        return view('schedule.create', ['devices' => $devices]);
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'device_id'         => 'required|exists:devices,id',
            'time'              => 'required',
            'grams_per_feeding' => 'required',
        ]);

        $days = '';
        if (isset($request->days_monday)) {
            $days .= $request->days_monday . ' ';
        }
        if (isset($request->days_tuesday)) {
            $days .= $request->days_tuesday . ' ';
        }
        if (isset($request->days_wednesday)) {
            $days .= $request->days_wednesday . ' ';
        }
        if (isset($request->days_thursday)) {
            $days .= $request->days_thursday . ' ';
        }
        if (isset($request->days_friday)) {
            $days .= $request->days_friday . ' ';
        }
        if (isset($request->days_saturday)) {
            $days .= $request->days_saturday . ' ';
        }
        if (isset($request->days_sunday)) {
            $days .= $request->days_sunday;
        }
        if ($days == '') {
            $days = '-';
        }
        
        // Asumsi: 100 gram per 2 detik
        $servo_seconds = 2 * ($validateData['grams_per_feeding'] * 0.01);
        
        $schedule = new Schedule();
        $schedule->device_id = $validateData['device_id'];
        $schedule->active = isset($request->active) ? $request->active : 0;
        $schedule->days = $days;
        $schedule->time = $validateData['time'];
        $schedule->grams_per_feeding = $validateData['grams_per_feeding'];
        $schedule->servo_seconds = $servo_seconds;
        $schedule->save();

        return redirect()->route('schedules.index')->with('pesan', "Data jadwal berhasil ditambahkan");
    }
    public function show(Schedule $schedule)
    {
        return view('schedule.show', ['schedule' => $schedule]);
    }
    public function edit(Schedule $schedule)
    {
        $devices = Device::all();
        $days = explode(" ", $schedule->days);

        $scheduled_days = [];
        foreach($days as $day) {
            if ($day == "Monday") {
                $scheduled_days['monday'] = 1;
            } else if ($day == "Tuesday") {
                $scheduled_days['tuesday'] = 1;
            } else if ($day == "Wednesday") {
                $scheduled_days['wednesday'] = 1;
            } else if ($day == "Thursday") {
                $scheduled_days['thursday'] = 1;
            } else if ($day == "Friday") {
                $scheduled_days['friday'] = 1;
            } else if ($day == "Saturday") {
                $scheduled_days['saturday'] = 1;
            } else if ($day == "Sunday") {
                $scheduled_days['sunday'] = 1;
            }
        }

        
        return view('schedule.edit', ['schedule' => $schedule, 'devices' => $devices, 'scheduled_days' => $scheduled_days]);
    }
    public function update(Request $request, Schedule $schedule)
    {
        $validateData = $request->validate([
            'device_id'         => 'required|exists:devices,id',
            'time'              => 'required',
            'grams_per_feeding' => 'required',
        ]);

        $days = '';
        if (isset($request->days_monday)) {
            $days .= $request->days_monday . ' ';
        }
        if (isset($request->days_tuesday)) {
            $days .= $request->days_tuesday . ' ';
        }
        if (isset($request->days_wednesday)) {
            $days .= $request->days_wednesday . ' ';
        }
        if (isset($request->days_thursday)) {
            $days .= $request->days_thursday . ' ';
        }
        if (isset($request->days_friday)) {
            $days .= $request->days_friday . ' ';
        }
        if (isset($request->days_saturday)) {
            $days .= $request->days_saturday . ' ';
        }
        if (isset($request->days_sunday)) {
            $days .= $request->days_sunday;
        }
        if ($days == '') {
            $days = '-';
        }
        
        // Asumsi: 100 gram per 2 detik
        $servo_seconds = 2 * ($validateData['grams_per_feeding'] * 0.01);
        
        $schedule->update([
            'device_id' => $request->device_id,
            'active' => isset($request->active) ? $request->active : 0,
            'days' => $days,
            'time' => $request->time,
            'grams_per_feeding' => $request->grams_per_feeding,
            'servo_seconds' => $servo_seconds
        ]);
        // $schedule->update();

        // $schedule->update($validateData);
        return redirect()->route('schedules.index', ['device' => $schedule->id])->with('pesan', "Data jadwal berhasil diubah");
    }
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('pesan', "Data jadwal berhasil berhasil dihapus");
    }
}
