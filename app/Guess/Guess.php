<?php

namespace App\Guess;

use App\Guess\Services\GuessService;
use Illuminate\Http\Request;

class Guess
{

    public function __construct()
    {
        $this->guessService = new GuessService();
    }

    public function makeGuess(Request $request) {
        $sortedLetters = $this->guessService->sortLetters($request->get('guess'));
        $url = $this->guessService->createUrl($sortedLetters['correctlyPlaced']);
        $result = $this->guessService->search($url);

        $blacklistRemoved = $this->guessService->removeByBlacklistedLetters($result, $sortedLetters['blacklisted']);

        return $blacklistRemoved;
    }


}
