<?php

namespace App\Jobs;

use App\Models\LighthouseTest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


ini_set('max_execution_time', 180000);
ini_set('memory_limit', '512M');

class RunLighthouseTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600; // Increase timeout to 5 minutes
    public $tries = 1; // Prevent multiple retries

    protected $testId;
    protected $url;

    /**
     * Create a new job instance.
     */
    public function __construct($testId, $url)
    {
        $this->testId = $testId;
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $test = LighthouseTest::findOrFail($this->testId);

            DB::transaction(function () use ($test) {
                
                $fresh = LighthouseTest::lockForUpdate()->find($this->testId);

                $results = json_decode($fresh->results ?? '{}', true);
                $results[$this->url] = [
                    'desktop' => $this->fetchPageSpeedResults($this->url, 'desktop'),
                    'mobile' => $this->fetchPageSpeedResults($this->url, 'mobile'),
                ];

                $completed = json_decode($fresh->completed_urls ?? '[]', true);
                $completed[] = $this->url;
                $completed = array_unique($completed);

                $update = [
                    'results' => json_encode($results),
                    'completed_urls' => json_encode($completed),
                ];

                // Mark complete if done
                $allUrls = json_decode($fresh->urls, true);
                if (count($completed) >= count($allUrls)) {
                    $update['status'] = 'completed';
                }

                $fresh->update($update);
            });
          

        } catch (\Throwable $e) {
            Log::error("Failed PageSpeed test for {$this->url}: {$e->getMessage()}");
        }
    }

    /**
     * Fetch PageSpeed Insights data for a URL.
     */
    private function fetchPageSpeedResults(string $url, string $strategy = 'mobile'): array
    {
        $apiKey = "AIzaSyCKPTSNwVnuuHkMvKmzZO3UDUb6q79JxRY";
        $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={$url}&strategy={$strategy}&category=performance&category=best-practices&category=accessibility&category=seo&key={$apiKey}";

        $response = @file_get_contents($apiUrl);
        if (!$response) {
            throw new \Exception("Failed to fetch PageSpeed API for {$url} ({$strategy})");
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

    /**
     * Handle failed job.
     */
    public function failed(\Throwable $exception)
    {
        $test = LighthouseTest::find($this->testId);
        if ($test) {
            $test->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);
        }
        Log::error('Lighthouse job permanently failed: ' . $exception->getMessage());
    }
}
