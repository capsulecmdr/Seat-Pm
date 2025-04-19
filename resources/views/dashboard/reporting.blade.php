@extends('seatpm::layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📊 Project Reporting Dashboard</h2>

    @foreach($projects as $project)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>{{ $project->title }}</strong>
                <span class="float-end">{{ ucfirst($project->visibility) }} Scope</span>
            </div>
            <div class="card-body">

                <p><strong>Owner:</strong> {{ $project->owner->name }}</p>
                @if($project->target_budget)
                    <p><strong>Budget Target:</strong> {{ number_format($project->target_budget, 2) }} ISK</p>
                @endif
                @if($project->target_completion_date)
                    <p><strong>Target Completion:</strong> {{ \Carbon\Carbon::parse($project->target_completion_date)->format('Y-m-d') }}</p>
                @endif

                {{-- Progress --}}
                <div class="mb-3">
                    <strong>Overall Progress:</strong>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{ $project->percentComplete() }}%" 
                             aria-valuenow="{{ $project->percentComplete() }}" 
                             aria-valuemin="0" aria-valuemax="100">
                            {{ $project->percentComplete() }}%
                        </div>
                    </div>
                </div>

                {{-- Task Breakdown --}}
                <div class="row text-center">
                    <div class="col-md-3">
                        <span class="badge bg-secondary">{{ $project->tasks->where('status', 'Backlog')->count() }}</span><br>
                        Backlog
                    </div>
                    <div class="col-md-3">
                        <span class="badge bg-info text-dark">{{ $project->tasks->where('status', 'In Progress')->count() }}</span><br>
                        In Progress
                    </div>
                    <div class="col-md-3">
                        <span class="badge bg-warning text-dark">{{ $project->tasks->where('status', 'Blocked')->count() }}</span><br>
                        Blocked
                    </div>
                    <div class="col-md-3">
                        <span class="badge bg-success">{{ $project->tasks->where('status', 'Complete')->count() }}</span><br>
                        Complete
                    </div>
                </div>

                {{-- Budget Summary --}}
                @php
                    $taskBudget = $project->tasks->sum('budget_cost');
                    $remainingBudget = $project->target_budget ? $project->target_budget - $taskBudget : null;
                @endphp

                @if($project->target_budget)
                    <div class="mt-3">
                        <p><strong>Total Task Budget:</strong> {{ number_format($taskBudget, 2) }} ISK</p>
                        <p><strong>Remaining Budget:</strong> {{ number_format($remainingBudget, 2) }} ISK</p>
                    </div>
                @endif

                {{-- Upcoming Deadlines --}}
                <div class="mt-3">
                    <strong>Upcoming Deadlines:</strong>
                    <ul class="list-group list-group-flush">
                        @foreach($project->tasks->whereNotNull('target_completion_date')->sortBy('target_completion_date')->take(3) as $task)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $task->title }}
                                <span class="badge bg-light text-dark">
                                    {{ \Carbon\Carbon::parse($task->target_completion_date)->format('Y-m-d') }}
                                </span>
                            </li>
                        @endforeach
                        @if($project->tasks->whereNotNull('target_completion_date')->count() === 0)
                            <li class="list-group-item text-muted">No deadlines set.</li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    @endforeach
</div>
@endsection