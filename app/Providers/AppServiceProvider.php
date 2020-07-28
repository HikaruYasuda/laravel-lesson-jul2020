<?php

namespace App\Providers;

use App\Repositories\ThingRepository;
use App\Repositories\Contracts\ThingRepository as ThingRepositoryContract;
use Illuminate\Contracts\Filesystem\Filesystem;
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
        $this->app->singleton(ThingRepositoryContract::class, function () {
            return new ThingRepository($this->app->make(Filesystem::class), 10);
        });
        $this->app->alias(ThingRepositoryContract::class, 'things');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
