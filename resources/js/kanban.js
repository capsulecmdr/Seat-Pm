document.addEventListener('DOMContentLoaded', () => {
    const draggableTasks = document.querySelectorAll('.kanban-task');
    const dropZones = document.querySelectorAll('.kanban-column');

    draggableTasks.forEach(task => {
        task.setAttribute('draggable', true);
        task.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', task.dataset.taskId);
        });
    });

    dropZones.forEach(column => {
        column.addEventListener('dragover', (e) => {
            e.preventDefault();
            column.classList.add('kanban-hover');
        });

        column.addEventListener('dragleave', () => {
            column.classList.remove('kanban-hover');
        });

        column.addEventListener('drop', (e) => {
            e.preventDefault();
            column.classList.remove('kanban-hover');

            const taskId = e.dataTransfer.getData('text/plain');
            const taskElement = document.querySelector(`.kanban-task[data-task-id="${taskId}"]`);
            const newStatus = column.dataset.status;

            if (taskElement && newStatus) {
                column.querySelector('.kanban-items').appendChild(taskElement);
                updateTaskStatus(taskId, newStatus);
            }
        });
    });
});

function updateTaskStatus(taskId, newStatus) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/seat-pm/tasks/${taskId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            console.log(`✅ Task ${taskId} successfully updated to ${newStatus}.`);
        } else {
            console.error('❌ Server returned failure:', data);
        }
    })
    .catch(error => {
        console.error('❌ Error updating task status:', error);
    });
}
