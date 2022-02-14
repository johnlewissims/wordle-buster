<?php

namespace App\Guess;

use App\Guess\Services\GuessService;
use App\Models\Word;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Guess
{

    public function __construct()
    {
        $this->guessService = new GuessService();
    }

    public function makeGuess(Request $request) {
        $sortedLetters = $this->guessService->sortLetters($request->get('guess'));
        $query = $this->guessService->makeQuery($sortedLetters);

        $wordData = DB::select($query);
        $wordModels = Word::hydrate($wordData)->sortByDesc('score');

        return ['options' => $wordModels];
    }


}
