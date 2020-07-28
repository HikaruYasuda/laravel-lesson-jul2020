<?php

namespace App\Repositories;

use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Class ThingRepository
 * @package App\Repositories
 */
class ThingRepository implements Contracts\ThingRepository
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    private $filesystem;
    private $threshold;

    public function __construct(Filesystem $filesystem, $threshold)
    {
        $this->filesystem = $filesystem;
        $this->threshold = $threshold;
    }

    public function getAll(Filesystem $filesystem)
    {
        $things = collect();
        foreach ($filesystem->files() as $file) {
            if ($file === '.gitignore') {
                continue;
            }
            $contents = $filesystem->get($file);
            $things[] = json_decode($contents, true);
        }
        return $things;
    }

    public function create(array $data)
    {
        $json = collect($data)->only('name', 'memo')->toJson(JSON_UNESCAPED_UNICODE);

        $this->filesystem->put("{$data['name']}.txt", $json);
    }
}
