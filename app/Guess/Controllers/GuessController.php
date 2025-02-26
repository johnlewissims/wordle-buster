<?php

namespace App\Guess\Controllers;

use App\Guess\Guess;
use App\Guess\Requests\GuessRequest;
use App\Guess\Services\GuessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class GuessController extends BaseController
{
    public function __construct(private GuessService $service)
    {
    }

    public function __invoke(GuessRequest $request): JsonResponse
    {
        $result = $this->service->makeGuess($request);

        return response()->json($result);
    }
}
