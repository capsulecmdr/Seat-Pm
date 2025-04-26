<div class="row">
    @foreach(['Backlog', 'In Progress', 'Blocked', 'Complete'] as $status)
        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-center">
                    {{ $status }}
                </div>
                <div class="card-body kanban-column" data-status="{{ $status }}">
                    <div class="kanban-items">
                        @foreach($project->tasks->where('status', $status) as $task)
                            <div class="kanban-task card mb-2 p-2" data-task-id="{{ $task->id }}">
                                {{ $task->title }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
