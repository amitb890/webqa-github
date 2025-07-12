<?php
namespace App\Http;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client as GuzzleClient;
use DOMDocument;
use Illuminate\Support\Str;
use Exception;
use DOMXPath;
use GuzzleHttp\Promise\Utils; // Import Utils for Guzzle 7
use App\Models\projectSettings;
use App\Models\SettingsSub;

ini_set('max_execution_time', 180000);
// Global variables to track broken link status and count
$isBrokenLinkPresent = false;
$totalBrokenLinks = 0;

class Helpers{
    function strStart($string, $startStr){
        $l = strlen($startStr);
        return (substr($string, 0, $l) === $startStr);
    }


    function getAbsoluteImageUrl($pageUrl,$imgSrc){
        $imgInfo = parse_url($imgSrc);
        if (!empty($imgInfo['host'])) {
            //img src is already an absolute URL
            if (substr($imgSrc,0,2) == '//') {
                return (parse_url($pageUrl)['scheme'] ?? "http") . ":" . $imgSrc;
            } else {
                return $imgSrc;
            }
        }
        else {
            $urlInfo = parse_url($pageUrl);
            $base = $urlInfo['scheme'].'://'.$urlInfo['host'];
            $path = isset($urlInfo['path']) ? $urlInfo['path'] : '';
            if (substr($imgSrc,0,1) == '/') {
                //img src is relative from the root URL
                return $base . $imgSrc;
            }
            else {
                //img src is relative from the current directory
                return
                        $base
                        . substr($path,0,strrpos($path,'/'))
                        . '/' . $imgSrc;
            }
        }
    }   

    
    public static function hasUppercase($str){
        return preg_match('/[A-Z]/', $str);
    }
    
    public static function hasNumbers($str){
        return preg_match('/\d/', $str);
    }

    public static function hasSpecial($str){
        return preg_match('/[!@#$%^&*()_+\=\[\]{};:"\\|,.<>\+?]+/', $str);
    }


    // doesnt include ('.') as special char
    public static function hasSpecialImages($str){
        return preg_match('/[!@#$%^&*()_+\=\[\]{};:"\\|,<>\+?]+/', $str);
    }

    public function getAbsolutePath($href, $domain){
        if($this->isBaseSixtyFour($href)){
            return $href;
        }
        $hrefNew = "";
        if($this->strStart($href, "/") || filter_var(substr($href, 0, 4) == "http")){
            $hrefNew = $this->getAbsoluteImageUrl($domain,$href);
        }else if(filter_var(substr($href, 0, 3) == "../")){
            $url_link = substr($domain, 0, strrpos( $domain, '/'));
            $link = substr($href, 2);
            $hrefNew = $url_link . $link;
        }else{
            if(filter_var(substr($href, 0, 3) != "tel" && $href != "javascript:void(0)")){
                $hrefNew = $domain . "/" . $href;
            }
        }
        return rtrim($hrefNew, "/");
    }

    function isBaseSixtyFour($data){
        if (str_contains($data, "base64")){
            return true;
        }
        return false;
    }


    function isUrl($value){
        return preg_match("/(http|https):\/\/[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&=]*)/i", $value);
    }

    function isLinkSameAsOrigin($url, $origin){
        if(str_contains($url, $origin)){
            return true;
        }

        return false;
    }

    function getAllHTTPCodes(){
        return $httpStatusNames = [
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            208 => 'Already Reported',
            226 => 'IM Used',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Switch Proxy',
            307 => 'Temporary Redirect',
            308 => 'Permanent Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Payload Too Large',
            414 => 'URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => "I'm a teapot",
            421 => 'Misdirected Request',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Too Early',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            451 => 'Unavailable For Legal Reasons',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            510 => 'Not Extended',
            511 => 'Network Authentication Required',
        ];
    }


    function getHttpStatusName($statusCode) {
        $httpStatusNames = $this->getAllHTTPCodes();
    
        return $httpStatusNames[$statusCode] ?? 'Unknown Status Code';
    }

    function getFavicon($url){
        try {
            $client = new Client(HttpClient::create(['timeout' => 60]));
            $crawler = $client->request('GET', $url);
            $statusCode = $client->getResponse()->getStatusCode();
    
            if (!in_array($statusCode, [200])) {
                return "";
            }
    
            // Find all <link> tags with icon-related rel attributes
            $icons = $crawler->filter("link[rel*='icon']")->each(function ($node) use ($url) {
                $href = $node->attr('href');
                if (!$href) return null;
    
                // Convert relative URLs to absolute
                return filter_var($href, FILTER_VALIDATE_URL) ? $href : rtrim($url, '/') . '/' . ltrim($href, '/');
            });
    
            // Remove nulls and duplicates
            $icons = array_unique(array_filter($icons));
    
            // Try fetching each icon until one returns a valid image
            foreach ($icons as $iconUrl) {
                $headers = @get_headers($iconUrl, 1);
                if ($headers && strpos($headers[0], '200') !== false) {
                    // Check if it's an image
                    if (isset($headers['Content-Type']) && str_starts_with($headers['Content-Type'], 'image')) {
                        return $iconUrl;
                    }
                }
            }
    
            // Fallback: Try /favicon.ico
            $faviconFallback = rtrim($url, '/') . '/favicon.ico';
            $headers = @get_headers($faviconFallback, 1);

            if ($headers && strpos($headers[0], '200') !== false &&
                isset($headers['Content-Type']) &&
                str_starts_with($headers['Content-Type'], 'image')) {
                return $faviconFallback;
            }
    
            return "";
    
        } catch (Exception $e) {
            return "";
        }
    }


    function normalizeFaviconUrl($faviconUrl, $baseUrl) {
        // Remove extra spaces
        $faviconUrl = trim(str_replace(' ', '', $faviconUrl));
    
        // If it's a relative URL
        if (strpos($faviconUrl, '//') === 0) {
            $faviconUrl = 'https:' . $faviconUrl;
        } elseif (parse_url($faviconUrl, PHP_URL_SCHEME) === null) {
            // Relative path — prepend domain
            $parsedBase = parse_url($baseUrl);
            $scheme = $parsedBase['scheme'] ?? 'https';
            $host = $parsedBase['host'] ?? '';
            $faviconUrl = $scheme . '://' . $host . '/' . ltrim($faviconUrl, '/');
        }
    
        return $faviconUrl;
    }

    
    function isValidUrl($url){
        // first do some quick sanity checks:
        if(!$url || !is_string($url)){
            return false;
        }
        // quick check url is roughly a valid http request: ( http://blah/... ) 
        if( ! preg_match('/^http(s)?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(\/.*)?$/i', $url) ){
            return false;
        }
        // the next bit could be slow:
        if($this->getHttpResponseCode_using_curl($url) != 200 && $this->getHttpResponseCode_using_curl($url) != 301 && $this->getHttpResponseCode_using_curl($url) != 302){
//      if(getHttpResponseCode_using_getheaders($url) != 200){  // use this one if you cant use curl
            return false;
        }
        // all good!
        return true;
    }
    
    function getHttpResponseCode_using_curl($url, $followredirects = true){
        // returns int responsecode, or false (if url does not exist or connection timeout occurs)
        // NOTE: could potentially take up to 0-30 seconds , blocking further code execution (more or less depending on connection, target site, and local timeout settings))
        // if $followredirects == false: return the FIRST known httpcode (ignore redirects)
        // if $followredirects == true : return the LAST  known httpcode (when redirected)
        if(! $url || ! is_string($url)){
            return false;
        }
        $ch = @curl_init($url);
        if($ch === false){
            return false;
        }
        @curl_setopt($ch, CURLOPT_HEADER         ,true);    // we want headers
        @curl_setopt($ch, CURLOPT_NOBODY         ,true);    // dont need body
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER ,true);    // catch output (do NOT print!)
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            @curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        }else{
            @curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MyAppBot/1.0)');
        }
        if($followredirects){
            @curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,true);
            @curl_setopt($ch, CURLOPT_MAXREDIRS      ,10);  // fairly random number, but could prevent unwanted endless redirects with followlocation=true
        }else{
            @curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,false);
        }
//      @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,5);   // fairly random number (seconds)... but could prevent waiting forever to get a result
//      @curl_setopt($ch, CURLOPT_TIMEOUT        ,6);   // fairly random number (seconds)... but could prevent waiting forever to get a result
//      @curl_setopt($ch, CURLOPT_USERAGENT      ,"Mozilla/5.0 (Windows NT 6.0) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1");   // pretend we're a regular browser
        @curl_exec($ch);
        if(@curl_errno($ch)){   // should be 0
            @curl_close($ch);
            return false;
        }
        $code = @curl_getinfo($ch, CURLINFO_HTTP_CODE); // note: php.net documentation shows this returns a string, but really it returns an int
        @curl_close($ch);
        return $code;
    }
    
    function getHttpResponseCode_using_getheaders($url, $followredirects = true){
        // returns string responsecode, or false if no responsecode found in headers (or url does not exist)
        // NOTE: could potentially take up to 0-30 seconds , blocking further code execution (more or less depending on connection, target site, and local timeout settings))
        // if $followredirects == false: return the FIRST known httpcode (ignore redirects)
        // if $followredirects == true : return the LAST  known httpcode (when redirected)
        if(! $url || ! is_string($url)){
            return false;
        }
        $headers = @get_headers($url);
        if($headers && is_array($headers)){
            if($followredirects){
                // we want the last errorcode, reverse array so we start at the end:
                $headers = array_reverse($headers);
            }
            foreach($headers as $hline){
                // search for things like "HTTP/1.1 200 OK" , "HTTP/1.0 200 OK" , "HTTP/1.1 301 PERMANENTLY MOVED" , "HTTP/1.1 400 Not Found" , etc.
                // note that the exact syntax/version/output differs, so there is some string magic involved here
                if(preg_match('/^HTTP\/\S+\s+([1-9][0-9][0-9])\s+.*/', $hline, $matches) ){// "HTTP/*** ### ***"
                    $code = $matches[1];
                    return $code;
                }
            }
            // no HTTP/xxx found in headers:
            return false;
        }
        // no headers :
        return false;
    }
    
    function onlyHyphen($str) {
        $answer = false;
        $join = [" ", "_", "/"];
        for($i = 0;$i < count($join); $i++){
            $p = $join[$i];
            $splitStr = explode($p, $str);
            if(count($splitStr) > 1){
                $answer = false;
                break;
            }else{
                $answer = true;
            }
        }
        return $answer;
       
    }


    function char_count($str, $letter){
        $letter_Count = 0;
        for ($position = 0; $position < strlen($str); $position++){
            if(substr($str, $position, 1) == $letter) {
                $letter_Count += 1;
            }
        }
        return $letter_Count;
    }

    
    function onlySpaces($str){
        if(str_contains($str, "-")){
            $total = $this->char_count($str, "-");
            if($total > 1){
                return false;
            }else{
                $index = strpos($str, "-");
                if(substr($str, $index+1, 1) === " " && substr($str, $index-1, 1) === " "){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return true;
        }
    }


     // function returns gzip enabled(1|0)
    function IsGzip($url){
        // return 1 if enabled || 0 if not
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
        curl_setopt($ch, CURLOPT_HEADER, 1); // include headers in curl response
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            $agent = $_SERVER['HTTP_USER_AGENT'];
        }else{
            $agent = 'Mozilla/5.0 (compatible; MyAppBot/1.0)';
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate', // request gzip
            'Accept-Language: en-US,en;q=0.5',
            'Connection: keep-alive',
            'SomeBull: BeingIgnored',
            'User-Agent: ' . $agent
        )
        );
        $response = curl_exec($ch);
        
        if ($response === false) {
            return 3;   
        }
        
        $info = curl_getinfo($ch);
        
        for ($i = 0; $i <= $info['redirect_count']; ++$i) {
            // split request and headers into separate vars for as many times 
            // as there were redirects
            list($headers, $response) = explode("\r\n\r\n", $response, 2);
        }
        
        curl_close($ch);
        
        $headers = explode("\r\n", $headers); // split headers into one per line
        $hasGzip = 2;
        
        foreach($headers as $header) { // loop over each header
            if (stripos($header, 'Content-Encoding') !== false) { // look for a Content-Encoding header
                if (strpos($header, 'gzip') !== false) { // see if it contains gzip
                    $hasGzip = 1;
                }
            }
        }
        
        return $hasGzip;   
    }

    function delete_all_between($beginning, $end, $string) {
        $beginningPos = strpos($string, $beginning);
        $endPos = strpos($string, $end, $beginningPos);
        if ($beginningPos === false || $endPos === false) {
          return $string;
        }
      
        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
      
        return $this->delete_all_between($beginning, $end, str_replace($textToDelete, '', $string)); // recursion to ensure all occurrences are replaced
    }


    function doctypeExists($html){
        $status = true;
        return $status;
    }

    function convertBytesToKb($bytes){
        return number_format($bytes / 1024, 2);
    }
      
    function nestedTablesExist($array){
        if(count($array) < 1){
            return false;
        }
        foreach($array as $el){
            $el = $el;
            if(str_contains($el, '<table')){
                return true;
            }
        }

        return false;
    }

    function removeParams($url){
        return strtok($url, '?');
    }

    function isSVG($name){
        $imageExt = pathinfo($name, PATHINFO_EXTENSION);
        if($imageExt === "svg"){
            return true;
        }
        if(str_contains($name, "svg%")){
            return true;
        }
        if(str_contains($name, "svg+xml")){
            return true;
        }

        return false;
    }

    function formatSizeUnits($bytes){
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    function isHTMLCompressed($html){
        $status = true;
        $accepted_lines = 15;
        $htmlNew = htmlspecialchars($html);
        $htmlNew = $this->delete_all_between('&lt;script', '/script&gt;', $htmlNew);
        $htmlNew = $this->delete_all_between('&lt;style&gt;', '&lt;/style&gt;', $htmlNew);
        $htmlNew = $this->delete_all_between('&lt;!--', '--&gt;', $htmlNew);
        $htmlNew = $this->delete_all_between('&gt;&lt;style', '&lt;/style&gt;', $htmlNew);
        $lines = substr_count( $htmlNew, "\n" );
        if($lines > $accepted_lines){
            $status = false;
        }
        return $status;
    }


    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function file_get_contents_curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        }else{
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MyAppBot/1.0)');
        }
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }


    function checkSSLCertificate($websiteUrl) {
        $context = stream_context_create(["ssl" => ["capture_peer_cert" => true]]);
        $stream = stream_socket_client("ssl://$websiteUrl:443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);
        return $stream;
    }

    function badContentTypeTest($htmlBody) {
        // Create a DOM Crawler to parse the HTML content
        $crawler = new Crawler($htmlBody);

        // Find the HTML tag that contains the content type information
       return $contentTypeElement = $crawler->filter('meta[http-equiv="Content-Type"]');
    }

    function normalizeUrl($url){
        $parsedUrl = parse_url($url);

        // Default path to '/' if not set
        $path = isset($parsedUrl['path']) ? rtrim($parsedUrl['path'], '/') : '/';
        
        return strtolower($parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $path);
    }


    function checkMinificationMain($files, $type, $num, $domain, $hostname){
        // global $hostname;
        $unminified = array();
        $accepted_lines = 20;
        if(count($files) > 0){
            for($i = 0;$i < count($files); $i++){
                
                $file = $files[$i]["content"];
                if($file){
                    $file = $this->getAbsolutePath($file, $domain);
                    if(str_contains($file, "?")){
                        $file = substr($file, 0, strrpos( $file, '?'));
                    }

                    if(strpos($file, $hostname) !== false){
                        if($this->isValidUrl($file)){
                            $file = $file . "?=cacheburst=" . $this->generateRandomString(); 
                            $contents = $this->file_get_contents_curl($file);
                            $contents = $this->delete_all_between('/*', '*/', $contents);
                            // $contents = $this->delete_all_between('//', '', $contents);
                            $lines = substr_count( $contents, "\n" );
                            if($lines > $accepted_lines){
                                array_push($unminified, $file);
                            }
                        }
                    }
                }
            }
        }else{
            return $unminified;
        }
        return $unminified;
    }

    function checkMinification($files, $type, $num, $domain, $hostname){
        // global $hostname;
        $unminified = array();
        $accepted_lines = 20;
        if(count($files) > 0){
            for($i = 0;$i < count($files); $i++){
                
                $file = $files[$i];
                if($file){
                    $file = $this->getAbsolutePath($file, $domain);
                    if(str_contains($file, "?")){
                        $file = substr($file, 0, strrpos( $file, '?'));
                    }

                    if(strpos($file, $hostname) !== false){
                        if($this->isValidUrl($file)){
                            $file = $file . "?=cacheburst=" . $this->generateRandomString(); 
                            $contents = $this->file_get_contents_curl($file);
                            $contents = $this->delete_all_between('/*', '*/', $contents);
                            // $contents = $this->delete_all_between('//', '', $contents);
                            $lines = substr_count( $contents, "\n" );
                            if($lines > $accepted_lines){
                                array_push($unminified, $file);
                            }
                        }
                    }
                }
            }
        }else{
            return $unminified;
        }
        return $unminified;
    }


    public function cssCachingEnable($url, $html) {
        return $this->checkResourceCaching($url, $html, 'link[rel="stylesheet"]', 'href');
    }
    
    public function jsCachingEnable($url, $html) {
        return $this->checkResourceCaching($url, $html, 'script[src]', 'src');
    }

    public function checkResourceCaching($url, $html, $selector, $attribute) {
        $crawler = new Crawler($html);
    
        $resourceUrls = [];
        $urlCache = [];
    
        // Extract URLs based on selector and attribute
        $crawler->filter($selector)->each(function ($node) use (&$resourceUrls, $url, $attribute) {
            $resourceUrl = $node->attr($attribute);
            if (strpos($resourceUrl, 'http') !== 0) {
                $resourceUrl = rtrim($url, '/') . '/' . ltrim($resourceUrl, '/');
            }
            $resourceUrls[] = $resourceUrl;
        });
    
        // Remove duplicate URLs
        $resourceUrls = array_unique($resourceUrls);
        $reindexedUrls = array_values($resourceUrls);
        // Perform parallel HTTP requests to check caching
        $responses = Http::pool(fn ($pool) => array_map(fn ($resourceUrl) => $pool->head($resourceUrl), $resourceUrls));
    
        foreach ($reindexedUrls as $index => $resourceUrl) {
            $response = $responses[$index];
    
            if ($response->ok()) {
                $cacheControlHeader = $response->header('Cache-Control');
                $expiresHeader = $response->header('Expires');
    
                if ($cacheControlHeader || $expiresHeader) {
                    $expiresTimestamp = strtotime($expiresHeader);
                    $currentTimestamp = time();
                    $minutesRemaining = max(0, round(($expiresTimestamp - $currentTimestamp) / 60));
    
                    if ($minutesRemaining != 0) {
                        $urlCache[] = [
                            'url' => $resourceUrl,
                            'cacheExpiryTime' => $minutesRemaining,
                        ];
                    }
                }
            }
        }
    
        return $urlCache;
    }

    
   
    function checkUrlCaching($url) {
        $response = Http::head($url);
        $cacheControlHeader = $response->header('Cache-Control');
        $expiresHeader = $response->header('Expires');

        if ($cacheControlHeader || $expiresHeader) {
            $expiresTimestamp = strtotime($expiresHeader);
            $currentTimestamp = time();
            $minutesRemaining = max(0, round(($expiresTimestamp - $currentTimestamp) / 60));
            
            if($minutesRemaining != 0) {
                $urlData['url'] = $url;
                $urlData['cacheExpiryTime'] = $minutesRemaining;
                return $urlData;
            }
        } 
    }


    public function isUrlSafe($url)
    {
        // Your Google Safe Browsing API key
        $apiKey = 'AIzaSyCvrGVceLZi_X3v10gMqN4j9FHhqkjNeVk';

        // Google Safe Browsing API endpoint
        $apiEndpoint = 'https://safebrowsing.googleapis.com/v4/threatMatches:find';

        // Build the request payload
        $client = new GuzzleClient();
        $response = $client->post($apiEndpoint, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'query' => ['key' => $apiKey],
            'json' => [
                'client' => [
                    'clientId' => 'YourClientID',
                    'clientVersion' => '1.0.0',
                ],
                'threatInfo' => [
                    'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING', 'UNWANTED_SOFTWARE', 'POTENTIALLY_HARMFUL_APPLICATION'],
                    'platformTypes' => ['ANY_PLATFORM'],
                    'threatEntryTypes' => ['URL'],
                    'threatEntries' => [
                        ['url' => $url],
                    ],
                ],
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        // Check if the response indicates a safe URL
        return empty($data['matches']);
    }

    public function crossOriginLinks($url, $html)
    {
        // Parse HTML content
        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_use_internal_errors(false);

        // Extract and analyze links
        $links = $dom->getElementsByTagName('a');
        $unsafeLinks = [];
        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            $rel = $link->getAttribute('rel');
            $target = $link->getAttribute('target');

            // Check for unsafe cross-origin links
            if (filter_var($href, FILTER_VALIDATE_URL) && ($rel !== 'noopener noreferrer' && $rel !== 'noreferrer noopener' && $rel !== 'noopener' && $rel !== 'noreferrer' ) && $target === '_blank') {
                // Perform additional checks if needed
                // For simplicity, we'll just log the unsafe link for now
                $unsafeLinks[] = $href;
            }
        }
        return $unsafeLinks;

    }
    
    public function protocolRelativeResource($url, $html)
    {
     
       // Use a regular expression to find protocol-relative links
       $pattern = '/(href|src)=["\']\/\/[^"\'>]+["\']/';
       preg_match_all($pattern, $html, $matches);
   
       // $matches[0] contains an array of protocol-relative links
      return $protocolRelativeLinks = $matches[0];

    }
    public function h1HeadindTag($url, $html)
    {
        $crawler = new Crawler($html);
        // Extract content from H1, H2, H3, H4, H5, and H6 tags
        $headingContent = [];

        for ($i = 1; $i <= 6; $i++) {
            $tagName = 'h' . $i;
            $headingContent[$tagName] = $crawler->filter($tagName)->each(function ($node) {
                return $node->text();
            });
        }
        return $headingContent;

    }

    public function robotTextTtest($url)
    {
        $parsed_url = parse_url($url);

        // Construct the base URL
        $base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        $robotsTxtUrl = $base_url . '/robots.txt';
        $httpResponse = $this->httpGetContent($robotsTxtUrl);
        // Check the HTTP status code
        $statusCode = $httpResponse->status();

        if ($statusCode != 200) {
            return [[], false, false];
        }

        // Create a Guzzle client
        $client = new GuzzleClient();

        // Make a GET request to the robots.txt URL
        $response = $client->request('GET', $robotsTxtUrl);

        // Get the content of the robots.txt file
        $robotsTxtContent = $response->getBody()->getContents();
        $urlArray = $this->parseRobotsTxt($robotsTxtContent);
        // Check if the URL is allowed based on the robots.txt rules
        return $isUrlAllowed = $this->isUrlAllowedByRobotsTxt($url, $robotsTxtContent, $urlArray);

    }

    // Function to parse the robots.txt and return an array of disallow paths user-agent wise
    public function parseRobotsTxt($robotsTxt) {
    $lines = explode("\n", $robotsTxt);
    $userAgents = [];
    $currentAgent = '';

    foreach ($lines as $line) {
        $line = trim($line);

        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }

        if (strpos(strtolower($line) , 'user-agent:') === 0) {
            $currentAgent = trim(str_replace('user-agent:', '', strtolower($line)));
            // dd($currentAgent);
            if (!isset($userAgents[$currentAgent])) {
                $userAgents[$currentAgent] = [];
            }
        } elseif (strpos($line, 'Disallow:') === 0) {
            $disallowPath = trim(str_replace('Disallow:', '', $line));
            if ($currentAgent) {
                $userAgents[$currentAgent][] = $disallowPath;
            }
        }
    }
    return $userAgents;
}


private function checkUserAgent($urlArray, $url, $type, $secondaryBlockedUserAgentRes)
{
    $searchString = $url;
    $matchingKey = null;
    foreach ($urlArray as $key => $values) {
        if (in_array($searchString, $values) && !in_array($key, $secondaryBlockedUserAgentRes)) {
            $matchingKey = $key;
            break;
        }
    }
     
    if ($matchingKey !== null) {
        return $matchingKey;
    } else {
        return "";
    }
}
    private function isUrlAllowedByRobotsTxt($url, $robotsTxtContent, $urlArray)
    {
        $status = true;
        // Parse the URL
        $parsed_url = parse_url($url);

        // Construct the base URL
        $base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        $compareString = str_replace($base_url, '', $url);
        // Parse the robots.txt content
        $lines = explode("\n", $robotsTxtContent);
        $disallowedPathArray = [];
        $blockedUserAgent = [];
        $userAgents = [
            'googlebot',
            'bingbot',
            'slurp',
            'duckduckbot',
            'baiduspider',
            'yandexbot',

            '*'
        ];
        $blockedUserAgentRes = [];
        $secondaryBlockedUserAgentRes = [];
        // dd($lines);
        foreach ($lines as $key=>$line) {
            // Check for "Disallow" rules
            $disallowedPathArray[$key] = $line;
            $line = trim(str_replace(' ', '', $line));
            if (strpos($line, 'Disallow:') === 0) {
                $disallowedPath = trim(str_replace('Disallow:', '', $line));
                $disallowedPathUrl = trim(str_replace('Disallow:', '', $line));
                
                if (strpos($disallowedPath, '*') !== false) {
                    $disallowedPathCommon = str_replace(' *', '', $disallowedPath);
                    $disallowedPathCommon = str_replace('*', '', $disallowedPath);
                    $disallowedPathCommon = str_replace('/*/*,*,*', '', $disallowedPathCommon);
                    if (strpos($compareString, $disallowedPathCommon) === 0) {
                         $blockedUserAgent = $this->checkUserAgent($urlArray, $disallowedPath, 'wild');
                        if(in_array($blockedUserAgent, $userAgents)) {
                            
                            $status = false;
                            $blockedUserAgentRes[] = $blockedUserAgent;
                        } else {
                            $secondaryBlockedUserAgentRes[] = $blockedUserAgent;
                        }

                        $disallowedPathArray[$key] = '<span style="color:red">'.$line.'</span>';
                    }
                }

                if (rtrim($disallowedPath, '/') == $disallowedPath) {
                    $disallowedPath = $disallowedPath . '/';
                }

                if (rtrim($compareString, '/') == $compareString) {
                    $compareString = $compareString . '/';
                }
                if (strpos($compareString, $disallowedPath) === 0) {
                    $blockedUserAgent = $this->checkUserAgent($urlArray, $disallowedPathUrl, 'normal', $secondaryBlockedUserAgentRes);
                    
                    if(in_array($blockedUserAgent, $userAgents)) {
                        $blockedUserAgentRes[] = $blockedUserAgent;
                        
                        $status = false;
                    } else {
                        $secondaryBlockedUserAgentRes[] = $blockedUserAgent;
                    }
                    $disallowedPathArray[$key] = '<span style="color:red">'.$line.'</span>';
                }
            }
        }

    if($status == true) {
        $blockedUserAgentRes = $userAgents;
      }
    //   dd($secondaryBlockedUserAgentRes);
     $blockedUserAgentRes = $this->convertUserAgent($blockedUserAgentRes);
        return [$disallowedPathArray, $status, true, $blockedUserAgentRes, $secondaryBlockedUserAgentRes];
    }

    public function convertUserAgent($userAgents)
    {
    
        
        $replacementMap = [
            '*' => 'all search engines',
            'googlebot' => 'Google',
            'bingbot' => 'Bing',
            'slurp' => 'Yahoo',
            'baiduspider' => 'Baidu',
            'yandexbot' => 'Yandex',
             'duckduckbot' => 'DuckDuckGo'
   
           
        ];
        $userAgentArray = [];
        foreach ($userAgents as &$userAgent) {
            if (array_key_exists($userAgent, $replacementMap)) {
                $userAgentArray[] = $replacementMap[$userAgent];
            }
        }
        return $userAgentArray;
        
    }

    function getTest($meta){
        $obj = [
            "frameset" => "",
            "title" => "",
            "viewport" => "",
            "description" => "",
            "viewport" => "",
            "canonical" => "",
            "robots" => "",
            "og:title" => "",
            "og:description" => "",
            "og:url" => "",
            "og:type" => "",
            "og:image" => "",
            "twitter:title" => "",
            "twitter:description" => "",
            "twitter:url" => "",
            "twitter:image" => "",
            "twitter:image:alt" => "",
            "icon" => "",
            "links" => [],
            "images" => [],
            "script" => [],
            "stylesheet" => [],
            "table" => [],
        ];
        foreach ($meta as $key => $value) {
            $name = $value["name"];
            $content = $value["content"];

            if($name === "a"){
                array_push($obj["links"], $content);
            }else if($name === "img"){
                array_push($obj["images"], $content);
            }else if($name === "script"){
                array_push($obj["script"], $content);
            }else if($name === "stylesheet"){
                array_push($obj["stylesheet"], $content);
            }else if($name === "table"){
                array_push($obj["table"], $content);
            }else{
                if(isset($obj[$name])){
                    $obj[$name] = $content;
                }
            }
        }

        return $obj;
    }

    

    function getGoogleCWVColorByScore($score, $type){
        $color = "";

        switch($type){
            case "lcp":
                if($score >= 90){
                    $color = "success";
                }else if($score >= 50 && $score < 90){
                    $color = "orange";
                }else{
                    $color = "danger";
                }
                break;
            case "lcp":
                if($score >= 90){
                    $color = "success";
                }else if($score >= 50 && $score < 90){
                    $color = "orange";
                }else{
                    $color = "danger";
                }
                break;
            case "lcp":
                if($score >= 90){
                    $color = "success";
                }else if($score >= 50 && $score < 90){
                    $color = "orange";
                }else{
                    $color = "danger";
                }
                break;
            case "lcp":
                if($score >= 90){
                    $color = "success";
                }else if($score >= 50 && $score < 90){
                    $color = "orange";
                }else{
                    $color = "danger";
                }
                break;
            case "lcp":
                if($score >= 90){
                    $color = "success";
                }else if($score >= 50 && $score < 90){
                    $color = "orange";
                }else{
                    $color = "danger";
                }
                break;
            case "lcp":
                if($score >= 90){
                    $color = "success";
                }else if($score >= 50 && $score < 90){
                    $color = "orange";
                }else{
                    $color = "danger";
                }
                break;
            case "lcp":
                if($score >= 90){
                    $color = "success";
                }else if($score >= 50 && $score < 90){
                    $color = "orange";
                }else{
                    $color = "danger";
                }
                break;
            case "lcp":
                if($score >= 90){
                    $color = "success";
                }else if($score >= 50 && $score < 90){
                    $color = "orange";
                }else{
                    $color = "danger";
                }
                break;
        }


        return $color;
    }

    function getGoogleInsightsColorByScore($score){
        $color = "";
        if($score >= 90){
            $color = "success";
        }else if($score >= 50 && $score < 90){
            $color = "orange";
        }else{
            $color = "danger";
        }

        return $color;
    }


    function getSingleLabel($labels, $dbName){
        $finalLabels = [];
        for($i = 0;$i < count($labels);$i++){
            $label = $labels[$i];
            if($dbName === "security_labels"){
                if($label->dashboard_parent === "security_labels"){
                    array_push($finalLabels, $label);
                }
            }else if($dbName === "cbp_labels"){
                if($label->dashboard_parent === "cbp_labels"){
                    array_push($finalLabels, $label);
                }
            }else{
                if($label->db_name === $dbName){
                    array_push($finalLabels, $label);
                    break;
                }
            }
        }

        return $finalLabels;
    }

    
    function httpGetContent($url) {
        //    return $response = Http::get($url);
       return    $response = Http::withHeaders([
            'Cache-Control' => 'no-cache',
            'Pragma' => 'no-cache',
        ])->get($url);
    }

    public function filterValidUrls(array $urls)
{
    $validUrls = [];

    foreach ($urls as $url) {
        // Filter out invalid mailto and tel URLs
        if (Str::startsWith($url, ['mailto:', 'tel:'])) {
            continue;
        }

        // Remove fragment (anything after #) to handle duplicates like https://example.com/#terms and https://example.com/#privacy
        $urlWithoutFragment = preg_replace('/#.*$/', '', $url);

        // Only add unique, non-empty URLs
        if (!empty($urlWithoutFragment) && !in_array($urlWithoutFragment, $validUrls)) {
            $validUrls[] = $urlWithoutFragment;
        }
    }

    return $validUrls;
}


public function getContentType($response)
    {
        $contentType = $response->getHeader('Content-Type');
        if (empty($contentType)) {
            return 'Unknown';
        }

        // Check for 'text/html' content type to determine if it's an HTML page
        if (Str::contains($contentType[0], 'text/html')) {
            return 'HTML';
        }

        return 'Other';
    }

public function isExternal(string $url, string $domain)
{
    // $host = parse_url($url, PHP_URL_HOST);
    // return $host && $host !== $domain;
    if(str_contains($url, $domain)){
        return false;
    }

    return true;
}


function removeQueryParams($url) {
    $parsedUrl = parse_url($url);

    // Rebuild the URL without the query string
    $cleanUrl = (isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '') .
                (isset($parsedUrl['host']) ? $parsedUrl['host'] : '') .
                (isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '') .
                (isset($parsedUrl['path']) ? $parsedUrl['path'] : '');

    echo $cleanUrl;

    return $cleanUrl;
}


    public function brokenLinks($url){
        global $isBrokenLinkPresent, $totalBrokenLinks; // Access global variables

        // List of file extensions to ignore
        $ignoredExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar', 'exe', 'mp3', 'mp4', 'avi', 'mov', 'ppt', 'pptx'];

        // List of keywords in URLs that indicate a download link
        $ignoredKeywords = ['download', 'client', 'setup', 'installer', 'x.com', 'twitter'];

        $client = new GuzzleClient(['timeout' => 10]);
        $results = [];

        try {
            $response = $client->get($url);
            $html = $response->getBody()->getContents();
        } catch (Exception $e) {
            return json_encode(['status' => 0, 
            'error' => 'Could not fetch the URL: ' . $e->getMessage(),   
            'isBrokenLinkPresent' => 0,
            'totalBrokenLinks' => 0]);
        }

        $crawler = new Crawler($html);

        $links = $crawler->filter('a[href]')->each(function (Crawler $node) {
            return $node->attr('href');
        });


        $resources = array_merge($links);

        // Remove duplicates and invalid URLs
        $resources = $this->filterValidUrls($resources);
        $promises = [];

        $parsedBaseUrl = parse_url($url);
        $baseDomain = $parsedBaseUrl['scheme'] . '://' . $parsedBaseUrl['host'];
        
        foreach ($resources as $resource) {
            
            // Skip ignored file types
            $extension = pathinfo(parse_url($resource, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (in_array(strtolower($extension), $ignoredExtensions)) {
                continue;
            }
    
            // Skip URLs containing ignored keywords
            foreach ($ignoredKeywords as $keyword) {
                if (stripos($resource, $keyword) !== false) {
                    continue 2; // Skip this URL
                }
            }
    

        // Resolve relative URLs correctly to avoid duplication issues
            $absoluteUrl = parse_url($resource, PHP_URL_SCHEME) === null
                ? rtrim($baseDomain, '/') . '/' . ltrim($resource, '/')
                : $resource;

            // Normalize the URL to avoid duplication issues
            $absoluteUrl = preg_replace('/([^:])(\/\/+)/', '$1/', $absoluteUrl);

            $host = "setmore.com";
            $isExternal = $this->isExternal($absoluteUrl, $host);

            $promises[$absoluteUrl] = $client->headAsync($absoluteUrl)
                ->then(
                    function ($response) use ($absoluteUrl, $isExternal) {
                        if($response->getStatusCode() != 200 && $response->getStatusCode() != 0 && $response->getStatusCode() != 405){
                            $isBrokenLinkPresent = true;
                            $totalBrokenLinks++;
                        }
                        return ['url' => $absoluteUrl, 'status' => $response->getStatusCode(), 'msg' => "success", 'is_external' => $isExternal];
                    },
                    function ($exception) use ($client, $absoluteUrl, $isExternal) {
                        global $isBrokenLinkPresent, $totalBrokenLinks; // Access global variables

                        // If HEAD request fails with 403, retry with GET
                        if ($exception->getCode() === 403) {
                            try {
                                $response = $client->get($absoluteUrl);
                                return ['url' => $absoluteUrl, 'status' => $response->getCode(), 'msg' => "success", 'is_external' => $isExternal];

                            } catch (Exception $e) {
                                $isBrokenLinkPresent = true;
                                $totalBrokenLinks++;
                                return ['url' => $absoluteUrl, 'status' => $exception->getCode(), 'msg' => 'Broken (' . $exception->getMessage() . ')', 'is_external' => $isExternal];
                            }
                        }
                        // Update global variables for broken links
                        if($exception->getCode() != 200 && $exception->getCode() != 0 && $exception->getCode() != 405){
                            $isBrokenLinkPresent = true;
                            $totalBrokenLinks++;
                        }

                        return ['url' => $absoluteUrl, 'status' => $exception->getCode(), 'msg' => 'Broken (' . $exception->getMessage() . ')', 'is_external' => $isExternal];
                    }
                );
        }

        // Use Utils::settle to resolve promises
        $settledPromises = Utils::settle($promises)->wait();


        return json_encode([
            'status' => 1, 
            'results' => $settledPromises,
            'isBrokenLinkPresent' => $isBrokenLinkPresent,
            'totalBrokenLinks' => $totalBrokenLinks
        ], JSON_PRETTY_PRINT);
    }

    // function getActiveLabels($labels, $project_id){
    //     $final_labels = [];
    //     $settings_labels = projectSettings::where("projects_id", $project_id)->get()->first();
    //     foreach ($settings_labels->toArray() as $key => $value) {
    //         foreach($labels as $label){
    //             if($label->db_name === $key){
    //                 if($value === 1){
    //                     array_push($final_labels, $label);
    //                 }
    //             }
    //         }
    //     }

    //     return $final_labels;
    // }


    function getAllTests(){
        $performance = array (
            0 => 
            array (
                'displayName' => 'Overall Score',
                'name' => 'page_speed_google',
                'dbName' => 'google_overall',
                'url' => '/test/google-page-speed-insights',
                'slug' => 'google-page-speed-insights',
                'route' => 'tool/google-page-speed-insights',
                'main_heading' => 'Google Page Speed - Overall Score Test',
                'main_para' => 'Test multiple URLs for Google Page speed overall score. Download scores in CSV or PDF file.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            1 => 
            array (
                'displayName' => 'Lighthouse Score',
                'name' => 'page_speed_google_lighthouse',
                'dbName' => 'google_lighthouse',
                'url' => '/test/google-page-speed-lighthouse',
                'slug' => 'google-lighthouse',
                'route' => 'tool/google-lighthouse',
                'main_heading' => 'Lighthouse Test',
                'main_para' => 'Test multiple URLs for Lighthouse scores and Download them in CSV or PDF file format.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            2 => 
            array (
                'displayName' => 'Core Web Vitals',
                'name' => 'page_speed_google_core',
                'dbName' => 'core_web_vitals',
                'url' => '/test/google-page-speed-core-web-vitals',
                'slug' => 'google-core-web-vitals',
                'route' => 'tool/google-core-web-vitals',
                'main_heading' => 'Core Web Vitals Test',
                'main_para' => 'Test multiple URLs for Core web vitals score and Download them in CSV or PDF file format.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            3 => 
            array (
                'displayName' => 'Mobile Friendliness',
                'name' => 'mobile_friendly',
                'dbName' => 'mobile_friendly',
                'url' => '/test/mobile-friendly',
                'slug' => 'mobile-friendliness',
                'route' => 'tool/mobile-friendliness',
                'main_heading' => 'Mobile Friendliness',
                'main_para' => 'Test multiple URLs for Core web vitals score and Download them in CSV or PDF file format.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
        );

        $images = array (
            0 => 
            array (
                'displayName' => 'Images',
                'name' => 'img',
                'dbName' => 'images',
                'url' => '/test/images',
                'slug' => 'images',
                'route' => 'tool/images',
                'main_heading' => 'Images Test',
                'main_para' => 'Test multiple URLs for Images used in those URLs. Test Image alternate text, file size, file name and download the data in PDF or CSV Formats.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            )
        );


        $best_practices = array (
            0 => 
            array (
                'displayName' => 'HTML Compression',
                'name' => 'compression',
                'dbName' => 'html_compression',
                'url' => '/test/html-compression',
                'slug' => 'html-compression',
                'route' => 'tool/html-compression',
                'main_heading' => 'HTML Compression Test',
                'main_para' => 'Test multiple urls for HTML Compression. Check which of your website pages do not have HTML compression enabled.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            1 => 
            array (
                'displayName' => 'CSS Compression',
                'name' => 'stylesheet',
                'dbName' => 'css_compression',
                'url' => '/test/css-compression',
                'slug' => 'css-compression',
                'route' => 'tool/css-compression',
                'main_heading' => 'CSS Compression Test',
                'main_para' => 'Test multiple urls CSS Compression. Check which of your website CSS files do not have compression enabled.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            2 => 
            array (
                'displayName' => 'JS Compression',
                'name' => 'script',
                'dbName' => 'js_compression',
                'url' => '/test/js-compression',
                'slug' => 'js-compression',
                'route' => 'tool/js-compression',
                'main_heading' => 'JS Compression Test',
                'main_para' => 'Test multiple website urls for JS Compression. Check which of your Javascript files do not have compression enabled.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            3 => 
            array (
                'displayName' => 'GZIP Compression',
                'name' => 'gzip_compression',
                'dbName' => 'gzip_compression',
                'url' => '/test/gzip-compression',
                'slug' => 'gzip-compression',
                'route' => 'tool/gzip-compression',
                'main_heading' => 'Gzip Compression Test',
                'main_para' => 'Test your website pages for Gzip compression and see which one of them do not have Gzip compression enabled.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            4 => 
            array (
                'displayName' => 'Nested Tables',
                'name' => 'nestedtables',
                'dbName' => 'nested_tables',
                'url' => '/test/nested-tables',
                'slug' => 'nested-tables',
                'route' => 'tool/nested-tables',
                'main_heading' => 'Nested Tables Test',
                'main_para' => 'Test your website pages for Meta title tag content. Check meta title length, whether it is equal to H1 tag, and check what casing the title tag follows.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),
            5 => 
            array (
                'displayName' => 'Frameset',
                'name' => 'frameset',
                'dbName' => 'frameset',
                'url' => '/test/frameset',
                'slug' => 'frameset',
                'route' => 'tool/frameset',
                'main_heading' => 'Frameset Test',
                'main_para' => 'Test your website pages for Meta title tag content. Check meta title length, whether it is equal to H1 tag, and check what casing the title tag follows.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),
            6 => 
            array (
                'displayName' => 'Page Size',
                'name' => 'pagesize',
                'dbName' => 'page_size',
                'url' => '/test/page-size',
                'slug' => 'page-size',
                'route' => 'tool/page-size',
                'main_heading' => 'Page Size Test',
                'main_para' => 'Test your website pages for Meta title tag content. Check meta title length, whether it is equal to H1 tag, and check what casing the title tag follows.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            7 => 
            array (
                'displayName' => 'CSS caching',
                'name' => 'css_caching_enable',
                'dbName' => 'css_caching_enable',
                'url' => '/test/css-caching-enable',
                'slug' => 'css-caching-test',
                'route' => 'tool/css-caching-test',
                'main_heading' => 'CSS Caching Test',
                'main_para' => 'CSS Caching Test',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),

            8 => 
            array (
                'displayName' => 'JS caching',
                'name' => 'js_caching_enable',
                'dbName' => 'js_caching_enable',
                'url' => '/test/js-caching-enable',
                'slug' => 'js-caching-test',
                'route' => 'tool/js-caching-test',
                'main_heading' => 'JS Caching Test',
                'main_para' => 'JS Caching Test',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            9 => 
            array (
                'displayName' => 'Broken Links',
                'name' => 'broken_links',
                'dbName' => 'broken_links',
                'url' => '/test/broken-links',
                'slug' => 'broken-links',
                'route' => 'tool/broken-links',
                'main_heading' => 'Broken Links',
                'main_para' => 'Broken Links',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            
        );


        $security = array (
            1 => 
            array (
                'displayName' => 'X Frame Options Header',
                'name' => 'xframe',
                'dbName' => 'x_frame_options_header',
                'url' => '/test/x-frame-options-header',
                'slug' => 'x-frame-options-header-test',
                'route' => 'tool/x-frame-options-header-test',
                'main_heading' => 'X Frame Options Header',
                'main_para' => 'Test your website pages for Meta title tag content. Check meta title length, whether it is equal to H1 tag, and check what casing the title tag follows.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),
            2 => 
            array (
                'displayName' => 'Content Security Policy Header',
                'name' => 'content-security',
                'dbName' => 'content_security_policy_header',
                'url' => '/test/content-security-policy-header',
                'slug' => 'content-security-policy-header-test',
                'route' => 'tool/content-security-policy-header-test',
                'main_heading' => 'Content Security Policy Header',
                'main_para' => 'Test your website pages for Meta title tag content. Check meta title length, whether it is equal to H1 tag, and check what casing the title tag follows.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),
            3 => 
            array (
                'displayName' => 'Hsts Header',
                'name' => 'hsts',
                'dbName' => 'hsts_header',
                'url' => '/test/hsts-header',
                'slug' => 'hsts-header-test',
                'route' => 'tool/hsts-header-test',
                'main_heading' => 'Hsts Header Test',
                'main_para' => 'Test your website pages for Meta title tag content. Check meta title length, whether it is equal to H1 tag, and check what casing the title tag follows.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),
            4 => 
            array (
                'displayName' => 'Safe Browsing',
                'name' => 'safe-browsing',
                'dbName' => 'is_safe_browsing',
                'url' => '/test/safe-browsing',
                'slug' => 'safe-browsing-test',
                'route' => 'tool/safe-browsing-test',
                'main_heading' => 'Safe Browsing',
                'main_para' => 'safe-browsing Content',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),
            5 => 
            array (
                'displayName' => 'Protocall relative resource links',
                'name' => 'protocall-relative-resource-links',
                'dbName' => 'protocol_relative_resource',
                'url' => '/test/protocol-relative-resource',
                'slug' => 'protocall-relative-resource-links-test',
                'route' => 'tool/protocall-relative-resource-links-test',
                'main_heading' => 'Protocall relative resource links',
                'main_para' => 'Protocall relative resource links',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),
            6 => 
            array (
                'displayName' => 'Unsafe Cross Origin Links',
                'name' => 'cross-origin-links',
                'dbName' => 'cross_origin_links',
                'url' => '/test/cross-origin-links',
                'slug' => 'unsafe-cross-origin-links-test',
                'route' => 'tool/unsafe-cross-origin-links-test',
                'main_heading' => 'Unsafe Cross Origin Links',
                'main_para' => 'cross-origin-links Content',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),
            7 => 
            array (
                'displayName' => 'SSL Certificate',
                'name' => 'ssl-certificate',
                'dbName' => 'ssl_certificate_enable',
                'url' => '/test/ssl-certificate',
                'slug' => 'ssl-certificate-test',
                'route' => 'tool/ssl-certificate-test',
                'main_heading' => 'SSL Certificate',
                'main_para' => 'ssl-certificate Content',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),

            8 => 
            array (
                'displayName' => 'Directory Browsing',
                'name' => 'directory-browsing',
                'dbName' => 'folder_browsing_enable',
                'url' => '/test/directory-browsing',
                'slug' => 'directory-browsing-test',
                'route' => 'tool/directory-browsing-test',
                'main_heading' => 'Directory Browsing',
                'main_para' => 'Directory Browsing',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),

            9 => 
            array (
                'displayName' => 'Bad content Type',
                'name' => 'bad-content-type',
                'dbName' => 'folder_browsing_enable',
                'url' => '/test/bad-content',
                'slug' => 'bad-content-type-test',
                'route' => 'tool/bad-content-type-test',
                'main_heading' => 'Bad content Type',
                'main_para' => 'Bad content Type',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),

            10 => 
            array (
                'displayName' => 'Robots.txt',
                'name' => 'robotstxt-test',
                'dbName' => 'folder_browsing_enable',
                'url' => '/test/robot-text-test',
                'slug' => 'robotstxt-test',
                'route' => 'tool/robotstxt-test',
                'main_heading' => 'Robots.txt',
                'main_para' => 'Robots.txt',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),

            11 => 
            array (
                'displayName' => 'Headings',
                'name' => 'headings-test',
                'dbName' => 'h1_heading_tag',
                'url' => '/test/h1-heading-tag',
                'slug' => 'headings-test',
                'route' => 'tool/headings-test',
                'main_heading' => 'Headings',
                'main_para' => 'Headings',
                'results_heading' => 'Results',
                'results_para' => 'Results'
            ),
            

        );



        $meta = array (
            0 => 
            array (
                'displayName' => 'Meta Title',
                'name' => 'title',
                'dbName' => 'meta_title',
                'url' => '/test/title',
                'slug' => 'meta-title',
                'route' => 'tool/meta-title',
                'main_heading' => 'Meta Title Test',
                'main_para' => 'Test your website pages for Meta title tag content. Check meta title length, whether it is equal to H1 tag, and check what casing the title tag follows.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            1 => 
            array (
                'displayName' => 'Meta Description',
                'name' => 'description',
                'dbName' => 'meta_desc',
                'url' => '/test/description',
                'slug' => 'meta-description',
                'route' => 'tool/meta-description',
                'main_heading' => 'Meta Description Test',
                'main_para' => 'Test your website pages for Meta description tag content and meta description length.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            2 => 
            array (
                'displayName' => 'Canonical Tag',
                'name' => 'canonical',
                'dbName' => 'canonical_url',
                'url' => '/test/canonical-url',
                'slug' => 'canonical-url',
                'route' => 'tool/canonical-url',
                'main_heading' => 'Canonical URL Test',
                'main_para' => 'Test your website pages for canonicalisation, check whether they are self canonicalised or whether a canonical tag exists or not.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            3 => 
            array (
                'displayName' => 'Robots Meta Tag',
                'name' => 'robots',
                'dbName' => 'robots_meta',
                'url' => '/test/robots-meta',
                'slug' => 'robots-meta',
                'route' => 'tool/robots-meta',
                'main_heading' => 'Robots Meta Tag Test',
                'main_para' => 'Test your website pages for indexability, whether it contains a robots meta tag and the content of the robots meta tag.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            4 => 
            array (
                'displayName' => 'URL Slug',
                'name' => 'url',
                'dbName' => 'url_slug',
                'url' => '/test/url-slug',
                'slug' => 'url-slug',
                'route' => 'tool/url-slug',
                'main_heading' => 'URL Slug Test',
                'main_para' => 'Test your website pages URL slug and check whether it meets best SEO practices and standards.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            5 => 
            array (
                'displayName' => 'OG Tags',
                'name' => 'og:title',
                'dbName' => 'open_graph_tags',
                'url' => '/test/og-tags',
                'slug' => 'og-tags',
                'route' => 'tool/og-tags',
                'main_heading' => 'Open Graph Tags Test',
                'main_para' => 'Test your website pages for Open Graph Tags tags, whether they exist and are following the best practices and standards.',
                'results_heading' => 'Open Graph Tags',
                'results_para' => 'Results',
                'ogDesc' => [
                    'displayName' => "OG Description",
                    'name' => "og:description",
                    'dbName' => "open_graph_desc",
                ],
                'ogImage' => [
                    'displayName' => "OG Image",
                    'name' => "og:image",
                    'dbName' => "open_graph_image",
                ],
                'ogURL' => [
                    'displayName' => "OG URL",
                    'name' => "og:url",
                    'dbName' => "open_graph_url",
                ],
            ),
            6 => 
            array (
                'displayName' => 'Twitter Tags',
                'name' => 'twitter:title',
                'dbName' => 'twitter_tags',
                'url' => '/test/twitter-tags',
                'slug' => 'twitter-tags',
                'route' => 'tool/twitter-tags',
                'main_heading' => 'Twitter Tags Test',
                'main_para' => 'Test your website pages for Twitter title tags, whether they exist and are following the best practices and standards.',
                'results_heading' => 'Twitter Tags',
                'results_para' => 'Results',
                'twitterImage' => [
                    'displayName' => "Twitter Image",
                    'name' => "twitter:image",
                    'dbName' => "twitter_image",
                ],
                'twitterImageAlt' => [
                    'displayName' => "Twitter Image Alt",
                    'name' => "twitter:image:alt",
                    'dbName' => "twitter_image_alt",
                ],
            ),
            7 => 
            array (
                'displayName' => 'Favicon',
                'name' => 'icon',
                'dbName' => 'favicon',
                'url' => '/test/favicon',
                'slug' => 'favicon',
                'route' => 'tool/favicon',
                'main_heading' => 'Favicon Test',
                'main_para' => 'Test your website pages if they are using a Favicon tag or not.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
            8 => 
            array (
              'displayName' => 'XML Sitemap',
              'name' => 'xml_sitemap',
              'dbName' => 'xml_sitemap',
              'url' => '/test/xml-sitemap',
              'slug' => 'xml-sitemap',
              'route' => 'tool/xml-sitemap',
              'main_heading' => 'XML Sitemap Test',
              'main_para' => 'Test your website pages if they exist in the XML Sitemap',
              'results_heading' => 'Results',
              'results_para' => 'Results',
            ),
            9 => 
            array (
              'displayName' => 'HTML Sitemap',
              'name' => 'html_sitemap',
              'dbName' => 'html_sitemap',
              'url' => '/test/html-sitemap',
              'slug' => 'html-sitemap',
              'route' => 'tool/html-sitemap',
              'main_heading' => 'HTML Sitemap Test',
              'main_para' => 'Test your website pages if they exist in the HTML Sitemap',
              'results_heading' => 'Results',
              'results_para' => 'Results',
            ),
            10 => 
            array (
                'displayName' => 'Meta Viewport',
                'name' => 'viewport',
                'dbName' => 'meta_viewport',
                'url' => '/test/meta-viewport',
                'slug' => 'meta-viewport',
                'route' => 'tool/meta-viewport',
                'main_heading' => 'Meta Viewport Test',
                'main_para' => 'Test your website pages for Meta title tag content. Check meta title length, whether it is equal to H1 tag, and check what casing the title tag follows.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),
            11 => 
            array (
                'displayName' => 'Doctype',
                'name' => 'doctype',
                'dbName' => 'doctype',
                'url' => '/test/doctype',
                'slug' => 'doctype',
                'route' => 'tool/doctype',
                'main_heading' => 'Doctype Test',
                'main_para' => 'Test your website pages for Meta title tag content. Check meta title length, whether it is equal to H1 tag, and check what casing the title tag follows.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
                'bulk_ignore' => true
            ),
            array (
                'displayName' => 'HTTP Status Code',
                'name' => 'http_status_code',
                'dbName' => 'http_status_code',
                'url' => '/test/http-status-code',
                'slug' => 'http-status-code',
                'route' => 'tool/http-status-code',
                'main_heading' => 'HTTP Status Code Test',
                'main_para' => 'Test your website pages for Meta title tag content. Check meta title length, whether it is equal to H1 tag, and check what casing the title tag follows.',
                'results_heading' => 'Results',
                'results_para' => 'Results',
            ),
        );

        $data = array_merge($meta, $images, $performance, $best_practices, $security);

        return [
            "meta" => $meta,
            "images" => $images,
            "performance" => $performance,
            "best_practices" => $best_practices,
            "security" => $security,
            "data" => $data,
        ];
    }
}
