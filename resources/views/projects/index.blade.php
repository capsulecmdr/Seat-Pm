@extends('seatpm::layout')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Projects — {{ ucfirst($scope) }} View</h2>
        <a href="{{ route('seatpm.projects.create') }}" class="btn btn-success">+ New Project</a>
    </div>

    @if ($projects->count() === 0)
        <div class="alert alert-info">
            No projects found in this scope.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Owner</th>
                        <th>Visibility</th>
                        <th>Progress</th>
                        <th>Target Completion</th>
                        <th>Budget</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>
                                <a href="{{ route('seatpm.projects.show', $project->id) }}">
                                    {{ $project->title }}
                                </a>
                            </td>
                            <td>{{ $project->owner->name }}</td>
                            <td>{{ ucfirst($project->visibility) }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ $project->percentComplete() }}%;" 
                                         aria-valuenow="{{ $project->percentComplete() }}" 
                                         aria-valuemin="0" aria-valuemax="100">
                                        {{ $project->percentComplete() }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($project->target_completion_date)
                                    {{ \Carbon\Carbon::parse($project->target_completion_date)->format('Y-m-d') }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if ($project->target_budget)
                                    {{ number_format($project->target_budget, 2) }} ISK
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('seatpm.projects.show', $project->id) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                                @can('update', $project)
                                    <a href="{{ route('seatpm.projects.edit', $project->id) }}" class="btn btn-sm btn-outline-warning">
                                        Edit
                                    </a>
                                @endcan
                                @can('delete', $project)
                                    <form action="{{ route('seatpm.projects.destroy', $project->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
