<?php

namespace CapsuleCmdr\SeATPM\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The namespace for plugin controllers.
     *
     * @var string
     */
    protected $namespace = 'CapsuleCmdr\SeATPM\Http\Controllers';

    /**
     * Register the plugin’s route group.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Map plugin routes.
     */
    public function map(): void
    {
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for SeAT-PM.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware(['web', 'auth'])
            ->prefix('seat-pm')
            ->as('seatpm.')
            ->namespace($this->namespace)
            ->group(base_path('plugins/seat-pm/routes/web.php'));
    }
}
