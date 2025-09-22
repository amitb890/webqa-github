<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OnboardingController extends Controller
{
    protected $collected = [];
    protected $limit = 2000;
    protected $startTime;
    protected $maxExecutionTime = 60; // seconds

    /**
     * STEP 1: Detect all possible sitemaps for a website
     */
    public function detectSitemaps(Request $request)
    {
        $request->validate([
            'root_url' => 'required|url'
        ]);

        $rootUrl = rtrim($request->root_url, '/');
        $sitemaps = [];

        // 1. Try robots.txt
        $robotsUrl = $rootUrl . '/robots.txt';
        try {
            $res = Http::timeout(5)->get($robotsUrl);
            if ($res->status() === 200) {
                preg_match_all('/Sitemap:\s*([^\s]+)/i', $res->body(), $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $sitemapUrl) {
                        $sitemapUrl = trim($sitemapUrl);
                        if ($this->isValidSitemap($sitemapUrl)) {
                            $sitemaps[] = $sitemapUrl;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // ignore robots errors
        }

        // 2. Try common sitemap filenames at root
        $commonSitemaps = [
            'sitemap.xml',
            'sitemap_index.xml',
            'sitemap1.xml',
            'sitemap-news.xml',
            'sitemap-index.xml',
        ];

        foreach ($commonSitemaps as $file) {
            $url = $rootUrl . '/' . $file;
            if ($this->isValidSitemap($url)) {
                $sitemaps[] = $url;
            }
        }

        // 3. Ensure unique sitemaps
        $sitemaps = array_values(array_unique($sitemaps));

        return response()->json([
            'sitemaps' => $sitemaps,
        ]);
    }

    /**
     * STEP 2: Crawl selected sitemaps and extract URLs
     */
    public function fetchUrls(Request $request)
    {
        $request->validate([
            'sitemaps' => 'required|array',
            'sitemaps.*' => 'url',
        ]);

        $this->collected = [];
        $this->startTime = microtime(true);

        foreach ($request->sitemaps as $sitemap) {
            if ($this->timeExceeded()) break;

            if ($this->isValidSitemap($sitemap)) {
                $this->crawlSitemap($sitemap);
            }

            if ($this->timeExceeded() || count($this->collected) >= $this->limit) break;
        }

        $urls = array_values($this->collected);

        return response()->json([
            'count' => count($urls),
            'urls'  => $urls,
            'time_elapsed' => round(microtime(true) - $this->startTime, 2) . 's'
        ]);
    }

    /**
     * Crawl an XML sitemap recursively
     */
    protected function crawlSitemap($url)
    {
        if ($this->timeExceeded() || count($this->collected) >= $this->limit) return;

        try {
            $res = Http::timeout(10)->get($url);
            if ($res->status() !== 200) return;

            $xml = @simplexml_load_string($res->body());
            if (!$xml) return;

            // If it's a sitemap index
            if (isset($xml->sitemap)) {
                foreach ($xml->sitemap as $s) {
                    if ($this->timeExceeded() || count($this->collected) >= $this->limit) break;

                    if (isset($s->loc)) {
                        $loc = (string) $s->loc;
                        if ($this->isValidSitemap($loc)) {
                            $this->crawlSitemap($loc);
                        }
                    }
                }
            }

            // If it's a urlset
            if (isset($xml->url)) {
                foreach ($xml->url as $u) {
                    if ($this->timeExceeded() || count($this->collected) >= $this->limit) break;

                    if (isset($u->loc)) {
                        $loc = (string) $u->loc;
                        if ($this->isHtmlUrl($loc)) {
                            $this->collected[$loc] = $loc;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // ignore errors
        }
    }

    /**
     * Validate if a URL is a valid sitemap (200 + XML + contains <urlset> or <sitemapindex>)
     */
    protected function isValidSitemap($url)
    {
        try {
            $res = Http::timeout(5)->get($url);

            // Only accept HTTP 200 OK
            if ($res->status() !== 200) {
                return false;
            }

            $xml = @simplexml_load_string($res->body());
            if (!$xml) {
                return false;
            }

            // Check if it’s a sitemap index or a urlset
            if (isset($xml->sitemap) || isset($xml->url)) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Only keep HTML pages (no images, PDFs, txt, etc.)
     */
    protected function isHtmlUrl($url)
    {
        $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        $nonHtml = ['jpg','jpeg','png','gif','bmp','svg','pdf','txt','xml','webp','zip','gz'];
        return !in_array($ext, $nonHtml);
    }

    /**
     * Check if max execution time exceeded
     */
    protected function timeExceeded()
    {
        return (microtime(true) - $this->startTime) > $this->maxExecutionTime;
    }
}
