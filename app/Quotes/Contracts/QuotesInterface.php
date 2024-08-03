<?php

namespace App\Quotes\Contracts;

interface QuotesInterface
{
    public function fetch(bool $refresh = false): array;
}
