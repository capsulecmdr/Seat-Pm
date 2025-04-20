<?php

namespace CapsuleCmdr\SeATPM;

use CapsuleCmdr\SeATPM\Models\Project;
use CapsuleCmdr\SeATPM\Models\Task;
use CapsuleCmdr\SeATPM\Models\Comment;
use CapsuleCmdr\SeATPM\Policies\ProjectPolicy;
use CapsuleCmdr\SeATPM\Policies\TaskPolicy;
use CapsuleCmdr\SeATPM\Policies\CommentPolicy;
use Illuminate\Support\Facades\Gate;
use Seat\Services\AbstractSeatPlugin;

class SeATPMServiceProvider extends AbstractSeatPlugin
{
    public function boot(): void
    {
        $this->addRoutes();
        $this->addViews();
        $this->addMigrations();
        $this->addPublications();

        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);

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

        if (function_exists('permission')) {
            permission()->register('seatpm.super', 'View all projects across visibility scopes');
            permission()->register('seatpm.projects.create', 'Create new projects');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/seatpm.php', 'seatpm');
    }

    private function addRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    private function addViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'seatpm');
    }

    private function addMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    private function addPublications()
    {
        $this->publishes([
            __DIR__ . '/../config/seatpm.php' => config_path('seatpm.php'),
        ], 'seatpm');
    }

    public function getName(): string
    {
        return 'Project Manager';
    }

    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/capsulecmdr/seat-pm';
    }

    public function getPackagistPackageName(): string
    {
        return 'seat-pm';
    }

    public function getPackagistVendorName(): string
    {
        return 'capsulecmdr';
    }
}
