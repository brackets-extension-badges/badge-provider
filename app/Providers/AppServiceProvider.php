<?php

namespace App\Providers;

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
    }
}
