<?php

namespace App\Repositories;

use App\Models\Thing;

/**
 * Class ThingRepository
 * @package App\Repositories
 */
class ThingRepository implements Contracts\ThingRepository
{
    public function getAll()
    {
        return Thing::all();
    }

    public function search(array $params)
    {
        $query = Thing::query();

        foreach (array_filter($params, 'filled') as $key => $value) {
            switch ($key) {
                case 'q':
                    // todo: %_のエスケープをする
                    $query->where(function ($q) use ($value) {
                        $q->where('name', 'like', '%'.$value.'%')
                            ->orWhere('description', 'like', '%'.$value.'%');
                    });
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
