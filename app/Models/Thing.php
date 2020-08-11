<?php

namespace App\Models;

use App\Models\Scopes\AuthUserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Thing
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property-read string $name_kana 全角カタカナを全角ひらがなに変換した`name`
 * @property string $description
 * @property string $image
 * @property string $link
 * @property int $rating
 * @property array $extra
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static static|Builder rating(int $min) 評価30以上に限定するスコープ
 */
class Thing extends Model
{
    protected $casts = [
        'extra' => 'json',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AuthUserScope(auth()->user()));
    }

    /** [scope] {@see \App\Models\Thing::rating()} */
    public function scopeRating($query, int $min = 30)
    {
        return $query->where('rating', '>=', $min);
    }

    /** [mutator] {@see \App\Models\Thing::$rating} */
    public function setRatingAttribute($value)
    {
        $this->attributes['rating'] = is_null($value) ? null : $value * 10;
    }

    /** [accessor] {@see \App\Models\Thing::$rating} */
    public function getRatingAttribute($value)
    {
        return is_null($value) ? null : $value * 0.1;
    }

    /** [accessor] {@see \App\Models\Thing::$name_kana} */
    public function getNameKanaAttribute()
    {
        return mb_convert_kana($this->name, 'c');
    }
}
