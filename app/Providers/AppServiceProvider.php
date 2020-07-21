<?php

namespace App\Providers;

use App\Repositories\PortfolioRepository;
use App\Repositories\Contracts\PortfolioRepository as PortfolioRepositoryContract;
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
        $this->app->singleton(PortfolioRepositoryContract::class, function () {
            return new PortfolioRepository($this->app->make(Filesystem::class), 10);
        });
        $this->app->alias(PortfolioRepositoryContract::class, 'portfolios');
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
