<?php

namespace App\Jobs;

use App\Models\LighthouseTest;
use App\Models\LighthouseResult;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunLighthouseTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $testId;

    public function __construct($testId)
    {
        $this->onQueue('lighthouse');
        $this->testId = $testId;
    }

    public function handle()
    {
        $test = LighthouseTest::findOrFail($this->testId);
        $urls = json_decode($test->urls, true);

        foreach ($urls as $urlIndex => $url) {
            foreach (['desktop', 'mobile'] as $strategyIndex => $strategy) {
                $result = LighthouseResult::create([
                    'test_id' => $test->id,
                    'url' => $url['url'],
                    'strategy' => $strategy,
                    'status' => 'pending',
                ]);
        
                // Delay based on URL + strategy index to stagger jobs
                $delaySeconds = ($urlIndex * 2) + $strategyIndex; // 2s per URL + 1s for strategy
                dispatch(new RunSinglePageSpeedTest($result->id))
                    ->onQueue('lighthouse');
            }
        }
    }
}
