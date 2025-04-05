<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }
    
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
    
        $tasks = $query->latest()->paginate(10);
    
        return response()->json($tasks);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,completed',
        ]);

        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json($task, 201);
    }
    
    public function show(Task $task)
    {
        $user = Auth::user();

        if ($user->id !== $task->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($task);
    }
    
    public function update(Request $request, Task $task)
    {
        $user = Auth::user();

        if ($user->id !== $task->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,completed',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $data = $user->role === 'admin'
        ? $request->all()
        : $request->only(['title', 'description', 'status']);

        $task->update($data);

        return response()->json($task);
    }
    
    public function destroy(Task $task)
    {
        $user = Auth::user();

        if ($user->id !== $task->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task soft deleted successfully']);
    }

    // force delete 
    public function forceDelete($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $task->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->forceDelete();
        return response()->json(['message' => 'Task permanently deleted successfully']);
    }

    // view soft deleted tasks
    public function trashed()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $tasks = Task::onlyTrashed()->paginate(10);
        } else {
            $tasks = Task::onlyTrashed()->where('user_id', $user->id)->paginate(10);
        }

        return response()->json($tasks);
    }

    // restore soft deleted tasks
    public function restore($id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $task->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->restore();

        return response()->json([
            'message' => 'Task restored successfully!',
            'task' => $task
        ]);
    }
}