<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Device;
use App\Models\User;
use GuzzleHttp\Client;
use RealRashid\SweetAlert\Facades\Alert;

class DeviceController extends Controller
{
    public function index()
    {
        $title = 'Hapus Data?';
        $text = "Harap konfirmasi penghapusan data";
        confirmDelete($title, $text);
        
        $devices = Device::all();
        return view('device.index', ['devices' => $devices]);
    }
    public function create()
    {
        $users = User::all();
        return view('device.create', ['users' => $users]);
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'name'          => 'required|min:3|max:30',
            'topic'         => 'required|unique:devices,topic',
            'capacity'      => 'required|numeric|lte:12|gte:2',
        ]);
        
        Device::create($validateData);

        return redirect()->route('devices.index')->with('toast_success', "Data {$validateData['name']} berhasil ditambahkan");
    }
    public function edit(Device $device)
    {
        $users = User::all();
        return view('device.edit', ['device' => $device, 'users' => $users]);
    }
    public function update(Request $request, Device $device)
    {
        $validateData = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'name'          => 'required|min:3|max:30',
            'topic'         => 'required',
            'capacity'      => 'required|numeric|lte:12|gte:2',
        ]);

        $device->update($validateData);
        return redirect()->route('devices.index', ['device' => $device->id])->with('toast_success', "Data {$validateData['name']} berhasil diubah");
    }
    public function destroy(Device $device)
    {
        $device->delete();

        try {
            $client = new Client();
            $res = $client->request('POST', 'http://localhost:3000/api/refresh');
    
            if ($res->getStatusCode() == 200) {
                return redirect()->route('devices.index')->with('toast_success', "Data $device->name berhasil berhasil dihapus");
            } else {
                return redirect()->route('devices.index')->with('toast_error', "Gagal menyegarkan jadwal di server");
            }
        } catch (\Throwable $th) {
            return redirect()->route('devices.index')->with('toast_error', "Gagal menyegarkan jadwal di server: " . $th->getMessage());
        }

    }
    public function simpleShow()
    {
        $title = 'Hapus Data?';
        $text = "Harap konfirmasi penghapusan data";
        confirmDelete($title, $text);
        
        $user = Auth::getUser();
        $devices = Device::where('user_id', $user->id)->get();
        return view('device.simple', ['devices' => $devices]);
    }
    public function simpleEdit(Device $device)
    {
        $user = Auth::getUser();
        $devices = Device::where('user_id', $user->id)->get();
        return view('device.simple', ['device' => $device, 'devices' => $devices]);
    }
    public function simpleStore(Request $request)
    {
        $user = Auth::getUser();

        $validateData = $request->validate([
            'name'          => 'required|min:3|max:30',
            'topic'         => 'required|unique:devices,topic',
        ]);
        
        $device = new Device();
        $device->user_id = $user->id;
        $device->name = $validateData['name'];
        $device->topic = $validateData['topic'];
        $device->capacity = 12;
        $device->save();

        return redirect()->route('devices.simple')->with('toast_success', "Data {$validateData['name']} berhasil ditambahkan");        
    }
    public function simpleUpdate(Request $request, Device $device)
    {
        $user = Auth::getUser();

        $validateData = $request->validate([
            'name'          => 'required|min:3|max:30',
            'topic'         => 'required',
        ]);

        $device->update([
            'name'      => $validateData['name'],
            'topic'     => $validateData['topic'],
        ]);

        return redirect()->route('devices.simple')->with('toast_success', "Data {$validateData['name']} berhasil diperbarui");        
    }
    public function simpleDestroy(Device $device)
    {
        $device->delete();
        try {
            $client = new Client();
            $res = $client->request('POST', 'http://localhost:3000/api/refresh');
    
            if ($res->getStatusCode() == 200) {
                return redirect()->route('devices.simple')->with('toast_success', "Data $device->name berhasil berhasil dihapus");
            } else {
                return redirect()->route('devices.simple')->with('toast_error', "Gagal menyegarkan jadwal di server");
            }
        } catch (\Throwable $th) {
            return redirect()->route('devices.simple')->with('toast_error', "Gagal menyegarkan jadwal di server: " . $th->getMessage());
        }        

    }
}
