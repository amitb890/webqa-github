<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OnboardingController extends Controller
{
    protected $collected = [];
    protected $limit = 2000;

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
            if ($res->successful()) {
                // Match all "Sitemap:" lines, allow spaces/tabs, and capture full URL
                preg_match_all('/Sitemap:\s*([^\s]+)/i', $res->body(), $matches);

                if (!empty($matches[1])) {
                    foreach ($matches[1] as $sitemapUrl) {
                        $sitemapUrl = trim($sitemapUrl);
                        if (filter_var($sitemapUrl, FILTER_VALIDATE_URL)) {
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
            try {
                $res = Http::timeout(5)->get($url);
                if ($res->successful()) {
                    // only add if it looks like XML
                    if (stripos($res->body(), '<urlset') !== false || stripos($res->body(), '<sitemapindex') !== false) {
                        $sitemaps[] = $url;
                    }
                }
            } catch (\Exception $e) {
                // ignore
            }
        }

        // 3. Ensure unique sitemaps
        $sitemaps = array_values(array_unique($sitemaps));

        // 4. Fallback: just return root if nothing found
        if (empty($sitemaps)) {
            $sitemaps = [];
        }

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

        foreach ($request->sitemaps as $sitemap) {
            $this->crawlSitemap($sitemap);
            if (count($this->collected) >= $this->limit) break;
        }

        $urls = array_values($this->collected);

        return response()->json([
            'count' => count($urls),
            'urls'  => $urls,
        ]);
    }

    /**
     * Crawl an XML sitemap recursively
     */
    protected function crawlSitemap($url)
    {
        try {
            $res = Http::timeout(10)->get($url);
            if (!$res->successful()) return;

            $xml = @simplexml_load_string($res->body());
            if (!$xml) return;

            // If it's a sitemap index
            if (isset($xml->sitemap)) {
                foreach ($xml->sitemap as $s) {
                    if (isset($s->loc)) {
                        $this->crawlSitemap((string)$s->loc);
                    }
                }
            }

            // If it's a urlset
            if (isset($xml->url)) {
                foreach ($xml->url as $u) {
                    if (isset($u->loc)) {
                        $loc = (string)$u->loc;
                        if ($this->isHtmlUrl($loc)) {
                            $this->collected[$loc] = $loc;
                        }
                    }
                    if (count($this->collected) >= $this->limit) break;
                }
            }
        } catch (\Exception $e) {
            // ignore
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
}
