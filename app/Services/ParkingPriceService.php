<?php

namespace App\Services;

use App\Models\Zone;
use Carbon\Carbon;

class ParkingPriceService {
    public function calculateTotalPrice(Zone $zone, Carbon $startedAt, Carbon $stoppedAt = null): int
    {
        $totalTimeByMinutes = $startedAt->diffInMinutes($stoppedAt ?? now());

        $pricePerMinute = $zone->hourly_rate / 60;

        return ceil($totalTimeByMinutes * $pricePerMinute);
    }
}
