<?php

namespace App\Models;

use App\Traits\UserRecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, UserRecord;

    protected $fillable = ['user_id', 'plate_number'];
}
