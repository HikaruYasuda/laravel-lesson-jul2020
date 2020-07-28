<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;

/**
 * Class ThingFileRepository
 * @package App\Repositories
 */
class ThingFileRepository implements Contracts\ThingRepository
{
    public function getAll()
    {
        $things = collect();
        foreach (Storage::disk()->files() as $file) {
            if ($file === '.gitignore') {
                continue;
            }
            $contents = Storage::disk()->get($file);
            $things[] = json_decode($contents, true);
        }
        return $things;
    }

    public function search(array $params)
    {
        return $this->getAll();
    }

    public function create(array $data)
    {
        $json = collect($data)->only('name', 'memo')->toJson(JSON_UNESCAPED_UNICODE);

        Storage::disk()->put("{$data['name']}.txt", $json);
    }
}
