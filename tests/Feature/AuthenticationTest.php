<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUserCanLoginWithCorrectCredentials()
    {
        $response = $this->postJson("{$this->apiPrefix}/login", [
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response->assertCreated();
    }

    public function testUserCannotLoginWithIncorrectCredentials()
    {
        $response = $this->postJson("{$this->apiPrefix}/login", [
            'email' => $this->user->email,
            'password' => 'wrong_password'
        ]);

        $response->assertUnprocessable();
    }

    public function testUserCanRegisterWithValidData()
    {
        $password = $this->faker->password();
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password
        ];

        $response = $this->postJson("{$this->apiPrefix}/register", $data);

        $response
            ->assertCreated()
            ->assertJsonStructure(['access_token']);;

        $this->assertDatabaseHas(
            'users',
            Arr::only($data, ['name', 'email'])
        );
    }

    public function testUserCannotRegisterWithInvalidData()
    {
        $password = $this->faker->password();
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password . '1'
        ];

        $response = $this->postJson("{$this->apiPrefix}/register", $data);

        $response->assertUnprocessable();

        $this->assertDatabaseMissing(
            'users',
            Arr::only($data, ['name', 'email'])
        );
    }
}
