<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && auth()->user()->role === 'employee') {
            abort(403, 'Akses ditolak.');
        }
    }
    public function index()
    {
        $configurations = Configuration::all()->keyBy('key');
        return view('settings.index', compact('configurations'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method');

        foreach ($data as $key => $value) {
            Configuration::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
