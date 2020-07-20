<?php

namespace App\Repositories;

use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Class PortfolioRepository
 * @package App\Repositories
 */
class PortfolioRepository
{
    public function getAll()
    {
        $portfolios = collect();
        foreach (resolve(Filesystem::class)->files() as $file) {
            if ($file === '.gitignore') {
                continue;
            }
            $contents = resolve(Filesystem::class)->get($file);
            $portfolios[] = json_decode($contents, true);
        }
        return $portfolios;
    }

    public function create(array $data)
    {
        $json = collect($data)->only('name', 'memo')->toJson(JSON_UNESCAPED_UNICODE);

        resolve(Filesystem::class)->put("{$data['name']}.txt", $json);
    }
}
