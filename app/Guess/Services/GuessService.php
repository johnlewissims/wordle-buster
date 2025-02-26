<?php

namespace App\Guess\Services;

use App\Models\Word;
use Illuminate\Database\Eloquent\Builder;

class GuessService
{
    public function sortLetters($guessArray)
    {
        $blacklistedLetters = [];
        $incorrectlyPlacedLetters = [[], [], [], [], []];
        $correctLetters = ['', '', '', '', ''];

        foreach ($guessArray as $guess) {
            foreach ($guess as $index => $letter) {
                if (strlen($letter['value']) !== 1) continue;

                if ($letter['result'] === 1) {
                    $correctLetters[$index] = $letter['value'];
                    $blacklistedLetters = array_diff($blacklistedLetters, [$letter['value']]);
                } elseif ($letter['result'] === 2) {
                    if (!in_array($letter['value'], $correctLetters)) {
                        $blacklistedLetters[] = $letter['value'];
                    }
                } elseif ($letter['result'] === 3) {
                    $incorrectlyPlacedLetters[$index][] = $letter['value'];
                }
            }
        }

        return compact('blacklistedLetters', 'incorrectlyPlacedLetters', 'correctLetters');
    }

    public function makeQuery($letterArray)
    {
        return Word::query()
            ->when(!empty(array_filter($letterArray['correctLetters'])), function (Builder $query) use ($letterArray) {
                foreach ($letterArray['correctLetters'] as $index => $letter) {
                    if ($letter) {
                        $query->whereRaw("LOWER(SUBSTRING(word FROM ? FOR 1)) = LOWER(?)", [$index + 1, $letter]);
                    }
                }
            })
            ->when(!empty($letterArray['blacklistedLetters']), function (Builder $query) use ($letterArray) {
                foreach ($letterArray['blacklistedLetters'] as $letter) {
                    $query->whereRaw("LOWER(word) NOT LIKE ?", ['%' . strtolower($letter) . '%']);
                }
            })
            ->when(!empty($letterArray['incorrectlyPlacedLetters']), function (Builder $query) use ($letterArray) {
                foreach ($letterArray['incorrectlyPlacedLetters'] as $index => $letters) {
                    foreach ($letters as $letter) {
                        $query->whereRaw("LOWER(SUBSTRING(word FROM ? FOR 1)) != LOWER(?)", [$index + 1, $letter])
                            ->whereRaw("LOWER(word) LIKE ?", ['%' . strtolower($letter) . '%']);
                    }
                }
            });
    }
}

