<?php

namespace CapsuleCmdr\SeATPM;

use Illuminate\Support\Facades\Gate;
use CapsuleCmdr\SeATPM\Models\Project;
use CapsuleCmdr\SeATPM\Models\Task;
use CapsuleCmdr\SeATPM\Models\Comment;
use CapsuleCmdr\SeATPM\Policies\ProjectPolicy;
use CapsuleCmdr\SeATPM\Policies\TaskPolicy;
use CapsuleCmdr\SeATPM\Policies\CommentPolicy;
use Seat\Services\AbstractSeatPlugin;

class SeATPMServiceProvider extends AbstractSeatPlugin
{
    public function boot(): void
    {
        $this->addRoutes();
        $this->addViews();
        $this->addMigrations();

        // Register policies
        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);

        // Register menu
        if (function_exists('menu')) {
            menu()->register('SeAT-PM', [
                'name' => 'SeAT-PM',
                'route' => 'seatpm.projects.index',
                'icon'  => 'fas fa-project-diagram',
                'children' => [
                    ['name' => 'Alliance Projects', 'route' => 'seatpm.projects.index', 'params' => ['scope' => 'alliance']],
                    ['name' => 'Corporation Projects', 'route' => 'seatpm.projects.index', 'params' => ['scope' => 'corporation']],
                    ['name' => 'Personal Projects', 'route' => 'seatpm.projects.index', 'params' => ['scope' => 'personal']],
                ]
            ]);
        }

        // Register permissions
        if (function_exists('permission')) {
            permission()->register('seatpm.super', 'View all projects across visibility scopes');
            permission()->register('seatpm.projects.create', 'Create new projects');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/seatpm.php', 'seatpm');
        $this->mergeConfigFrom(__DIR__ . '/../config/package.sidebar.php', 'package.sidebar');
    }

    private function addRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    private function addViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'seatpm');
    }

    private function addMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function getName(): string
    {
        return 'SeAT-PM';
    }

    public function getPackagistVendorName(): string
    {
        return 'capsulecmdr';
    }

    public function getPackagistPackageName(): string
    {
        return 'seat-pm';
    }

    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/capsulecmdr/seat-pm';
    }
}
