<?php

namespace App\Providers;

use App\Models\Like;
use App\Observers\LikeObserver;
use App\Repositories\LikeRepository;
use App\Repositories\Contracts\LikeRepository as LikeRepositoryContract;
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
        $this->app->singleton(LikeRepositoryContract::class, LikeRepository::class);
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
        Like::observe(LikeObserver::class);
    }
}
