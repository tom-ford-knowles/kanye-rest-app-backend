<?php

namespace App\Quotes;

use App\Quotes\Contracts\QuotesInterface;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class KanyeQuotes implements QuotesInterface
{
    public function fetch(bool $refresh = false): array
    {
        if ($refresh || ! Cache::has('quotes')) {
            Cache::forget('quotes');

            $responses = Http::pool(fn (Pool $pool) => [
                $pool->get('https://api.kanye.rest'),
                $pool->get('https://api.kanye.rest'),
                $pool->get('https://api.kanye.rest'),
                $pool->get('https://api.kanye.rest'),
                $pool->get('https://api.kanye.rest'),
            ]);

            Cache::put('quotes', Arr::map($responses, function ($response) {
                return $response->json('quote');
            }), 60 * 60);
        }

        return Cache::get('quotes');
    }
}
