<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\User;
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
            'name'          => 'required|min:3|max:50',
            'topic'         => 'required|unique:devices,topic',
            'capacity'      => 'required|integer',
        ]);
        
        Device::create($validateData);

        return redirect()->route('devices.index')->with('toast_success', "Data {$validateData['name']} berhasil ditambahkan");
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
            'capacity'      => 'required|integer',
        ]);

        $device->update($validateData);
        return redirect()->route('devices.index', ['device' => $device->id])->with('toast_success', "Data {$validateData['name']} berhasil diubah");
    }
    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('toast_success', "Data $device->name berhasil berhasil dihapus");
    }
}
