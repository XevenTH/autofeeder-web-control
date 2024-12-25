<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Device;
use App\Models\Schedule;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ScheduleController extends Controller
{
    protected $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    function countServoSeconds($gram)
    {
        // Asumsi: 30 gram per 1 detik
        return (number_format(($gram / 30), 1) * 1000); 
    }
    
    public function index()
    {
        // $title = 'Hapus Data?';
        // $text = "Harap konfirmasi penghapusan data";
        // confirmDelete($title, $text);

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
            'grams_per_feeding' => 'required|integer|lte:1000|gte:30',
        ], [
            'device_id.required'    => 'Id Perangkat tidak boleh kosong.',
            'device_id.exists'      => 'Id Perangkat tidak ditemukan dalam database.',
            'time.required'         => 'Waktu tidak boleh kosong.',
            'grams_per_feeding.lte' => 'Tarakan per pakan maksimal 1000 gram.',
            'grams_per_feeding.gte' => 'Tarakan per pakan minimal 30 gram.',
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
            $days .= $request->days_sunday . ' ';
        }
        if ($days == '') {
            $days = '-';
        }
        
        // Menghitung detik servo terbuka
        $servo_seconds = $this->countServoSeconds($validateData['grams_per_feeding']);
        
        $schedule = new Schedule();
        $schedule->device_id = $validateData['device_id'];
        $schedule->active = isset($request->active) ? $request->active : 0;
        $schedule->days = $days;
        $schedule->time = $validateData['time'];
        $schedule->grams_per_feeding = $validateData['grams_per_feeding'];
        $schedule->servo_seconds = $servo_seconds;
        $schedule->save();
        
        try {
            // $client = new Client();
            $res = $this->client->request('POST', 'http://localhost:3000/api/refresh');
            
            if ($res->getStatusCode() == 200) {
                return redirect()->route('schedules.index')->with('toast_success', "Data jadwal berhasil ditambahkan");
            } else {
                return redirect()->route('schedules.index')->with('toast_error', "Gagal menyegarkan jadwal di server");
            }
        } catch (\Throwable $th) {
            return redirect()->route('schedules.index')->with('toast_error', "Gagal menyegarkan jadwal di server: " . $th->getMessage());
        }
        
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
            'grams_per_feeding' => 'required|integer|lte:1000|gte:30',
        ], [
            'device_id.required'    => 'Id Perangkat tidak boleh kosong.',
            'device_id.exists'      => 'Id Perangkat tidak ditemukan dalam database.',
            'time.required'         => 'Waktu tidak boleh kosong.',
            'grams_per_feeding.lte' => 'Tarakan per pakan maksimal 1000 gram.',
            'grams_per_feeding.gte' => 'Tarakan per pakan minimal 30 gram.',
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
            $days .= $request->days_sunday . ' ';
        }
        if ($days == '') {
            $days = '-';
        }
        
        // Menghitung detik servo terbuka
        $servo_seconds = $this->countServoSeconds($validateData['grams_per_feeding']);
        
        $schedule->update([
            'device_id' => $request->device_id,
            'active' => isset($request->active) ? $request->active : 0,
            'days' => $days,
            'time' => $request->time,
            'grams_per_feeding' => $request->grams_per_feeding,
            'servo_seconds' => $servo_seconds
        ]);

        try {
            // $client = new Client();
            $res = $this->client->request('POST', 'http://localhost:3000/api/refresh');
    
            if ($res->getStatusCode() == 200) {
                return redirect()->route('schedules.index', ['device' => $schedule->id])->with('toast_success', "Data jadwal berhasil diubah");
            } else {
                return redirect()->route('schedules.index', ['device' => $schedule->id])->with('toast_error', "Gagal menyegarkan jadwal di server");
            }
        } catch (\Throwable $th) {
            return redirect()->route('schedules.index', ['device' => $schedule->id])->with('toast_error', "Gagal menyegarkan jadwal di server: " . $th->getMessage());
        }
    }
    
    
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        try {
            // $client = new Client();
            $res = $this->client->request('POST', 'http://localhost:3000/api/refresh');
    
            if ($res->getStatusCode() == 200) {
                return redirect()->route('schedules.index')->with('toast_success', "Data jadwal berhasil dihapus");
            } else {
                return redirect()->route('schedules.index')->with('toast_error', "Gagal menyegarkan jadwal di server");
            }
        } catch (\Throwable $th) {
            return redirect()->route('schedules.index')->with('toast_error', "Gagal menyegarkan jadwal di server: " . $th->getMessage());
        }
    }
    
    
    public function simpleShow()
    {
        // $title = 'Hapus Data?';
        // $text = "Harap konfirmasi penghapusan data";
        // confirmDelete($title, $text);
        
        $user = Auth::getUser();
        $schedules = DB::table('schedules')
                            ->leftJoin('devices', 'schedules.device_id', '=', 'devices.id')
                            ->select('schedules.*', 'devices.name', 'devices.user_id')
                            ->where('user_id', $user->id)
                            ->get();
        $devices = Device::where('user_id', $user->id)->get();

        return view('schedule.simple',  ['schedules' => $schedules, 'devices' => $devices]);
    }
    
    
    public function simpleEdit(Schedule $schedule)
    {
        $user = Auth::getUser();
        $schedules = DB::table('schedules')
                            ->leftJoin('devices', 'schedules.device_id', '=', 'devices.id')
                            ->select('schedules.*', 'devices.name', 'devices.user_id')
                            ->where('user_id', $user->id)
                            ->get();
        $devices = Device::where('user_id', $user->id)->get();

        $schedule_joined = DB::table('schedules')
                            ->leftJoin('devices', 'schedules.device_id', '=', 'devices.id')
                            ->select('schedules.*', 'devices.name', 'devices.user_id')
                            ->where('schedules.id', $schedule->id)
                            ->get();
        
        // dump($schedule_joined); 
        // dump($schedule_joined[0]); 

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

        return view('schedule.simple',  ['schedule' => $schedule_joined[0], 'schedules' => $schedules, 'devices' => $devices, 'scheduled_days' => $scheduled_days]);
    }
    
    
    public function simpleStore(Request $request)
    {        
        $validateData = $request->validate([
            'device_id'         => 'required|exists:devices,id',
            'time'              => 'required',
            'grams_per_feeding' => 'required|integer|lte:1000|gte:30',
        ], [
            'device_id.required'    => 'Id Perangkat tidak boleh kosong.',
            'device_id.exists'      => 'Id Perangkat tidak ditemukan dalam database.',
            'time.required'         => 'Waktu tidak boleh kosong.',
            'grams_per_feeding.lte' => 'Tarakan per pakan maksimal 1000 gram.',
            'grams_per_feeding.gte' => 'Tarakan per pakan minimal 30 gram.',
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
            $days .= $request->days_sunday . ' ';
        }
        if ($days == '') {
            $days = '-';
        }
        
        // Menghitung detik servo terbuka
        $servo_seconds = $this->countServoSeconds($validateData['grams_per_feeding']);
        
        $schedule = new Schedule();
        $schedule->device_id = $validateData['device_id'];
        $schedule->active = isset($request->active) ? $request->active : 0;
        $schedule->days = $days;
        $schedule->time = $validateData['time'];
        $schedule->grams_per_feeding = $validateData['grams_per_feeding'];
        $schedule->servo_seconds = $servo_seconds;
        $schedule->save();

        // return redirect()->route('schedules.simple')->with('toast_success', "Data jadwal berhasil ditambahkan");
        try {
            // $client = new Client();
            $res = $this->client->request('POST', 'http://localhost:3000/api/refresh');
            
            if ($res->getStatusCode() == 200) {
                Log::info("Anjas benar hi"); // Log tambahan
                return redirect()->route('schedules.simple')->with('toast_success', "Data jadwal berhasil ditambahkan");
            } else {
                Log::info("Anjas salah"); // Log tambahan
                return redirect()->route('schedules.simple')->with('toast_error', "Gagal menyegarkan jadwal di server");
            }
        } catch (\Throwable $th) {
            Log::info("Entering catch block"); // Log tambahan
            // Log::error("Error: " . $th->getMessage());
            return redirect()->route('schedules.simple')->with('toast_error', "Gagal menyegarkan jadwal di server: " . $th->getMessage());
        }
      
    }
    
    
    public function simpleUpdate(Request $request, Schedule $schedule)
    {
        $validateData = $request->validate([
            'device_id'         => 'required|exists:devices,id',
            'time'              => 'required',
            'grams_per_feeding' => 'required|integer|lte:1000|gte:30',
        ], [
            'device_id.required'    => 'Id Perangkat tidak boleh kosong.',
            'device_id.exists'      => 'Id Perangkat tidak ditemukan dalam database.',
            'time.required'         => 'Waktu tidak boleh kosong.',
            'grams_per_feeding.lte' => 'Tarakan per pakan maksimal 1000 gram.',
            'grams_per_feeding.gte' => 'Tarakan per pakan minimal 30 gram.',
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
            $days .= $request->days_sunday . ' ';
        }
        if ($days == '') {
            $days = '-';
        }
        
        // Menghitung detik servo terbuka
        $servo_seconds = $this->countServoSeconds($validateData['grams_per_feeding']);
        
        $schedule->update([
            'device_id' => $request->device_id,
            'active' => isset($request->active) ? $request->active : 0,
            'days' => $days,
            'time' => $request->time,
            'grams_per_feeding' => $request->grams_per_feeding,
            'servo_seconds' => $servo_seconds
        ]);

        try {
            // $client = new Client();
            $res = $this->client->request('POST', 'http://localhost:3000/api/refresh');
    
            if ($res->getStatusCode() == 200) {
                return redirect()->route('schedules.simple', ['device' => $schedule->id])->with('toast_success', "Data jadwal berhasil diubah");
            } else {
                return redirect()->route('schedules.simple', ['device' => $schedule->id])->with('toast_error', "Gagal menyegarkan jadwal di server");
            }
        } catch (\Throwable $th) {
            return redirect()->route('schedules.simple', ['device' => $schedule->id])->with('toast_error', "Gagal menyegarkan jadwal di server: " . $th->getMessage());
        }        

    }
    
    
    public function simpleDestroy(Schedule $schedule)
    {
        $schedule->delete();
        try {
            // $client = new Client();
            $res = $this->client->request('POST', 'http://localhost:3000/api/refresh');
    
            if ($res->getStatusCode() == 200) {
                return redirect()->route('schedules.simple')->with('toast_success', "Data jadwal berhasil dihapus");
            } else {
                return redirect()->route('schedules.simple')->with('toast_error', "Gagal menyegarkan jadwal di server");
            }
        } catch (\Throwable $th) {
            return redirect()->route('schedules.simple')->with('toast_error', "Gagal menyegarkan jadwal di server: " . $th->getMessage());
        }
    }
}
