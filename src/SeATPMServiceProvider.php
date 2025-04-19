<?php

namespace CapsuleCmdr\SeATPM;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use CapsuleCmdr\SeATPM\Models\Project;
use CapsuleCmdr\SeATPM\Models\Task;
use CapsuleCmdr\SeATPM\Models\Comment;
use CapsuleCmdr\SeATPM\Policies\ProjectPolicy;
use CapsuleCmdr\SeATPM\Policies\TaskPolicy;
use CapsuleCmdr\SeATPM\Policies\CommentPolicy;

class SeATPMServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap plugin services.
     */
    public function boot(): void
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/Providers/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'seatpm');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish config
        $this->publishes([
            __DIR__ . '/../config/seatpm.php' => config_path('seatpm.php'),
        ], 'seatpm');

        // Register policies
        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);

        // Register menu & permissions if SeAT menu system is available
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

    /**
     * Register bindings and configuration.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/seatpm.php',
            'seatpm'
        );
    }
}
