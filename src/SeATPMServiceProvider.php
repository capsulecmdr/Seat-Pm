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
    /**
     * Bootstrap plugin services.
     */
    public function boot(): void
    {
        // load our routes, views & migrations
        $this->addRoutes();
        $this->addViews();
        $this->addMigrations();

        // register our policies
        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Task::class,    TaskPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);

    }

    /**
     * Register bindings and configuration.
     */
    public function register(): void
    {
        // merge in plugin config
        $this->mergeConfigFrom(__DIR__ . '/../config/seatpm.php',         'seatpm');

        $this->registerPermissions(__DIR__ . '/../config/Permissions/seatpm.php', 'seatpm');

        // merge in sidebar/menu config for SeAT
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

    // Metadata used by SeAT’s plugin registry:

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
