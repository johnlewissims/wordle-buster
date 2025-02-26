<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;

class WordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath(database_path('seeders/data/words.csv'), 'r');
        $csv->setHeaderOffset(0);

        $stmt = (new Statement())->process($csv);

        $batchSize = 500;
        $data = [];

        foreach ($stmt as $record) {
            $data[] = [
                'id' => $record['id'],
                'word' => $record['word'],
                'score' => $record['score'],
                'letter_frequency_score' => $record['letter_frequency_score'],
            ];

            if (count($data) >= $batchSize) {
                DB::table('words')->insert($data);
                $data = [];
            }
        }

        if (count($data) > 0) {
            DB::table('words')->insert($data);
        }
    }
}
