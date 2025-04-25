@extends('seatpm::layout')

@section('content')
<div class="container mt-4">
    <h2>Edit Project: {{ $project->title }}</h2>

    <form action="{{ route('seatpm.projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Project Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $project->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Project Description</label>
            <textarea name="description" id="description" rows="5" class="form-control">{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="visibility" class="form-label">Visibility</label>
            <select name="visibility" id="visibility" class="form-select">
                <option value="alliance" {{ old('visibility', $project->visibility) === 'alliance' ? 'selected' : '' }}>Alliance</option>
                <option value="corporation" {{ old('visibility', $project->visibility) === 'corporation' ? 'selected' : '' }}>Corporation</option>
                <option value="personal" {{ old('visibility', $project->visibility) === 'personal' ? 'selected' : '' }}>Personal</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="target_completion_date" class="form-label">Target Completion Date</label>
            <input type="date" name="target_completion_date" id="target_completion_date" class="form-control" value="{{ old('target_completion_date', $project->target_completion_date ? $project->target_completion_date->format('Y-m-d') : '') }}">
        </div>

        <div class="mb-3">
            <label for="target_budget" class="form-label">Target Budget (ISK)</label>
            <input type="number" step="0.01" name="target_budget" id="target_budget" class="form-control" value="{{ old('target_budget', $project->target_budget) }}">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('seatpm.projects.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>
@endsection
