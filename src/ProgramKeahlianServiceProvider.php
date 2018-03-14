<?php

namespace Bantenprov\ProgramKeahlian;

use Illuminate\Support\ServiceProvider;
use Bantenprov\ProgramKeahlian\Console\Commands\ProgramKeahlianCommand;

/**
 * The ProgramKeahlianServiceProvider class
 *
 * @package Bantenprov\ProgramKeahlian
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProgramKeahlianServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->routeHandle();
        $this->configHandle();
        $this->langHandle();
        $this->viewHandle();
        $this->assetHandle();
        $this->migrationHandle();
        $this->publicHandle();
        $this->seedHandle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('program-keahlian', function ($app) {
            return new ProgramKeahlian;
        });

        $this->app->singleton('command.program-keahlian', function ($app) {
            return new ProgramKeahlianCommand;
        });

        $this->commands('command.program-keahlian');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'program-keahlian',
            'command.program-keahlian',
        ];
    }

    /**
     * Loading and publishing package's config
     *
     * @return void
     */
    protected function configHandle()
    {
        $packageConfigPath = __DIR__.'/config/config.php';
        $appConfigPath     = config_path('program-keahlian.php');

        $this->mergeConfigFrom($packageConfigPath, 'program-keahlian');

        $this->publishes([
            $packageConfigPath => $appConfigPath,
        ], 'program-keahlian-config');
    }

    /**
     * Loading package routes
     *
     * @return void
     */
    protected function routeHandle()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function langHandle()
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'program-keahlian');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/program-keahlian'),
        ], 'program-keahlian-lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle()
    {
        $packageViewsPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'program-keahlian');

        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/program-keahlian'),
        ], 'program-keahlian-views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle()
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => resource_path('assets'),
        ], 'program-keahlian-assets');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle()
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], 'program-keahlian-migrations');
    }

    public function publicHandle()
    {
        $packagePublicPath = __DIR__.'/public';

        $this->publishes([
            $packagePublicPath => base_path('public')
        ], 'program-keahlian-public');
    }

    public function seedHandle()
    {
        $packageSeedPath = __DIR__.'/database/seeds';

        $this->publishes([
            $packageSeedPath => base_path('database/seeds')
        ], 'program-keahlian-seeds');
    }
}
