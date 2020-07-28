<?php

namespace App\Repositories\Contracts;

/**
 * Class ThingRepository
 * @package App\Repositories
 */
interface ThingRepository
{
    public function getAll();

    public function search(array $params);

    public function create(array $data);
}
