<?php

namespace App\Events;

use App\Models\Like;

/**
 * Class LikeCreated
 * @package App\Events
 */
class LikeCreated
{
    /**
     * @var \App\Models\Like
     */
    public $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }
}
