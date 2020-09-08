<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Thing;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ThingRepository
 * @package App\Repositories
 */
class ThingRepository implements Contracts\ThingRepository
{
    public function getAll()
    {
        return Thing::rating(20)->get();
    }

    public function search(array $params)
    {
        $query = Thing::rating(20);

        foreach (array_filter($params, 'filled') as $key => $value) {
            switch ($key) {
                case 'q':
                    $values = array_filter(preg_split('/[\s　]+/', $value), 'strlen');
                    foreach ($values as $val) {
                        if ($val === 'is:liked') {
                            $query->has('myLike');
                        } elseif (str_starts_with($val, 'tag:')) {
                            $tag = substr($val, 4);
                            $query->wherehas('tags', function(Builder $q) use ($tag) {
                                $q->where('name', '=', $tag);
                            });
                        } else {
                            // todo: %_のエスケープをする
                            $query->where(function ($q) use ($val) {
                                $q->where('name', 'like', '%'.$val.'%')
                                    ->orWhere('description', 'like', '%'.$val.'%');
                            });
                        }
                    }
                    // where (name like ? or description like ?)
                    break;
            }
        }

        return $query->get();
    }

    public function create(array $data)
    {
        $thing = new Thing;
        $thing->name = $data['name'] ?? null;
        $thing->description = $data['description'] ?? null;
        $thing->image = $data['image'] ?? null;
        $thing->link = $data['link'] ?? null;
        $thing->rating = $data['rating'] ?? null;
        $thing->extra = $this->collectExtras($data);

        $thing->save();

        $tags = Tag::find($data['tag_ids'] ?? []);
        $thing->tags()->sync($tags);

        return $thing;
    }

    public function update(Thing $thing, array $data)
    {
        $thing->name = $data['name'] ?? null;
        $thing->description = $data['description'] ?? null;
        $thing->image = $data['image'] ?? null;
        $thing->link = $data['link'] ?? null;
        $thing->rating = $data['rating'] ?? null;
        $thing->extra = $this->collectExtras($data);

        $tags = Tag::find($data['tag_ids'] ?? []);
        $thing->tags()->sync($tags);

        $thing->save();

        return $thing;
    }

    public function delete(Thing $thing)
    {
        return $thing->delete();
    }

    private function collectExtras($data)
    {
        $keys = $data['extra']['keys'] ?? [];
        $attrs = $data['extra']['attrs'] ?? [];

        $extras = [];

        foreach ($keys as $i => $key) {
            $attr = $attrs[$i] ?? null;
            if (filled($key) && filled($attr)) {
                $extras[$key] = $attr;
            }
        }

        return $extras;
    }
}
