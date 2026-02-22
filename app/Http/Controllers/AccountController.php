<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && auth()->user()->role === 'employee') {
            abort(403, 'Akses ditolak.');
        }
    }
    public function index()
    {
        $users = User::with('employee')->latest()->get();
        $unlinkedEmployees = Employee::doesntHave('user')->get();

        return view('accounts.index', compact('users', 'unlinkedEmployees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->employee_id) {
            $employee = Employee::find($request->employee_id);
            $employee->user_id = $user->id;
            $employee->save();
        }

        return redirect()->route('accounts.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function destroy(User $user)
    {
        // Unlink employee if exists
        if ($user->employee) {
            $employee = $user->employee;
            $employee->user_id = null;
            $employee->save();
        }

        $user->delete();

        return redirect()->route('accounts.index')->with('success', 'Akun berhasil dihapus.');
    }
}
