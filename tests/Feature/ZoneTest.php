<?php

namespace Tests\Feature;

use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ZoneTest extends TestCase
{
    use RefreshDatabase;

    public function testAllZonesAreAvailable()
    {
        $count = 10;
        $zones = Zone::factory()->count($count)->create();

        $response = $this->getJson("{$this->apiPrefix}/zones");

        $response->assertOk()
            ->assertJsonStructure(['data'])
            ->assertJsonStructure(['data' => [
                ['*' => 'id', 'name', 'hourly_rate'],
            ]])
            ->assertJsonPath('data.0.id', $zones->first()->id)
            ->assertJsonPath('data.0.name', $zones->first()->name)
            ->assertJsonPath('data.0.hourly_rate', $zones->first()->hourly_rate)
            ->assertJsonCount($count, 'data');
    }
}
