<?php

namespace App\Models;

use App\Traits\UserRecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory, UserRecord;

    protected $fillable = ['user_id', 'plate_number'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
