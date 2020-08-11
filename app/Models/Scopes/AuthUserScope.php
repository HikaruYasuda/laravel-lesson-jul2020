<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class AuthUserScope
 * @package App\Models\Scopes
 */
class AuthUserScope implements Scope
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
//        $builder->where('user_id', '=', $this->user->id);
    }
}
