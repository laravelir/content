<?php

namespace Laravelir\Contentable\Providers;

use App\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravelir\Contentable\Console\Commands\InstallPackageCommand;
use Laravelir\Contentable\Facades\Contentable;

class ContentableServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . "/../../config/contentable.php", 'contentable');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->registerFacades();
    }

    public function boot(): void
    {

        $this->registerCommands();
    }

    private function registerFacades()
    {
        $this->app->bind('contentable', function ($app) {
            return new Contentable();
        });
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {

            $this->commands([
                InstallPackageCommand::class,
            ]);
        }
    }

    public function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../../config/contentable.php' => config_path('contentable.php')
        ], 'contentable-config');
    }

    protected function publishMigrations()
    {
        $timestamp = date('Y_m_d_His', time());
        $this->publishes([
            __DIR__ . '/../database/migrations/contentable_tables.stub.php' => database_path() . "/migrations/{$timestamp}_contentable_tables.php",
        ], 'contentable-migrations');
    }
}
