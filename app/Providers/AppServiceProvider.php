<?php

namespace App\Providers;

use App\Services\BadgeUtils;
use App\Services\UpdateService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('UpdateService', function () {
            return new UpdateService();
        });

        $this->app->singleton('BadgeUtils', function () {
            return new BadgeUtils();
        });

        $this->app->singleton('filesystem', function ($app) {
            return $app->loadComponent('filesystems', 'Illuminate\Filesystem\FilesystemServiceProvider', 'filesystem');
        });
    }
}
