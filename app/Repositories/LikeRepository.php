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
        return Like::firstOrCreate([
            'thing_id' => $thing->id,
            'ip' => $ip,
        ]);
    }

    public function destroy(Thing $thing, string $ip)
    {
        Like::where('thing_id', '=', $thing->id)
            ->where('ip', '=', $ip)
            ->delete();
    }
}
