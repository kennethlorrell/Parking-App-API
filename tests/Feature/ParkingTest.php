<?php

namespace Tests\Feature;

use App\Models\Parking;
use App\Models\Vehicle;
use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParkingTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanStartParkingTheirVehicle(): void
    {
        $vehicle = Vehicle::factory()->create([
            'user_id' => $this->user->id
        ]);
        $zone = Zone::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->postJson("{$this->apiPrefix}/parkings/start", [
                'vehicle_id' => $vehicle->id,
                'zone_id' => $zone->id
            ]);

        $response
            ->assertCreated()
            ->assertJsonStructure(['data'])
            ->assertJson([
                'data' => [
                    'start_time' => now()->toDateTimeString(),
                    'stop_time' => null,
                    'total_price' => 0
                ],
            ]);

        $this->assertDatabaseCount('parkings', 1);
    }

    public function testUserCanViewOngoingParkingWithCorrectPrice(): void
    {
        $vehicle = Vehicle::factory()->create([
            'user_id' => $this->user->id
        ]);
        $zone = Zone::factory()->create();

        $this
            ->actingAs($this->user)
            ->postJson("{$this->apiPrefix}/parkings/start", [
                'vehicle_id' => $vehicle->id,
                'zone_id' => $zone->id
            ]);

        $this->travel(2)->hours();

        $parking = Parking::first();

        $response = $this
            ->actingAs($this->user)
            ->getJson("{$this->apiPrefix}/parkings/{$parking->id}", [
                'vehicle_id' => $vehicle->id,
                'zone_id' => $zone->id
            ]);

        $response
            ->assertOk()
            ->assertJsonStructure(['data'])
            ->assertJson([
                'data' => [
                    'stop_time' => null,
                    'total_price' => $zone->hourly_rate * 2
                ],
            ]);
    }

    public function testUserCanStopParking(): void
    {
        $vehicle = Vehicle::factory()->create([
            'user_id' => $this->user->id
        ]);
        $zone = Zone::factory()->create();

        $this
            ->actingAs($this->user)
            ->postJson("{$this->apiPrefix}/parkings/start", [
                'vehicle_id' => $vehicle->id,
                'zone_id' => $zone->id
            ]);

        $this->travel(2)->hours();

        $parking = Parking::first();

        $response = $this
            ->actingAs($this->user)
            ->putJson("{$this->apiPrefix}/parkings/{$parking->id}");

        $parking->refresh();

        $response
            ->assertOk()
            ->assertJsonStructure(['data'])
            ->assertJson([
                'data' => [
                    'start_time' => $parking->start_time->toDateTimeString(),
                    'stop_time' => $parking->stop_time->toDateTimeString(),
                    'total_price' => $parking->total_price,
                ]
            ]);

        $this->assertDatabaseCount('parkings', 1);
    }
}
