<?php

namespace App\Http\Controllers;

use App\Services\AiMatchmakingService;
use Illuminate\Http\Request;

class AiMatchmakingController extends Controller
{
    protected $matchmakingService;

    public function __construct(AiMatchmakingService $matchmakingService)
    {
        $this->matchmakingService = $matchmakingService;
    }

    public function index()
    {
        return view('ai.matchmaking');
    }

    public function match(Request $request)
    {
        $request->validate([
            'budget' => 'nullable|numeric',
            'categories' => 'nullable|array',
        ]);

        $matches = $this->matchmakingService->match($request->all());

        return response()->json([
            'success' => true,
            'matches' => $matches,
        ]);
    }
}
