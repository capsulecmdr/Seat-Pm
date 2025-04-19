<?php

namespace CapsuleCmdr\SeATPM\Http\Controllers;

use CapsuleCmdr\SeATPM\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a list of projects filtered by visibility scope.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $scope = $request->get('scope', 'personal');

        $projects = match ($scope) {
            'alliance' => Project::where('visibility', 'alliance')
                ->whereHas('owner', fn($q) => $q->where('alliance_id', $user->alliance_id))
                ->get(),

            'corporation' => Project::where('visibility', 'corporation')
                ->whereHas('owner', fn($q) => $q->where('corporation_id', $user->corporation_id))
                ->get(),

            default => Project::where('visibility', 'personal')
                ->where('user_id', $user->id)
                ->get(),
        };

        return view('seatpm::projects.index', compact('projects', 'scope'));
    }

    /**
     * Show form to create a new project.
     */
    public function create()
    {
        $this->authorize('create', Project::class);

        return view('seatpm::projects.create');
    }

    /**
     * Store a new project in the database.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'visibility' => 'required|in:personal,corporation,alliance',
            'description' => 'nullable|string',
            'target_budget' => 'nullable|numeric|min:0',
            'target_completion_date' => 'nullable|date',
        ]);

        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'visibility' => $validated['visibility'],
            'description' => $validated['description'] ?? null,
            'target_budget' => $validated['target_budget'] ?? null,
            'target_completion_date' => $validated['target_completion_date'] ?? null,
        ]);

        return redirect()->route('seatpm.projects.show', $project)->with('success', 'Project created successfully.');
    }

    /**
     * Show a single project and its related data.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load(['tasks.comments.user', 'owner']);

        return view('seatpm::projects.show', compact('project'));
    }

    /**
     * Show form to edit an existing project.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('seatpm::projects.edit', compact('project'));
    }

    /**
     * Update the project.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'visibility' => 'required|in:personal,corporation,alliance',
            'description' => 'nullable|string',
            'target_budget' => 'nullable|numeric|min:0',
            'target_completion_date' => 'nullable|date',
        ]);

        $project->update($validated);

        return redirect()->route('seatpm.projects.show', $project)->with('success', 'Project updated successfully.');
    }

    /**
     * Delete the project and all its related tasks/comments.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('seatpm.projects.index')->with('success', 'Project deleted successfully.');
    }
}
