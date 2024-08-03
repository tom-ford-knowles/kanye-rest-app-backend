<?php

namespace App\Quotes;

use App\Quotes\Contracts\QuotesInterface;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class KanyeQuotes implements QuotesInterface
{
    public function fetch(): array
    {
        return Http::pool(fn (Pool $pool) => [
            $pool->get('https://api.kanye.rest'),
            $pool->get('https://api.kanye.rest'),
            $pool->get('https://api.kanye.rest'),
            $pool->get('https://api.kanye.rest'),
            $pool->get('https://api.kanye.rest'),
        ]);
    }
}
