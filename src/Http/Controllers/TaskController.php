<?php

namespace CapsuleCmdr\SeATPM\Http\Controllers;

use CapsuleCmdr\SeATPM\Models\Project;
use CapsuleCmdr\SeATPM\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    /**
     * Store a new task under a project.
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'target_start_date' => ['nullable', 'date'],
            'target_completion_date' => ['nullable', 'date'],
            'budget_cost' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['Backlog', 'In Progress', 'Blocked', 'Complete'])],
            'percent_complete' => ['nullable', 'integer', 'between:0,100'],
        ]);

        $percent = match ($validated['status']) {
            'Complete' => 100,
            'Backlog' => 0,
            default => $validated['percent_complete'] ?? 0
        };

        $project->tasks()->create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'target_start_date' => $validated['target_start_date'],
            'target_completion_date' => $validated['target_completion_date'],
            'budget_cost' => $validated['budget_cost'],
            'status' => $validated['status'],
            'percent_complete' => $percent,
        ]);

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    /**
     * Update a task.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task->project);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'target_start_date' => ['nullable', 'date'],
            'target_completion_date' => ['nullable', 'date'],
            'budget_cost' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['Backlog', 'In Progress', 'Blocked', 'Complete'])],
            'percent_complete' => ['nullable', 'integer', 'between:0,100'],
        ]);

        $percent = match ($validated['status']) {
            'Complete' => 100,
            'Backlog' => 0,
            default => $validated['percent_complete'] ?? 0
        };

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'target_start_date' => $validated['target_start_date'],
            'target_completion_date' => $validated['target_completion_date'],
            'budget_cost' => $validated['budget_cost'],
            'status' => $validated['status'],
            'percent_complete' => $percent,
        ]);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    /**
     * Delete a task.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task->project);

        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

    /**
     * Update task status via AJAX (for Kanban).
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task->project);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['Backlog', 'In Progress', 'Blocked', 'Complete'])],
        ]);

        $task->status = $validated['status'];
        $task->percent_complete = match ($task->status) {
            'Complete' => 100,
            'Backlog' => 0,
            default => $task->percent_complete ?? 0
        };

        $task->save();

        return response()->json(['success' => true]);
    }
}
