<?php

namespace App\Guess\Services;

use Exception;
use Illuminate\Http\Request;

class GuessService
{

    const API_URI = "https://api.datamuse.com/words?sp=";

    public function sortLetters($guessArray){
        $blacklistedLetters = [];
        $incorrectlyPlacedLetters = [[],[],[],[],[]];
        $correctLetters = ['', '', '', '', ''];

        foreach($guessArray as $guess) {
            foreach($guess as $index => $letter) {
                if($letter['result'] == 1) {
                    $correctLetters[$index] = $letter['value'];
                } else if($letter['result'] == 2) {
                    array_push($blacklistedLetters, $letter['value']);
                } else if($letter['result'] == 3) {
                    array_push($incorrectlyPlacedLetters[$index], $letter['value']);
                }
            }
        }

        return [
            'blacklisted' => $blacklistedLetters, 
            'incorrectlyplaced' => $incorrectlyPlacedLetters, 
            'correctlyPlaced' => $correctLetters
        ];
    }

    public function createUrl($letterArray) {
        $query = '';
        foreach($letterArray as $letter) {
            if($letter === '') {
                $query = $query . '?';
            } else {
                $query = $query . $letter;
            }
        }
        return self::API_URI . $query;
    }    

    public function search($url) {
        try {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          
            $resp = curl_exec($curl);
            curl_close($curl);
            return json_decode($resp);
        } catch(Exception $e) {
            return false;
        }
    }

    public function removeByBlacklistedLetters($options, $blacklistedLetters) {
        foreach($options as $key => $word) {
            foreach($blacklistedLetters as $letter) {
              if(str_contains(strtoupper($word->word), $letter)) {
                unset($options[$key]);
              }
            }
            // $letterArray = str_split($word->word);
            // foreach($blacklistedLettersByPosition as $letterPosition => $letter) {
            //   if(in_array($letter, [$letterArray[$letterPosition]])) {
            //     unset($result[$key]);
            //   };
            // }
          }
          return $options;
    }

}
