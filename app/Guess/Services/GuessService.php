<?php

namespace App\Guess\Services;

use Exception;
use Illuminate\Http\Request;

class GuessService
{

    const BASE_WHERE_POSITION_IS = " AND POSITION('letter' IN words.word) = position";
    const BASE_WHERE_POSITION_IS_NOT = " AND POSITION('letter' IN words.word) != position";
    const BASE_WHERE_CONTAINS = " AND POSITION('letter' IN words.word) != 0";
    const BASE_WHERE_DOES_NOT_CONTAIN = " AND POSITION('letter' IN words.word) = 0";
    const ORDER_BY = " ORDER BY score DESC";

    public function sortLetters($guessArray){
        $blacklistedLetters = [];
        $incorrectlyPlacedLetters = [[],[],[],[],[]];
        $correctLetters = ['', '', '', '', ''];

        foreach($guessArray as $guess) {
            foreach($guess as $index => $letter) {
                if(strlen($letter['value']) != 1) {
                    die;
                }

                if($letter['result'] == 1) {
                    $correctLetters[$index] = $letter['value'];

                    // Remove Letter From Blacklist if Correct
                    if (($key = array_search($letter['value'], $blacklistedLetters)) !== false) {
                        unset($blacklistedLetters[$key]);
                    }          
                } else if($letter['result'] == 2) {
                    // If Letter is Already in correctLetters Array, Do Not Blacklist
                    if(!in_array($letter['value'], $correctLetters)) {
                        array_push($blacklistedLetters, $letter['value']);
                    }
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

    public function makeQuery($letterArray) {
        $query = 'SELECT * FROM words';
        foreach($letterArray['correctlyPlaced'] as $index => $correct) {
            if(!empty($correct)) {
                $whereStringReplaced = str_replace(['letter', 'position'], [$correct, $index + 1], self::BASE_WHERE_POSITION_IS);
                $query = $query . $whereStringReplaced;
            }
        }

        foreach($letterArray['blacklisted'] as $blackListed) {
            $whereStringReplaced = str_replace(['letter'], [$blackListed], self::BASE_WHERE_DOES_NOT_CONTAIN);
            $query = $query . $whereStringReplaced;
        }

        foreach($letterArray['incorrectlyplaced'] as $index => $incorrect) {
            foreach($incorrect as $letter) {
                $whereStringReplaced = str_replace(['letter', 'position'], [$letter, $index + 1], self::BASE_WHERE_POSITION_IS_NOT);
                $query = $query . $whereStringReplaced;
                
                $whereStringReplaced = str_replace(['letter'], [$letter], self::BASE_WHERE_CONTAINS);
                $query = $query . $whereStringReplaced;
            }
        }

        $pos = strpos($query, 'AND');
        if ($pos !== false) {
            $query = substr_replace($query, 'WHERE', $pos, strlen('AND'));
        }

        $query = $query . self::ORDER_BY;

        return $query;
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

}
