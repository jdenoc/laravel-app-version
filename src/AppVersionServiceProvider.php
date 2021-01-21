<?php

namespace Jdenoc\LaravelAppVersion;

use Illuminate\Support\ServiceProvider;

class AppVersionServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     */
    public function boot(){
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('version.php'),
            ], 'laravel-app-version');

            // Registering package commands.
             $this->commands([
                 AppVersion::class
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(){
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'app');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-app-version', function () {
            return new AppVersion;
        });
    }
}
