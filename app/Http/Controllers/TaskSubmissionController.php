<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskSubmissionController extends Controller
{
    // Admin: List all pending submissions
    public function index()
    {
        if (auth()->check() && auth()->user()->role === 'employee')
            abort(403);
        $submissions = TaskSubmission::with(['task', 'employee'])
            ->where('status', 'pending_approval')
            ->latest()
            ->get();

        return view('submissions.index', compact('submissions'));
    }

    // Employee: List my assigned tasks
    public function availableTasks()
    {
        $user = Auth::user();
        if (!$user->employee) {
            return redirect()->route('dashboard')->with('error', 'No employee record linked.');
        }

        $myTasks = $user->employee->taskSubmissions()
            ->with('task')
            ->whereIn('status', ['assigned', 'pending_approval'])
            ->latest()
            ->get();

        return view('tasks.available', compact('myTasks'));
    }

    // Employee: Mark task as complete
    public function store(Request $request, TaskSubmission $submission)
    {
        $user = Auth::user();
        if (!$user->employee || $submission->employee_id !== $user->employee->id) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        if ($submission->status !== 'assigned') {
            return redirect()->back()->with('error', 'Task already submitted.');
        }

        $submission->update(['status' => 'pending_approval']);

        return redirect()->back()->with('success', 'Task marked as complete. Waiting for approval.');
    }

    // Admin: Approve submission
    public function approve(TaskSubmission $submission)
    {
        if (auth()->check() && auth()->user()->role === 'employee')
            abort(403);
        if ($submission->status !== 'pending_approval') {
            return redirect()->back()->with('error', 'Submission already processed.');
        }

        $submission->update(['status' => 'approved']);

        // Increment employee balance
        $submission->employee->increment('reward_balance', $submission->task->points);

        return redirect()->back()->with('success', 'Submission approved and points awarded.');
    }

    // Admin: Reject submission
    public function reject(TaskSubmission $submission)
    {
        if (auth()->check() && auth()->user()->role === 'employee')
            abort(403);
        if ($submission->status !== 'pending_approval') {
            return redirect()->back()->with('error', 'Submission already processed.');
        }

        $submission->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Submission rejected.');
    }
}
