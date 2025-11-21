<?php

namespace App\Jobs;

use App\Models\LighthouseResult;
use App\Models\LighthouseTest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class RunSinglePageSpeedTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 900; // 15 minutes
    public $tries = 1;      // Retry 3 times
    public $backoff = 10;   // Wait 10 seconds between retries

    protected $resultId;

    public function __construct($resultId)
    {
        $this->onQueue('lighthouse');
        $this->resultId = $resultId;
    }

    public function handle()
    {
        $result = LighthouseResult::findOrFail($this->resultId);

        try {
            $data = $this->fetchPageSpeedResults($result->url, $result->strategy);

            $result->update([
                'data' => json_encode($data),
                'status' => 'completed',
            ]);

            // Check if all results for the parent test are done
            $this->checkIfParentCompleted($result->test_id);
        } catch (\Throwable $e) {
            $result->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            Log::error("Failed PageSpeed test for {$result->url} ({$result->strategy}): {$e->getMessage()}");
            // Throwing exception will trigger retry
            throw $e;
        }
    }

    private function fetchPageSpeedResults(string $url, string $strategy): array
{
    $apiKey = "AIzaSyCKPTSNwVnuuHkMvKmzZO3UDUb6q79JxRY";
    $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={$url}&strategy={$strategy}&category=performance&category=best-practices&category=accessibility&category=seo&key={$apiKey}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Set to false only if you have SSL issues
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        throw new \Exception("cURL error: {$curlError}");
    }

    if ($httpCode !== 200) {
        throw new \Exception("PageSpeed API returned HTTP {$httpCode} for {$url} ({$strategy})");
    }

    $data = json_decode($response, true);

    if (!isset($data['lighthouseResult'])) {
        throw new \Exception("Lighthouse result missing for {$url} ({$strategy})");
    }

    $lr = $data['lighthouseResult'];
    $categories = $lr['categories'];

    return [
        'performance_score' => $categories['performance']['score'] * 100 ?? null,
        'best_practices_score' => $categories['best-practices']['score'] * 100 ?? null,
        'accessibility_score' => $categories['accessibility']['score'] * 100 ?? null,
        'seo_score' => $categories['seo']['score'] * 100 ?? null,
        'first_contentful_paint' => floatval($lr['audits']['first-contentful-paint']['numericValue'] / 1000) ?? null,
        'largest_contentful_paint' => floatval($lr['audits']['largest-contentful-paint']['numericValue'] / 1000) ?? null,
        'speed_index' => floatval($lr['audits']['speed-index']['numericValue'] / 1000) ?? null,
        'interactive' => floatval($lr['audits']['interactive']['numericValue'] / 1000) ?? null,
        'total_blocking_time' => floatval($lr['audits']['total-blocking-time']['numericValue']) ?? null,
        'cumulative_layout_shift' => floatval($lr['audits']['cumulative-layout-shift']['numericValue'] / 1000) ?? null,
        'max_potential_fid' => floatval($lr['audits']['max-potential-fid']['numericValue']) ?? null,
    ];
}


    private function checkIfParentCompleted($testId)
    {
        $test = LighthouseTest::findOrFail($testId);
        $total = $test->results()->count();
        $completed = $test->results()->where('status', 'completed')->count();
        $failed = $test->results()->where('status', 'failed')->count();

        if ($completed + $failed === $total) {
            $test->update([
                'status' => $failed > 0 ? 'failed' : 'completed',
            ]);
        }
    }
}
