<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUserCanGetTheirProfileData(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get("{$this->apiPrefix}/profile");

        $response
            ->assertOk()
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonFragment(['name' => $this->user->name])
            ->assertJsonCount(2);
    }

    public function testUserCanChangeTheirNameAndEmail(): void
    {
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
        ];

        $response = $this
            ->actingAs($this->user)
            ->put("{$this->apiPrefix}/profile", $data);

        $response
            ->assertAccepted()
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonFragment(['name' => $data['name']])
            ->assertJsonCount(2);

        $this->assertDatabaseHas('users', $data);
    }

    public function testUserCanChangeTheirPassword(): void
    {
        $newPassword = $this->faker->password(minLength: 8);
        $data = [
            'current_password' => 'password',
            'new_password' => $newPassword,
            'new_password_confirmation' => $newPassword
        ];

        $response = $this
            ->actingAs($this->user)
            ->put("{$this->apiPrefix}/password", $data);

        $response->assertAccepted();
    }
}
