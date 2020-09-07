<?php

namespace App\Listeners;

use App\Events\LikeCreated;

/**
 * Class SendLikeNotification
 * @package App\Listeners
 */
class SendLikeNotification
{
    public function handle(LikeCreated $event)
    {
        logger()->info(
            "Like added. thing:{$event->like->thing->name}({$event->like->thing_id}) ip:{$event->like->ip}"
        );
    }
}
