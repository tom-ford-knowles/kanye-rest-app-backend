<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
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
        Cache::shouldReceive('has')->with('quotes')->andReturn(true)->once();
        Cache::shouldReceive('get')->with('quotes')->andReturn([
            'test',
            'test',
            'test',
            'test',
            'test',
        ])->once();

        Http::fake([
            'https://api.kanye.rest' => Http::response(['quote' => 'hello']),
        ]);

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

    public function test_cache_is_flushed_when_user_fetches_new_quotes(): void
    {
        Http::fake([
            'https://api.kanye.rest' => Http::response(['quote' => 'test']),
        ]);

        Cache::shouldReceive('forget')->with('quotes')->once();
        Cache::shouldReceive('put')->with('quotes', ['test', 'test', 'test', 'test', 'test'], 60 * 60)->once();
        Cache::shouldReceive('get')->with('quotes')->andReturn([
            'test',
            'test',
            'test',
            'test',
            'test',
        ])->once();

        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $response = $this->getJson(route('quotes.index', ['fetch_new_quotes' => true]));

        $response->assertOk();

        $responseJson = $response->json();

        $this->assertArrayHasKey('quotes', $responseJson);

        $this->assertCount(5, $responseJson['quotes']);
    }
}
