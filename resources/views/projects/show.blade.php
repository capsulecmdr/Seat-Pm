@extends('seatpm::layout')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $project->title }}</h2>
        @can('update', $project)
            <a href="{{ route('seatpm.projects.edit', $project->id) }}" class="btn btn-outline-warning">Edit Project</a>
        @endcan
    </div>

    {{-- Project Info --}}
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Owner:</strong> {{ $project->owner->name }}</p>
            <p><strong>Visibility:</strong> {{ ucfirst($project->visibility) }}</p>
            <p><strong>Target Completion:</strong> {{ $project->target_completion_date ?? 'N/A' }}</p>
            <p><strong>Target Budget:</strong> {{ $project->target_budget ? number_format($project->target_budget, 2) . ' ISK' : 'N/A' }}</p>
            <p><strong>Description:</strong> {{ $project->description ?: 'No description provided.' }}</p>
        </div>
    </div>

    {{-- View Tabs --}}
    <ul class="nav nav-tabs mb-4" id="projectTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tasks-tab" data-bs-toggle="tab" href="#tasks" role="tab">📝 Tasks</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="gantt-tab" data-bs-toggle="tab" href="#gantt" role="tab">📆 Gantt Chart</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="kanban-tab" data-bs-toggle="tab" href="#kanban" role="tab">📋 Kanban Board</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="timeline-tab" data-bs-toggle="tab" href="#timeline" role="tab">📜 Activity</a>
        </li>
    </ul>

    <div class="tab-content" id="projectTabContent">

        {{-- Tasks View --}}
        <div class="tab-pane fade show active" id="tasks" role="tabpanel">
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    ➕ Add Task
                </button>
            </div>

            {{-- Add Task Modal --}}
            <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('seatpm.tasks.store', $project->id) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTaskModalLabel">➕ New Task</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="task-title" class="form-label">Title</label>
                                    <input type="text" name="title" id="task-title" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="task-description" class="form-label">Description</label>
                                    <textarea name="description" id="task-description" class="form-control" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="task-status" class="form-label">Status</label>
                                    <select name="status" id="task-status" class="form-select" required>
                                        <option value="Backlog">Backlog</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Blocked">Blocked</option>
                                        <option value="Complete">Complete</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="target-start" class="form-label">Target Start Date</label>
                                    <input type="date" name="target_start_date" id="target-start" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="target-completion" class="form-label">Target Completion Date</label>
                                    <input type="date" name="target_completion_date" id="target-completion" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="budget-cost" class="form-label">Budget Cost (ISK)</label>
                                    <input type="number" name="budget_cost" id="budget-cost" class="form-control" min="0" step="0.01">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Create Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Tasks Table --}}
            @if($project->tasks->isEmpty())
                <div class="alert alert-info">
                    No tasks have been created for this project yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Target Completion</th>
                                <th>Budget</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($task->status === 'Complete') bg-success
                                            @elseif($task->status === 'In Progress') bg-primary
                                            @elseif($task->status === 'Blocked') bg-danger
                                            @else bg-secondary
                                            @endif
                                        ">
                                            {{ $task->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div 
                                                class="progress-bar" 
                                                role="progressbar" 
                                                style="width: {{ $task->percent_complete ?? 0 }}%;" 
                                                aria-valuenow="{{ $task->percent_complete ?? 0 }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100"
                                            >
                                                {{ $task->percent_complete ?? 0 }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $task->target_completion_date ? \Illuminate\Support\Carbon::parse($task->target_completion_date)->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $task->budget_cost ? number_format($task->budget_cost, 2) . ' ISK' : 'N/A' }}</td>
                                    <td>
                                        {{-- Actions --}}
                                        <form method="POST" action="{{ route('seatpm.tasks.destroy', $task->id) }}" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this task?')">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Gantt Chart --}}
        <div class="tab-pane fade" id="gantt" role="tabpanel">
            <div id="gantt-target" data-tasks='@json($project->tasks)' class="mb-4"></div>
        </div>

        {{-- Kanban Board --}}
        <div class="tab-pane fade" id="kanban" role="tabpanel">
            @include('seatpm::tasks.kanban', ['project' => $project])
        </div>

        {{-- Activity Timeline --}}
        <div class="tab-pane fade" id="timeline" role="tabpanel">
            @include('seatpm::projects.timeline', ['project' => $project])
        </div>

    </div>
</div>

{{-- Scripts --}}
@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/frappe-gantt/dist/frappe-gantt.css">
<script src="https://unpkg.com/frappe-gantt/dist/frappe-gantt.min.js"></script>
<script src="{{ asset('vendor/seatpm/js/gantt.js') }}"></script>
<script src="{{ asset('vendor/seatpm/js/kanban.js') }}"></script>
@endpush

@endsection
