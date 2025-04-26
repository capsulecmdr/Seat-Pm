@extends('seatpm::layout')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Task: {{ $task->title }}</h2>
        <a href="{{ route('seatpm.projects.show', $task->project_id) }}" class="btn btn-outline-secondary">
            ← Back to Project
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('seatpm.tasks.update', $task->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" required>{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="Backlog" {{ $task->status === 'Backlog' ? 'selected' : '' }}>Backlog</option>
                        <option value="In Progress" {{ $task->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Blocked" {{ $task->status === 'Blocked' ? 'selected' : '' }}>Blocked</option>
                        <option value="Complete" {{ $task->status === 'Complete' ? 'selected' : '' }}>Complete</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="percent_complete" class="form-label">Progress (%)</label>
                    <input type="number" name="percent_complete" id="percent_complete" value="{{ old('percent_complete', $task->percent_complete) }}" min="0" max="100" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="target_start_date" class="form-label">Target Start Date</label>
                    <input type="date" name="target_start_date" id="target_start_date" value="{{ old('target_start_date', optional($task->target_start_date)->format('Y-m-d')) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="target_completion_date" class="form-label">Target Completion Date</label>
                    <input type="date" name="target_completion_date" id="target_completion_date" value="{{ old('target_completion_date', optional($task->target_completion_date)->format('Y-m-d')) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="budget_cost" class="form-label">Budget Cost (ISK)</label>
                    <input type="number" name="budget_cost" id="budget_cost" value="{{ old('budget_cost', $task->budget_cost) }}" class="form-control" step="0.01">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">
                        💾 Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
