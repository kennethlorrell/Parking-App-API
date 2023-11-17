<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserRecordScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('user_id', auth()->id());
    }
}
