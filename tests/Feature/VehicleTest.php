<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetTheirVehicles()
    {
        $userVehicle = Vehicle::factory()->make();
        $this->user->vehicles()->save($userVehicle);

        $anotherUser = User::factory()->create();
        $anotherUserVehicle = $anotherUser->vehicles()->save(Vehicle::factory()->make());

        $response = $this
            ->actingAs($this->user)
            ->getJson("{$this->apiPrefix}/vehicles");

        $response
            ->assertOk()
            ->assertJsonStructure(['data'])
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.plate_number', $userVehicle->plate_number)
            ->assertJsonMissing($anotherUserVehicle->toArray());
    }


    public function testUserCanCreateVehicle()
    {
        $data = Vehicle::factory()->make()->toArray();

        $response = $this
            ->actingAs($this->user)
            ->postJson("{$this->apiPrefix}/vehicles", $data);

        $response->assertCreated()
            ->assertJsonStructure(['data'])
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'plate_number']
            ])
            ->assertJsonPath('data.plate_number', $data['plate_number']);

        $this->assertDatabaseHas('vehicles', [
            'plate_number' => $data['plate_number']
        ]);
    }

    public function testUserCanUpdateTheirVehicle()
    {
        $vehicle = Vehicle::factory()->create();
        $data = [
            'plate_number' => 'AA-12345'
        ];

        $response = $this
            ->actingAs($this->user)
            ->putJson("{$this->apiPrefix}/vehicles/{$vehicle->id}", $data);

        $response
            ->assertAccepted()
            ->assertJsonStructure(['plate_number'])
            ->assertJsonPath('plate_number', $data['plate_number']);

        $this->assertDatabaseHas('vehicles', $data);
    }

    public function testUserCanDeleteTheirVehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->deleteJson("{$this->apiPrefix}/vehicles/{$vehicle->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('vehicles', $vehicle->toArray());
    }
}
