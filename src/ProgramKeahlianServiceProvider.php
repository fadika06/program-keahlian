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
        $this->publishHandle();
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
    protected function configHandle($publish = '')
    {
        $packageConfigPath = __DIR__.'/config';
        $appConfigPath     = config_path('bantenprov/program-keahlian');

        $this->mergeConfigFrom($packageConfigPath.'/program-keahlian.php', 'program-keahlian');

        $this->publishes([
            $packageConfigPath.'/program-keahlian.php' => $appConfigPath.'/program-keahlian.php',
        ], $publish ? $publish : 'program-keahlian-config');
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
    protected function langHandle($publish = '')
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'program-keahlian');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/program-keahlian'),
        ], $publish ? $publish : 'program-keahlian-lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle($publish = '')
    {
        $packageViewsPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'program-keahlian');

        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/program-keahlian'),
        ], $publish ? $publish : 'program-keahlian-views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle($publish = '')
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => resource_path('assets'),
        ], $publish ? $publish : 'program-keahlian-assets');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle($publish = '')
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], $publish ? $publish : 'program-keahlian-migrations');
    }

    /**
     * Publishing package's publics (JavaScript, CSS, images...)
     *
     * @return void
     */
    public function publicHandle($publish = '')
    {
        $packagePublicPath = __DIR__.'/public';

        $this->publishes([
            $packagePublicPath => base_path('public')
        ], $publish ? $publish : 'program-keahlian-public');
    }

    /**
     * Publishing package's seeds
     *
     * @return void
     */
    public function seedHandle($publish = '')
    {
        $packageSeedPath = __DIR__.'/database/seeds';

        $this->publishes([
            $packageSeedPath => base_path('database/seeds')
        ], $publish ? $publish : 'program-keahlian-seeds');
    }

    /**
     * Publishing package's all files
     *
     * @return void
     */
    public function publishHandle()
    {
        $publish = 'program-keahlian-publish';

        $this->routeHandle($publish);
        $this->configHandle($publish);
        $this->langHandle($publish);
        $this->viewHandle($publish);
        $this->assetHandle($publish);
        // $this->migrationHandle($publish);
        $this->publicHandle($publish);
        $this->seedHandle($publish);
    }
}
