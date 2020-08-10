<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * Class ThingQbRepository
 * @package App\Repositories
 */
class ThingQbRepository implements Contracts\ThingRepository
{
    public function getAll()
    {
        return DB::table('things')->get();
    }

    public function search(array $params)
    {
        $query = DB::table('things');

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
        $values = collect($data)->only([
            'name',
            'description',
            'image',
            'link',
            'rating',
        ]);

        $id = DB::table('things')->insertGetId($values->all());

        return DB::table('things')->find($id);
    }
}
