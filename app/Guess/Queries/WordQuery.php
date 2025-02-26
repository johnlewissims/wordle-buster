<?php

namespace App\Guess\Queries;

use App\Models\Word;
use Illuminate\Database\Eloquent\Builder;

class WordQuery
{
    public function build(array $letterArray): Builder
    {
        $query = Word::query();

        $this->applyCorrectLetterConstraints($query, $letterArray['correctLetters']);
        $this->applyBlacklistedLetterConstraints($query, $letterArray['blacklistedLetters']);
        $this->applyIncorrectlyPlacedLetterConstraints($query, $letterArray['incorrectlyPlacedLetters']);

        return $query;
    }

    private function applyCorrectLetterConstraints(Builder $query, array $correctLetters): void
    {
        if (empty(array_filter($correctLetters))) {
            return;
        }

        foreach ($correctLetters as $index => $letter) {
            if ($letter) {
                $query->whereRaw("LOWER(SUBSTRING(word FROM ? FOR 1)) = LOWER(?)", [$index + 1, $letter]);
            }
        }
    }

    private function applyBlacklistedLetterConstraints(Builder $query, array $blacklistedLetters): void
    {
        if (empty($blacklistedLetters)) {
            return;
        }

        foreach ($blacklistedLetters as $letter) {
            $query->whereRaw("LOWER(word) NOT LIKE ?", ['%' . strtolower($letter) . '%']);
        }
    }

    private function applyIncorrectlyPlacedLetterConstraints(Builder $query, array $incorrectlyPlacedLetters): void
    {
        if (empty($incorrectlyPlacedLetters)) {
            return;
        }

        foreach ($incorrectlyPlacedLetters as $index => $letters) {
            foreach ($letters as $letter) {
                $query->whereRaw("LOWER(SUBSTRING(word FROM ? FOR 1)) != LOWER(?)", [$index + 1, $letter])
                    ->whereRaw("LOWER(word) LIKE ?", ['%' . strtolower($letter) . '%']);
            }
        }
    }
}
