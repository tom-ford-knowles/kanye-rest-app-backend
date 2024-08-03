<?php

namespace App\Quotes\Contracts;

interface QuotesInterface
{
    public function fetch(): array;
}
