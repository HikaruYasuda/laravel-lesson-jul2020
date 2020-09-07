<?php

namespace App\Listeners;

use App\Events\LikeCreated;
use Illuminate\Support\Facades\Event;

/**
 * Class LoggingLikeCreated
 * @package App\Listeners
 */
class LoggingLikeCreated
{
    public function handle($event)
    {
        if ($event instanceof LikeCreated) {
            logger()->info('いいねされた');
        }
//        elseif ($event instanceof LikeDestroyed) {
//            logger()->info('いいねが消された');
//        }
    }
}
