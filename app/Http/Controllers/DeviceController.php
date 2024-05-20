<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\User;

class DeviceController extends Controller
{
    public function index()
    {
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
            'name'          => 'required|min:3|max:50',
            'topic'         => 'required|unique:devices,topic',
            'capacity'      => 'required',
        ]);
        
        Device::create($validateData);

        return redirect()->route('devices.index')->with('pesan', "Data {$validateData['name']} berhasil ditambahkan");
    }
    public function show(Device $device)
    {
        return view('device.show', ['device' => $device]);
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
            'name'          => 'required|min:3|max:50',
            'topic'         => 'required',
            'capacity'      => 'required',
        ]);

        $device->update($validateData);
        return redirect()->route('devices.index', ['device' => $device->id])->with('pesan', "Data {$validateData['name']} berhasil diubah");
    }
    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('pesan', "Data $device->name berhasil berhasil dihapus");
    }
}
