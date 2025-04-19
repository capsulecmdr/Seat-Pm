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
            <p><strong>Target Completion:</strong>
                {{ $project->target_completion_date ?? 'N/A' }}
            </p>
            <p><strong>Target Budget:</strong>
                {{ $project->target_budget ? number_format($project->target_budget, 2) . ' ISK' : 'N/A' }}
            </p>
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
            @include('seatpm::tasks.index', ['project' => $project])
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

{{-- Include Gantt + Kanban Scripts --}}
@push('scripts')
<script src="{{ asset('vendor/seatpm/js/gantt.js') }}"></script>
<script src="{{ asset('vendor/seatpm/js/kanban.js') }}"></script>
@endpush

@endsection
