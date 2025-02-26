<?php

namespace App\Guess\Actions;

use App\Models\Word;
use Illuminate\Database\Eloquent\Builder;

class SortLettersAction
{
    public function execute(array $guessArray): array
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
}
