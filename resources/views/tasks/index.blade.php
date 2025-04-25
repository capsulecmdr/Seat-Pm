<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Task</th>
                <th>Status</th>
                <th>Progress</th>
                <th>Target Start</th>
                <th>Target End</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($project->tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->percent_complete }}%</td>
                    <td>{{ $task->target_start_date ?? 'N/A' }}</td>
                    <td>{{ $task->target_completion_date ?? 'N/A' }}</td>
                    <td>
                        @can('update', $project)
                            <form method="POST" action="{{ route('seatpm.tasks.destroy', $task->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No tasks found for this project.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
