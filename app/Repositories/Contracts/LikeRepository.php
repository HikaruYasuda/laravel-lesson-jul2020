<?php

namespace App\Repositories\Contracts;

use App\Models\Like;
use App\Models\Thing;

interface LikeRepository
{
    public function store(Thing $thing, string $ip): Like;

    public function destroy(Thing $thing, string $ip);
}
