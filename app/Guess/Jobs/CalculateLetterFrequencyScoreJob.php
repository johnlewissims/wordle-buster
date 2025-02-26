<?php

namespace App\Guess\Jobs;

use App\Models\Word;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateLetterFrequencyScoreJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $alphabet = ["a" => 0,"b" => 0,"c" => 0,"d" => 0,"e" => 0,"f" => 0,"g" => 0,"h" => 0,"i" => 0,"j" => 0,"k" => 0,"l" => 0,"m" => 0,"n" => 0,"o" => 0,"p" => 0,"q" => 0,"r" => 0,"s" => 0,"t" => 0,"u" => 0,"v" => 0,"w" => 0,"x" => 0,"y" => 0,"z" => 0];
        $words = Word::where('letter_frequency_score', 0)->get();
        foreach($words as $word) {
            $letters = str_split(strtolower($word->word));
            $letters = array_unique($letters);
            foreach($letters as $letter) {
                if(key_exists($letter, $alphabet)) {
                    $alphabet[$letter]++;
                }
            }
        }

        foreach($alphabet as $key => $letter) {
            $alphabet[$key] = $letter / 6453;
        }

        foreach($words as $word) {
            $letters = str_split(strtolower($word->word));
            $letters = array_unique($letters);
            $wordScore = 0;
            foreach($letters as $letter) {
                if(key_exists($letter, $alphabet)) {
                    $wordScore = $wordScore + $alphabet[$letter];
                }
            }
            $word->letter_frequency_score = $wordScore;
            $word->save();
        }
    }
}
