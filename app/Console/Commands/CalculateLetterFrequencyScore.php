<?php

namespace App\Console\Commands;

use App\Guess\Jobs\CalculateLetterFrequencyScoreJob;
use Illuminate\Console\Command;

class CalculateLetterFrequencyScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-letter-frequency-score';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        private CalculateLetterFrequencyScoreJob $calculateLetterFrequencyScoreJob
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Letter frequency score job dispatched');
        dispatch($this->calculateLetterFrequencyScoreJob);
    }
}
