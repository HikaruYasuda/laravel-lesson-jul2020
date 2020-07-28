<?php

namespace App\Providers;

use App\Repositories\ThingRepository;
use App\Repositories\Contracts\ThingRepository as ThingRepositoryContract;
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
        $this->app->singleton(ThingRepositoryContract::class, ThingRepository::class);
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
