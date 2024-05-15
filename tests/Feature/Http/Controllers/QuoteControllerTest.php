<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['password' => 'password']);
    }

    public function test_guest_cannot_index_quotes(): void
    {
        $this
            ->getJson(route('quotes.index'))
            ->assertUnauthorized();
    }

    public function test_user_can_index_quotes_and_returns_5(): void
    {
        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $response = $this->getJson(route('quotes.index'));

        $response->assertOk();

        $responseJson = $response->json();

        $this->assertArrayHasKey('quotes', $responseJson);

        $this->assertCount(5, $responseJson['quotes']);
    }
}
