<?php

namespace App\Quotes;

use Illuminate\Support\Manager;

class QuotesManager extends Manager
{
    public function getDefaultDriver()
    {
        return 'kanyeQuotes';
    }

    public function createKanyeQuotesDriver()
    {
        return new KanyeQuotes;
    }
}
