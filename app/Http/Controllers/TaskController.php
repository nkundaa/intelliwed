<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tasks = $user->tasks()->orderBy('status')->orderBy('priority', 'desc')->orderBy('due_date')->get();

        $grouped = $tasks->groupBy('category');
        $stats = [
            'total'     => $tasks->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
            'pending'   => $tasks->where('status', 'pending')->count(),
            'overdue'   => $tasks->filter(fn($t) => $t->isOverdue())->count(),
        ];

        return view('tasks.index', compact('tasks', 'grouped', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'due_date'    => 'nullable|date',
            'category'    => 'required|in:venue,catering,attire,photography,decor,music,invitations,transport,ceremony,other',
            'priority'    => 'required|in:low,medium,high',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['sort_order'] = Auth::user()->tasks()->max('sort_order') + 1;

        Task::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('tasks.index')->with('status', 'Task added successfully!');
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status'      => 'sometimes|in:pending,in_progress,completed',
            'due_date'    => 'nullable|date',
            'category'    => 'sometimes|in:venue,catering,attire,photography,decor,music,invitations,transport,ceremony,other',
            'priority'    => 'sometimes|in:low,medium,high',
        ]);

        $task->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'task' => $task->fresh()]);
        }

        return redirect()->route('tasks.index')->with('status', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('tasks.index')->with('status', 'Task removed.');
    }

    public function toggleStatus(Task $task)
    {
        $this->authorize('update', $task);

        $newStatus = $task->status === 'completed' ? 'pending' : 'completed';
        $task->update(['status' => $newStatus]);

        return response()->json(['success' => true, 'status' => $newStatus]);
    }
}
