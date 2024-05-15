<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    public function test_user_can_register_with_valid_details(): void
    {
        $userData = User::factory()->raw();

        $attributes = [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
        ];

        $this
            ->postJson(route('register'), $attributes)
            ->assertOk()
            ->assertJsonPath('message', 'Account created successfully.');

        $this->assertDatabaseHas(
            User::class,
            [
                'name' => $userData['name'],
                'email' => $userData['email'],
            ]
        );
    }

    public function test_user_cannot_register_without_name(): void
    {
        $userData = User::factory()->raw();

        $attributes = [
            'email' => $userData['email'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
        ];

        $this
            ->postJson(route('register'), $attributes)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name' => [
                    'Your name is required.',
                ],
            ]);
    }

    public function test_user_cannot_register_without_email(): void
    {
        $userData = User::factory()->raw();

        $attributes = [
            'name' => $userData['name'],
            'password' => $userData['password'],
            'password_confirmation' => $userData['password'],
        ];

        $this
            ->postJson(route('register'), $attributes)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'email' => [
                    'Your email is required.',
                ],
            ]);
    }

    public function test_user_cannot_register_with_weak_password(): void
    {
        $userData = User::factory()->raw();

        $attributes = [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this
            ->postJson(route('register'), $attributes)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'password' => [
                    'The password field must contain at least one uppercase and one lowercase letter.',
                    'The password field must contain at least one symbol.',
                    'The password field must contain at least one number.',
                ],
            ]);
    }

    public function test_user_cannot_register_without_confirming_password(): void
    {
        $userData = User::factory()->raw();

        $attributes = [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'],
        ];

        $this
            ->postJson(route('register'), $attributes)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'password' => [
                    'The password field confirmation does not match.',
                ],
            ]);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create(['password' => 'test']);

        $this
            ->postJson(route('login'), ['email' => $user->email, 'password' => 'password'])
            ->assertUnauthorized();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => 'test']);

        $this
            ->postJson(route('login'), ['email' => $user->email, 'password' => 'test'])
            ->assertOk();
    }
}
