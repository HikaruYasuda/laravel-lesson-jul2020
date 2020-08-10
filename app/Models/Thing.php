<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Thing
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $link
 * @property int $rating
 * @property array $extra
 */
class Thing extends Model
{
    protected $casts = [
        'extra' => 'json',
    ];
}
