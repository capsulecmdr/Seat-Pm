<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('seatpm.tasks.store', $project->id) }}">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Task Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="target_start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="target_start_date" name="target_start_date">
                    </div>

                    <div class="mb-3">
                        <label for="target_completion_date" class="form-label">Target Completion Date</label>
                        <input type="date" class="form-control" id="target_completion_date" name="target_completion_date">
                    </div>

                    <div class="mb-3">
                        <label for="budget_cost" class="form-label">Budget Cost (ISK)</label>
                        <input type="number" class="form-control" id="budget_cost" name="budget_cost" min="0" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Backlog">Backlog</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Blocked">Blocked</option>
                            <option value="Complete">Complete</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </div>

        </form>
    </div>
</div>
