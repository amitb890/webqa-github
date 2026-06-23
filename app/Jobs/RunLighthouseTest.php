<?php

namespace App\Jobs;

use App\Models\LighthouseResult;
use App\Models\LighthouseTest;
use App\Support\LighthouseUrlParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RunLighthouseTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $testId;
    public $userId;

    public function __construct($testId, $userId)
    {
        $this->testId = $testId;
        $this->userId = $userId;
    }



    

    public function handle()
    {
        $test = LighthouseTest::find($this->testId);
        if (! $test) {
            Log::warning('RunLighthouseTest skipped: lighthouse_tests row no longer exists (stale queue job).', [
                'test_id' => $this->testId,
                'user_id' => $this->userId,
            ]);

            return;
        }

        if ($test->status !== 'in_progress') {
            Log::info('RunLighthouseTest skipped: test was stopped before result rows were queued.', [
                'test_id' => $this->testId,
                'status' => $test->status,
            ]);

            return;
        }

        $urls = LighthouseUrlParser::fromStoredJson($test->urls);
        $userId = $this->userId;
        $lighthouseQueues = ['lighthouse_1','lighthouse_2','lighthouse_3','lighthouse_4','lighthouse_5'];

        foreach ($urls as $urlIndex => $urlString) {
            foreach (['desktop', 'mobile'] as $strategyIndex => $strategy) {
                $result = LighthouseResult::create([
                    'test_id' => $test->id,
                    'url' => $urlString,
                    'strategy' => $strategy,
                    'status' => 'pending',
                ]);
        
                // Delay based on URL + strategy index to stagger jobs
                $delaySeconds = ($urlIndex * 2) + $strategyIndex; // 2s per URL + 1s for strategy


                $index = ($userId - 1) % count($lighthouseQueues);
                $userQueue = $lighthouseQueues[$index];
    
                dispatch(new RunSinglePageSpeedTest($result->id))->onQueue($userQueue);
            }
        }
    }
}
