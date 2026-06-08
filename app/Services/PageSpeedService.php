<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PageSpeedService
{
    private const API_KEY = 'AIzaSyCKPTSNwVnuuHkMvKmzZO3UDUb6q79JxRY';

    private const MAX_RETRIES = 3;

    private const REQUEST_TIMEOUT = 120;

    private const SESSION_DESKTOP = 'google_page_speed_desktop';

    private const SESSION_MOBILE = 'google_page_speed_mobile';

    /**
     * @return array{desktop: object, mobile: object}
     */
    public function getOrFetch(string $url, bool $screenshot = false): array
    {
        $cached = $this->getCached();

        if ($cached !== null) {
            return $cached;
        }

        return $this->fetchAndCache($url, $screenshot);
    }

    /**
     * @return array{desktop: object, mobile: object}|null
     */
    public function getCached(): ?array
    {
        $desktop = Session::get(self::SESSION_DESKTOP);
        $mobile = Session::get(self::SESSION_MOBILE);

        if (! $desktop || ! $mobile) {
            return null;
        }

        $desktopData = json_decode($desktop);
        $mobileData = json_decode($mobile);

        if (! $desktopData || ! $mobileData || ! isset($desktopData->lighthouseResult, $mobileData->lighthouseResult)) {
            return null;
        }

        return [
            'desktop' => $desktopData,
            'mobile' => $mobileData,
        ];
    }

    public function isCached(): bool
    {
        return $this->getCached() !== null;
    }

    /**
     * @return array{desktop: object, mobile: object}
     */
    public function fetchAndCache(string $url, bool $screenshot = false): array
    {
        $encodedUrl = rawurlencode($url);
        $lastError = 'Unknown PageSpeed error';

        for ($attempt = 1; $attempt <= self::MAX_RETRIES; $attempt++) {
            try {
                $results = $this->fetchParallel($encodedUrl, $screenshot);

                Session::put(self::SESSION_DESKTOP, json_encode($results['desktop']));
                Session::put(self::SESSION_MOBILE, json_encode($results['mobile']));

                return $results;
            } catch (\Throwable $e) {
                $lastError = $e->getMessage();
                Log::warning("PageSpeed fetch attempt {$attempt}/" . self::MAX_RETRIES . " failed for {$url}: {$lastError}");

                if ($attempt < self::MAX_RETRIES) {
                    sleep(min(5 * $attempt, 15));
                }
            }
        }

        throw new \RuntimeException($lastError);
    }

    /**
     * @return array{desktop: object, mobile: object}
     */
    private function fetchParallel(string $encodedUrl, bool $screenshot): array
    {
        $screenshotParam = $screenshot ? '&screenshot=true' : '';
        $baseUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . $encodedUrl
            . $screenshotParam
            . '&category=performance&category=best-practices&category=accessibility&category=seo&key=' . self::API_KEY;

        $handles = [
            'desktop' => $this->initCurlHandle($baseUrl . '&strategy=desktop'),
            'mobile' => $this->initCurlHandle($baseUrl . '&strategy=mobile'),
        ];

        $multiHandle = curl_multi_init();

        foreach ($handles as $handle) {
            curl_multi_add_handle($multiHandle, $handle);
        }

        $running = null;

        do {
            $status = curl_multi_exec($multiHandle, $running);

            if ($running > 0) {
                curl_multi_select($multiHandle, 1.0);
            }
        } while ($running > 0 && $status === CURLM_OK);

        $results = [];
        $errors = [];

        foreach ($handles as $strategy => $handle) {
            $response = curl_multi_getcontent($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $curlError = curl_error($handle);

            curl_multi_remove_handle($multiHandle, $handle);
            curl_close($handle);

            if ($response === false || $response === '') {
                $errors[] = "{$strategy}: cURL error - {$curlError}";
                continue;
            }

            if ($httpCode !== 200) {
                $errors[] = "{$strategy}: HTTP {$httpCode}";
                continue;
            }

            $decoded = json_decode($response);

            if (! $decoded || ! isset($decoded->lighthouseResult)) {
                $errors[] = "{$strategy}: lighthouse result missing";
                continue;
            }

            $results[$strategy] = $decoded;
        }

        curl_multi_close($multiHandle);

        if (! isset($results['desktop'], $results['mobile'])) {
            throw new \RuntimeException('PageSpeed API failed: ' . implode('; ', $errors));
        }

        return $results;
    }

    /**
     * @return resource
     */
    private function initCurlHandle(string $url)
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_TIMEOUT, self::REQUEST_TIMEOUT);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

        return $handle;
    }
}
