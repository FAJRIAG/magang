<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Employee;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;

class TaskController extends Controller
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
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('tasks.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Task Store Request Data:', $request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points' => 'required|integer|min:0',
            'employee_id' => 'nullable|exists:employees,id',
        ], [
            'title.required' => 'Judul tugas wajib diisi.',
            'title.string' => 'Judul tugas harus berupa teks.',
            'title.max' => 'Judul tugas maksimal 255 karakter.',
            'points.required' => 'Poin wajib diisi.',
            'points.integer' => 'Poin harus berupa angka.',
            'points.min' => 'Poin tidak boleh bernilai negatif.',
            'employee_id.exists' => 'Karyawan yang dipilih tidak valid.',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'points' => $request->points,
        ]);

        // If employee is selected, create task submission
        if ($request->employee_id) {
            TaskSubmission::create([
                'task_id' => $task->id,
                'employee_id' => $request->employee_id,
                'status' => 'assigned',
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points' => 'required|integer|min:0',
        ], [
            'title.required' => 'Judul tugas wajib diisi.',
            'title.string' => 'Judul tugas harus berupa teks.',
            'title.max' => 'Judul tugas maksimal 255 karakter.',
            'points.required' => 'Poin wajib diisi.',
            'points.integer' => 'Poin harus berupa angka.',
            'points.min' => 'Poin tidak boleh bernilai negatif.',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    // Show assignment form
    public function assign(Task $task)
    {
        $employees = Employee::all();
        return view('tasks.assign', compact('task', 'employees'));
    }

    // Store assignment
    public function storeAssignment(Request $request, Task $task)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ], [
            'employee_id.required' => 'Karyawan wajib dipilih.',
            'employee_id.exists' => 'Karyawan yang dipilih tidak valid.',
        ]);

        TaskSubmission::create([
            'task_id' => $task->id,
            'employee_id' => $request->employee_id,
            'status' => 'assigned',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task assigned successfully.');
    }
}
