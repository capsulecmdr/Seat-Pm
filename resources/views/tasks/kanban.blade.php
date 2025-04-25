<div class="row">
    @foreach (['Backlog', 'In Progress', 'Blocked', 'Complete'] as $status)
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header text-center">{{ $status }}</div>
                <div class="card-body" id="kanban-{{ strtolower(str_replace(' ', '-', $status)) }}">
                    @foreach ($project->tasks->where('status', $status) as $task)
                        <div class="card mb-2">
                            <div class="card-body p-2">
                                <strong>{{ $task->title }}</strong>
                                <div class="text-muted small">{{ $task->percent_complete }}%</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
