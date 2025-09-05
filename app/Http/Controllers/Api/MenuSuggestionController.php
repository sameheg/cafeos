<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MenuSuggestionService;

class MenuSuggestionController extends Controller
{
    protected MenuSuggestionService $service;

    public function __construct(MenuSuggestionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json([
            'data' => $this->service->getSuggestions(),
        ]);
    }
}
