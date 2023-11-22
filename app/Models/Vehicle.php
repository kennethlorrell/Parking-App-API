<?php

namespace App\Models;

use App\Traits\UserRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory,
        UserRecord,
        SoftDeletes;

    protected $fillable = [
        'user_id',
        'plate_number',
        'description'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parkings(): HasMany
    {
        return $this->hasMany(Parking::class);
    }

    public function activeParkings(): HasMany
    {
        return $this->parkings()->active();
    }

    public function hasActiveParkings(): bool
    {
        return $this->activeParkings()->exists();
    }
}
