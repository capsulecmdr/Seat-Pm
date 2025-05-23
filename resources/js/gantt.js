document.addEventListener('DOMContentLoaded', () => {
    const ganttElement = document.getElementById('gantt-target');

    if (!ganttElement) return;

    const tasks = JSON.parse(ganttElement.dataset.tasks);

    if (!Array.isArray(tasks)) {
        console.error('Invalid Gantt tasks data:', tasks);
        return;
    }

    const formattedTasks = tasks.map(task => ({
        id: task.id,
        name: task.title,
        start: task.target_start_date || new Date().toISOString().slice(0, 10),
        end: task.target_completion_date || new Date().toISOString().slice(0, 10),
        progress: task.percent_complete || 0,
        custom_class: getStatusClass(task.status),
    }));

    new Gantt('#gantt-target', formattedTasks, {
        view_mode: 'Week',
        date_format: 'YYYY-MM-DD',
        custom_popup_html: null,
    });
});

function getStatusClass(status) {
    switch (status) {
        case 'In Progress': return 'bar-in-progress';
        case 'Blocked': return 'bar-blocked';
        case 'Complete': return 'bar-complete';
        default: return 'bar-backlog';
    }
}
