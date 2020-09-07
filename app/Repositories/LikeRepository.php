<?php

namespace App\Repositories;

use App\Models\Like;
use App\Models\Thing;
use App\Repositories\Contracts\LikeRepository as LikeRepositoryContract;

/**
 * Class LikeRepository
 * @package App\Repositories
 */
class LikeRepository implements LikeRepositoryContract
{
    public function store(Thing $thing, string $ip): Like
    {
        $like = Like::where('thing_id', '=', $thing->id)->where('ip', '=', $ip)->first();
        if ($like) {
            return $like;
        }

        $like = new Like();
        $like->thing_id = $thing->id;
        $like->ip = $ip;
        $like->save();

        // メールで通知 x

        return $like;
    }

    public function destroy(Thing $thing, string $ip): bool
    {
        /** @var Like $like */
        $like = Like::where('thing_id', '=', $thing->id)->where('ip', '=', $ip)->first();
        if ($like) {
            return $like->delete() ?? false;
        }
        return false;
    }
}
