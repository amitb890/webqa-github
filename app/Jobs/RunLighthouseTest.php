<?php

namespace App\Jobs;

use App\Models\LighthouseTest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

ini_set('max_execution_time', 180000);
ini_set('memory_limit', '512M');

class RunLighthouseTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 180000; // Increase timeout to 5 minutes
    public $tries = 1; // Prevent multiple retries

    protected $lighthouseTest;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\LighthouseTest $lighthouseTest
     */
    public function __construct(LighthouseTest $lighthouseTest)
    {
        $this->lighthouseTest = $lighthouseTest;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $urls = json_decode($this->lighthouseTest->urls, true);
        $results = [];

        foreach ($urls as $url) {

            $url = $url["url"];
            try {

                // Fetch desktop and mobile results
                $desktopResults = $this->fetchPageSpeedResults($url, 'desktop');
                $mobileResults = $this->fetchPageSpeedResults($url, 'mobile');

                $results[$url] = [
                    'desktop' => $desktopResults,
                    'mobile' => $mobileResults,
                ];

                 // Update the database immediately for the current URL
                 $this->lighthouseTest->update([
                    'results' => json_encode($results),
                ]);

            } catch (\Exception $e) {
                Log::error("Failed to fetch data for URL: $url. Error: " . $e->getMessage());
                $results[$url] = ['error' => 'Failed to fetch results'];

                 // Update the database with the error
                 $this->lighthouseTest->update([
                    'results' => json_encode($results),
                ]);
            }
        }

        // Update the database with results
        $this->lighthouseTest->update([
            'status' => 'completed',
        ]);
    }


    private function fetchPageSpeedResults($url, $strategy)
    {
        $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={$url}&strategy={$strategy}&category=performance&category=best-practices&category=accessibility&category=seo&key=AIzaSyCKPTSNwVnuuHkMvKmzZO3UDUb6q79JxRY";

        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);

        if (!isset($data['lighthouseResult'])) {
            throw new \Exception("Lighthouse result is missing for URL: $url ($strategy)");
        }

        $lighthouseResult = $data['lighthouseResult'];
        $categories = $lighthouseResult['categories'];

        return [
            'performance_score' => $categories['performance']['score'] * 100 ?? null,
            'best_practices_score' => $categories['best-practices']['score'] * 100 ?? null,
            'accessibility_score' => $categories['accessibility']['score'] * 100 ?? null,
            'seo_score' => $categories['seo']['score'] * 100 ?? null,
            'first_contentful_paint' => floatval($lighthouseResult['audits']['first-contentful-paint']['numericValue'] / 1000) ?? null,
            'largest_contentful_paint' => floatval($lighthouseResult['audits']['largest-contentful-paint']['numericValue'] / 1000) ?? null,
            'speed_index' => floatval($lighthouseResult['audits']['speed-index']['numericValue'] / 1000) ?? null,
            'interactive' => floatval($lighthouseResult['audits']['interactive']['numericValue'] / 1000) ?? null,
            'total_blocking_time' => floatval($lighthouseResult['audits']['total-blocking-time']['numericValue']) ?? null,
            'cumulative_layout_shift' => floatval($lighthouseResult['audits']['cumulative-layout-shift']['numericValue'] / 1000) ?? null,
            'max_potential_fid' => floatval($lighthouseResult['audits']['max-potential-fid']['numericValue']) ?? null,
        ];
    }


    public function failed(\Exception $exception){
        $this->lighthouseTest->update([
            'status' => 'failed',
            'error_message' => $exception->getMessage(),
        ]);
    }

}
