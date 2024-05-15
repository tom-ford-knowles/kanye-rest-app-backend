<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class QuoteController extends Controller
{
    public function index(): JsonResponse
    {
        $responses = Http::pool(fn (Pool $pool) => [
            $pool->get('https://api.kanye.rest'),
            $pool->get('https://api.kanye.rest'),
            $pool->get('https://api.kanye.rest'),
            $pool->get('https://api.kanye.rest'),
            $pool->get('https://api.kanye.rest'),
        ]);

        return response()->json([
            'quotes' => Arr::map($responses, function ($response) {
                return $response->json('quote');
            }),
        ]);
    }
}
