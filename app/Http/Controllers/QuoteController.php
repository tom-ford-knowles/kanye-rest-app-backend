<?php

namespace App\Http\Controllers;

use App\Facades\Quotes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class QuoteController extends Controller
{
    public function index(): JsonResponse
    {
        $responses = Quotes::fetch();

        return response()->json([
            'quotes' => Arr::map($responses, function ($response) {
                return $response->json('quote');
            }),
        ]);
    }
}
