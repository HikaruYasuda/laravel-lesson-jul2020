<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Class ThingRepository
 * @package App\Repositories
 */
interface ThingRepository
{
    public function __construct(Filesystem $filesystem, $threshold);

    public function getAll(Filesystem $filesystem);

    public function create(array $data);
}
