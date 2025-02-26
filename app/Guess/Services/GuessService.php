<?php

namespace App\Guess\Services;

use App\Guess\Actions\SortLettersAction;
use App\Guess\Queries\WordQuery;
use App\Guess\Requests\GuessRequest;

class GuessService
{
    public function __construct(
        private WordQuery $wordQuery,
        private SortLettersAction $sortLettersAction,
    )
    {
    }

    public function makeGuess(GuessRequest $request)
    {
        $guessData = $request->getGuessData();

        $sortedLetters = $this->sortLettersAction->execute($guessData);
        $wordQuery = $this->wordQuery->build($sortedLetters);

        $wordModels = $wordQuery->get()->sortByDesc('score');
        $wordLetterFrequency = $wordQuery->get()->sortByDesc('letter_frequency_score');

        return [
            'options' => $wordModels->take(20),
            'best_guess' => $wordLetterFrequency->take(5),
            'count' => $wordModels->count()
        ];
    }
}

