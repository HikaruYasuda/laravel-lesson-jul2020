<?php

namespace App\Observers;

use App\Models\Like;

class LikeObserver
{
    public function creating(Like $like)
    {
        // 更新前フックならfalseを返すことで更新を中止できる
//        if ($like->ip) {
//            return false;
//        }
    }

    /**
     * Handle the like "created" event.
     *
     * @param  \App\Models\Like  $like
     * @return void
     */
    public function created(Like $like)
    {
        // 別のデータ更新や通知など副作用を追加できる
//        $like->thing->description .= "\nいいねされた";
//        $like->thing->save();
    }

    /**
     * Handle the like "updated" event.
     *
     * @param  \App\Models\Like  $like
     * @return void
     */
    public function updated(Like $like)
    {
        //
    }

    /**
     * Handle the like "deleted" event.
     *
     * @param  \App\Models\Like  $like
     * @return void
     */
    public function deleted(Like $like)
    {
        //
    }
}
