<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && auth()->user()->role === 'employee') {
            abort(403, 'Akses ditolak.');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = Device::latest()->get();
        return view('devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('devices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string|unique:devices,device_id',
            'location' => 'required|string',
        ]);

        Device::create([
            'device_id' => $request->device_id,
            'location' => $request->location,
            'secret_key' => bin2hex(random_bytes(32)), // Auto-generate 64-char hex secret
        ]);

        return redirect()->route('devices.index')->with('success', 'Device registered successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $request->validate([
            'location' => 'required|string',
            'regenerate_secret' => 'nullable|boolean',
        ]);

        $device->update([
            'location' => $request->location,
        ]);

        if ($request->regenerate_secret) {
            $device->update([
                'secret_key' => bin2hex(random_bytes(32)),
            ]);
        }

        return redirect()->route('devices.index')->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('success', 'Device deleted successfully.');
    }
}
