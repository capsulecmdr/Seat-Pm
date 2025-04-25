{{-- resources/views/tasks/index.blade.php --}}

<div class="card">
    <div class="card-header">
        Tasks for {{ $project->title }}
    </div>
    <div class="card-body">
        @if ($project->tasks->isEmpty())
            <p>No tasks yet for this project.</p>
        @else
            <ul class="list-group">
                @foreach ($project->tasks as $task)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $task->title }}
                        <span class="badge bg-primary rounded-pill">{{ ucfirst($task->status) }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
