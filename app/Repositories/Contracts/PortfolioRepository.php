<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Class PortfolioRepository
 * @package App\Repositories
 */
interface PortfolioRepository
{
    public function __construct(Filesystem $filesystem, $threshold);

    public function getAll(Filesystem $filesystem);

    public function create(array $data);
}
