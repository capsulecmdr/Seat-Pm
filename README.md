# SeAT-PM — Project Management Plugin for SeAT

SeAT-PM is a feature-rich project management plugin for SeAT (Simple EVE API Tool). It enables users to create, manage, and track projects and tasks across personal, corporate, and alliance scopes — all within the familiar SeAT interface.

---

## 🌐 Key Features

- **Project Visibility Control**
  - Projects can be scoped to personal, corporation, or alliance visibility.
  - Visibility respected throughout SeAT's RBAC system.

- **Powerful Task Management**
  - Assign tasks to projects with:
    - Title, description, budget cost, status, percent complete
    - Target start and completion dates
  - Automated handling of completion percentages based on status.

- **Comment Threads**
  - Persistent threaded comments for every task.
  - Similar to Microsoft ADO work item discussions.

- **Project Views**
  - **Gantt Chart** — timeline view of all project tasks.
  - **Kanban Board** — drag-and-drop task status management.
  - **Task List View** — traditional table-style task tracking.
  - **Activity Timeline** — chronological log of task and project events.
  - **Reporting Dashboard** — real-time project metrics and budget overview.

- **Discord Integration**
  - Sends Discord webhook notifications on:
    - Project creation, edit, deletion
    - Task lifecycle events
    - Comment activity

- **Granular Permissions**
  - RBAC control for:
    - Viewing, creating, editing, deleting projects
    - Managing tasks and comments
    - Superuser override for viewing all projects
    - Settings configuration access

---

## ⚙️ Installation

1. **Upload the plugin:**
   Extract the plugin into your SeAT installation under `/plugins/seat-pm`.

2. **Run migrations:**
   ```bash
   docker-compose exec seat php artisan migrate
