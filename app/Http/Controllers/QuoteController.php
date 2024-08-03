<?php

namespace App\Http\Controllers;

use App\Facades\Quotes;
use App\Http\Requests\IndexQuotesRequest;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
    public function index(IndexQuotesRequest $request): JsonResponse
    {
        $responses = Quotes::fetch($request->get('fetch_new_quotes', false));

        return response()->json([
            'quotes' => $responses,
        ]);
    }
}
