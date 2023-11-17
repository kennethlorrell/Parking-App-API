<?php

namespace App\Http\Resources;

use App\Services\ParkingPriceService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParkingResource extends JsonResource
{
    protected ParkingPriceService $parkingPriceService;

    public function __construct($resource)
    {
        $this->parkingPriceService = app()->make(ParkingPriceService::class);

        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        $totalPrice = $this->total_price ?? $this->parkingPriceService->calculateTotalPrice(
            $this->zone,
            $this->start_time,
            $this->stop_time
        );

        return [
            'id' => $this->id,
            'zone' => ZoneResource::make($this->whenLoaded('zone')),
            'vehicle' => VehicleResource::make($this->whenLoaded('vehicle')),
            'start_time' => $this->start_time->toDateTimeString(),
            'stop_time' => $this->stop_time?->toDateTimeString(),
            'total_price' => $totalPrice
        ];
    }
}
