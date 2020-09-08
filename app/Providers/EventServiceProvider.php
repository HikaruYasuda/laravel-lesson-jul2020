<?php

namespace App\Providers;

use App\Events\LikeCreated;
use App\Listeners\LoggingLikeCreated;
use App\Listeners\SendLikeNotification;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        QueryExecuted::class => [
            'App\\Listeners\\QueryLogTracker',
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LikeCreated::class => [
            SendLikeNotification::class,
            LoggingLikeCreated::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
