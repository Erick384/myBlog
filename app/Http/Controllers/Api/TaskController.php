<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $tasks = Task::with(['assignedUser', 'creator'])->get();
        } else {
            $tasks = Task::with(['assignedUser', 'creator'])
                         ->where('assigned_to', $user->id)
                         ->get();
        }

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date|after:now',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(),
            'status' => Task::STATUS_PENDING,
        ]);

        $task->load(['assignedUser', 'creator']);

        // Send email notification
        $assignedUser = User::find($request->assigned_to);
        $assignedUser->notify(new TaskAssigned($task));

        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        $task->load(['assignedUser', 'creator']);
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $user = Auth::user();
        
        // Admin can update all fields, users can only update status
        if ($user->isAdmin()) {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'deadline' => 'required|date',
                'assigned_to' => 'required|exists:users,id',
                'status' => 'required|in:pending,in_progress,completed',
            ]);

            $task->update($request->all());
        } else {
            $request->validate([
                'status' => 'required|in:pending,in_progress,completed',
            ]);

            $task->update(['status' => $request->status]);
        }

        $task->load(['assignedUser', 'creator']);
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update(['status' => $request->status]);
        $task->load(['assignedUser', 'creator']);

        return response()->json($task);
    }
}
