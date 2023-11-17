<?php

namespace App\Traits;

use App\Scopes\UserRecordScope;

trait UserRecord
{
    public static function bootUserRecord(): void
    {
        static::addGlobalScope(new UserRecordScope);
    }
}
