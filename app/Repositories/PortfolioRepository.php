<?php

namespace App\Repositories;

use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Class PortfolioRepository
 * @package App\Repositories
 */
class PortfolioRepository implements Contracts\PortfolioRepository
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
        $portfolios = collect();
        foreach ($filesystem->files() as $file) {
            if ($file === '.gitignore') {
                continue;
            }
            $contents = $filesystem->get($file);
            $portfolios[] = json_decode($contents, true);
        }
        return $portfolios;
    }

    public function create(array $data)
    {
        $json = collect($data)->only('name', 'memo')->toJson(JSON_UNESCAPED_UNICODE);

        $this->filesystem->put("{$data['name']}.txt", $json);
    }
}
