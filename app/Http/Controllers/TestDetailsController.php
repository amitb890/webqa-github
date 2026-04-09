<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;

class TestDetailsController extends Controller
{
    public function title(Request $request){
        $elements = json_decode($request->input("data"));
        $duplicate = 0;
        $equalH1 = 0;
        $noContent = 0;
        $lengthOver = 0;
        $lengthBelow = 0;
        $casingUndefined = 0;
        $casingCamel = 0;
        $casingSentence = 0;

        foreach($elements as $element){
            if(!$element->testerrorcaught){
                if($element->content === ""){
                    $noContent++;
                }

                if(strlen($element->content) > 65){
                    $lengthOver++;
                }
                
                if(strlen($element->content) < 30){
                    $lengthBelow++;
                }

                if($element->titleCasingCamel == 1){
                    $casingCamel++;
                }

                if($element->titleCasingSentence == 1){
                    $casingSentence++;
                }

                if($element->titleCasingCamel == 0 || $element->titleCasingSentence == 0 || $element->titleCasingBoth == 0){
                    $casingUndefined++;
                }
            }
        }

        $object = new \stdClass();
        $object->noContent = $noContent;
        $object->duplicate = $duplicate;
        $object->equalH1 = $equalH1;
        $object->lengthOver = $lengthOver;
        $object->lengthBelow = $lengthBelow;
        $object->casingCamel = $casingCamel;
        $object->casingSentence = $casingSentence;
        $object->casingUndefined = $casingUndefined;
        echo json_encode($object);
    }


    public function description(Request $request){
        $elements = json_decode($request->input("data"));
        $duplicate = 0;
        $noContent = 0;
        $lengthOver = 0;
        $lengthBelow = 0;

        foreach($elements as $element){
            if(!$element->testerrorcaught){
                if($element->content === ""){
                    $noContent++;
                }

                if(strlen($element->content) > 160){
                    $lengthOver++;
                }
                
                if(strlen($element->content) < 30){
                    $lengthBelow++;
                }
            }
        }

        $object = new \stdClass();
        $object->noContent = $noContent;
        $object->duplicate = $duplicate;
        $object->lengthOver = $lengthOver;
        $object->lengthBelow = $lengthBelow;
        echo json_encode($object);
    }

    public function robots(Request $request){
        $elements = json_decode($request->input("data"));
        $withRobotsMeta = 0;
        $withoutRobotsMeta = 0;


        $withNoIndexNofollow = 0;
        $withNoIndex = 0;


        foreach($elements as $element){
            if(!$element->testerrorcaught){
                if($element->isExists){
                    $withRobotsMeta+=1;
                }

                if(!$element->isExists){
                    $withoutRobotsMeta+=1;
                }

                if($element->noIndexFollowStatus){
                    $withNoIndexNofollow+=1;
                }

                if($element->noIndexStatus){
                    $withNoIndex+=1;
                }
            }
        }

        $object = new \stdClass();
        $object->withRobotsMeta = $withRobotsMeta;
        $object->withoutRobotsMeta = $withoutRobotsMeta;
        $object->withNoIndexNofollow = $withNoIndexNofollow;
        $object->withNoIndex = $withNoIndex;
        echo json_encode($object);
    }

    public function canonical(Request $request){
        $elements = json_decode($request->input("data"));
        $withCanonical = 0;
        $withoutCanonical = 0;

        foreach($elements as $element){
            if(!$element->testerrorcaught){
                if($element->isExists){
                    $withCanonical+=1;
                }

                if(!$element->isExists){
                    $withoutCanonical+=1;
                }
            }
        }

        $object = new \stdClass();
        $object->withCanonical = $withCanonical;
        $object->withoutCanonical = $withoutCanonical;
        echo json_encode($object);
    }


    public function xmlSitemap(Request $request){
        $elements = json_decode($request->input("data"));
        $fileExists = isset($elements[0]->fileExists) ? $elements[0]->fileExists : false;
        $object = new \stdClass();
        $object->fileExists = $fileExists;
        $robotsTxtUrl = '';
        if (is_array($elements) || is_object($elements)) {
            foreach ($elements as $element) {
                if (! is_object($element)) {
                    continue;
                }
                $candidateUrl = self::resolveRobotsTxtUrlFromStoredResult($element);
                if ($robotsTxtUrl === '' && $candidateUrl !== '') {
                    $robotsTxtUrl = $candidateUrl;
                }
            }
        }
        $object->robotsTxtUrl = $robotsTxtUrl;

        if($fileExists){
            $sitemapExists = 0;
            $sitemapNotFound = [];
            $sitemapNotFoundString = "";
            $index = 1;
            foreach($elements as $element){
                if(!$element->testerrorcaught){
                    $index++;
                    if($element->status){
                        $sitemapExists+=1;
                    }else{
                        array_push($sitemapNotFound, $element->tested_url);
                        $sitemapNotFoundString .= $index . ". " . $element->tested_url;
                    }
                }
            }



            $object->sitemapExists = $sitemapExists;
            $object->sitemapNotFound = $sitemapNotFound;
            $object->sitemapNotFoundString = $sitemapNotFoundString;
            $object->totalUrls = count($elements);
        }
        echo json_encode($object);
    }


    public function images(Request $request){
        $elements = json_decode($request->input("data"));
        $imageFileNameIssue = 0;
        $imageNameLengthOver = 0;
        $imageSizeOver = 0;
        $imageNameMissingAlt = 0;
        $imageNameAltIssues = 0;
        $totalImages = 0;

        foreach($elements as $element){
            if(!$element->testerrorcaught){
                $totalImages+=count($element->problems);
                foreach($element->problems as $image){
                    if(!$image->imageSize){
                        $imageSizeOver++;
                    }

                    if($image->imageAlt == ""){
                        $imageNameMissingAlt++;
                    }


                    if(!$image->imageLengthStatus){
                        $imageNameLengthOver++;
                    }


                    if(!$image->imageAltSpacesStatus){
                        $imageNameAltIssues++;
                    }

                    if(!$image->imageHyphenStatus || !$image->imageSpecialStatus || !$image->imageUppercaseStatus){
                        $imageFileNameIssue++;
                    }
                }
            }
        }

        $object = new \stdClass();
        $object->settings = isset($elements[0]->settings) ? $elements[0]->settings : [];
        $object->imageSizeOver = $imageSizeOver;
        $object->imageNameMissingAlt = $imageNameMissingAlt;
        $object->imageNameLengthOver = $imageNameLengthOver;
        $object->imageNameAltIssues = $imageNameAltIssues;
        $object->imageFileNameIssue = $imageFileNameIssue;
        $object->totalImages = $totalImages;
 
        echo json_encode($object);
    }


    public function htmlSitemap(Request $request){
        $elements = json_decode($request->input("data"));
        $fileExists = isset($elements[0]->fileExists) ? $elements[0]->fileExists : false;
        $object = new \stdClass();
        $object->fileExists = $fileExists;
        $robotsTxtUrl = '';
        if (is_array($elements) || is_object($elements)) {
            foreach ($elements as $element) {
                if (! is_object($element)) {
                    continue;
                }
                $candidateUrl = self::resolveRobotsTxtUrlFromStoredResult($element);
                if ($robotsTxtUrl === '' && $candidateUrl !== '') {
                    $robotsTxtUrl = $candidateUrl;
                }
            }
        }
        $object->robotsTxtUrl = $robotsTxtUrl;

        if($fileExists){
            $sitemapExists = 0;
            $sitemapNotFound = [];
            $sitemapNotFoundString = "";
            $index = 1;
            foreach($elements as $element){
                if(!$element->testerrorcaught){
                    $index++;
                    if($element->status){
                        $sitemapExists+=1;
                    }else{
                        array_push($sitemapNotFound, $element->tested_url);
                        $sitemapNotFoundString .= $index . ". " . $element->tested_url;
                    }
                }
            }



            $object->sitemapExists = $sitemapExists;
            $object->sitemapNotFound = $sitemapNotFound;
            $object->sitemapNotFoundString = $sitemapNotFoundString;
            $object->totalUrls = count($elements);
        }
        echo json_encode($object);
    }


    public function ogTags(Request $request){
        $elements = json_decode($request->input("data"));
        $OGTitleElementExists = 0;
        $OGTitleLengthOver = 0;
        $OGTitleLengthBelow = 0;

        $OGDescElementExists = 0;
        $OGDescLengthOver = 0;
        $OGDescLengthBelow = 0;

        $OGImageElementExists = 0;


        $OGUrlElementExists = 0;
    

        foreach($elements as $element){
            if(!$element->testerrorcaught){
                if($element->showContent){
                    $OGTitleElementExists+=1;
                }


                // title    
                if(strlen($element->content) > 65){
                    $OGTitleLengthOver++;
                }
                
                if(strlen($element->content) < 30){
                    $OGTitleLengthBelow++;
                }

                // desc
                if($element->contentDesc != ""){
                    $OGDescElementExists+=1;
                }

                if(strlen($element->contentDesc) > 200){
                    $OGDescLengthOver++;
                }
                
                if(strlen($element->contentDesc) < 70){
                    $OGDescLengthBelow++;
                }

                // image
                if($element->contentImage != ""){
                    $OGImageElementExists+=1;
                }

                // url
                if($element->contentURL != ""){
                    $OGUrlElementExists+=1;
                }
            }
        }

        $object = new \stdClass();
        $object->totalUrls = count($elements);
        // title
        $object->OGTitleElementExists = $OGTitleElementExists;
        $object->OGTitleLengthOver = $OGTitleLengthOver;
        $object->OGTitleLengthBelow = $OGTitleLengthBelow;

        // desc
        $object->OGDescElementExists = $OGDescElementExists;
        $object->OGDescLengthOver = $OGDescLengthOver;
        $object->OGDescLengthBelow = $OGDescLengthBelow;

        // image
        $object->OGImageElementExists = $OGImageElementExists;

        // url
        $object->OGUrlElementExists = $OGUrlElementExists;

        echo json_encode($object);
    }

    public function twitterTags(Request $request){
        $elements = json_decode($request->input("data"));
        $twitterTitleElementExists = 0;
        $twitterTitleLengthOver = 0;
        $twitterTitleLengthBelow = 0;


        $twitterImageElementExists = 0;


        $twitterImageAltElementExists = 0;
    

        foreach($elements as $element){
            if(!$element->testerrorcaught){
                // title    
                if($element->showContent){
                    $twitterTitleElementExists+=1;
                }

                if(strlen($element->content) > 65){
                    $twitterTitleLengthOver++;
                }
                
                if(strlen($element->content) < 30){
                    $twitterTitleLengthBelow++;
                }


                // image
                if($element->contentImage != ""){
                    $twitterImageElementExists+=1;
                }

                // url
                if($element->contentImageAlt != ""){
                    $twitterImageAltElementExists+=1;
                }
            }
        }

        $object = new \stdClass();
        $object->totalUrls = count($elements);
        // title
        $object->twitterTitleElementExists = $twitterTitleElementExists;
        $object->twitterTitleLengthOver = $twitterTitleLengthOver;
        $object->twitterTitleLengthBelow = $twitterTitleLengthBelow;

        // image
        $object->twitterImageElementExists = $twitterImageElementExists;

        // url
        $object->twitterImageAltElementExists = $twitterImageAltElementExists;

        echo json_encode($object);
    }

    public function securityHeaders(Request $request){
        $elements = json_decode($request->input("data"));
        $elementsSafeBrowsing = $elements->is_safe_browsing;
        $elementsCrossOriginLinks = $elements->cross_origin_links;
        $elementsBadContent = $elements->bad_content_type;
        $elementsContentSecurity = $elements->content_security_policy_header;
        $elementsFolder = $elements->folder_browsing_enable;
        $elementsHSTS = $elements->hsts_header;
        $elementsProtocol = $elements->protocol_relative_resource;
        $elementsSSL = $elements->ssl_certificate_enable;
        $elementsXframe = $elements->x_frame_options_header;


        $safeBrowsingEnabled = 0;
        $safeBrowsingDisabled = 0;

        $crossOriginLinksEnabled = 0;
        $crossOriginLinksDisabled = 0;

        $protocolRelativeEnabled = 0;
        $protocolRelativeDisabled = 0;

        $contentSecurityEnabled = 0;
        $contentSecurityDisabled = 0;

        $xFrameOptionsEnabled = 0;
        $xFrameOptionsDisabled = 0;


        $hstsHeaderEnabled = 0;
        $hstsHeaderDisabled = 0;

        $badContentEnabled = 0;
        $badContentDisabled = 0;

        $sslCertificateEnabled = 0;
        $sslCertificateDisabled = 0;

        $folderBrowsingEnabled = 0;
        $folderBrowsingDisabled = 0;
    

        foreach($elementsSafeBrowsing as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $safeBrowsingEnabled++;
                }else{
                    $safeBrowsingDisabled++;
                }
            }
        }

        foreach($elementsCrossOriginLinks as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $crossOriginLinksEnabled++;
                }else{
                    $crossOriginLinksDisabled++;
                }
            }
        }

        foreach($elementsBadContent as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $badContentEnabled++;
                }else{
                    $badContentDisabled++;
                }
            }
        }

        foreach($elementsSSL as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $sslCertificateEnabled++;
                }else{
                    $sslCertificateDisabled++;
                }
            }
        }

        foreach($elementsXframe as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $xFrameOptionsEnabled++;
                }else{
                    $xFrameOptionsDisabled++;
                }
            }
        }

        foreach($elementsProtocol as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $protocolRelativeEnabled++;
                }else{
                    $protocolRelativeDisabled++;
                }
            }
        }

        foreach($elementsContentSecurity as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $contentSecurityEnabled++;
                }else{
                    $contentSecurityDisabled++;
                }
            }
        }

        foreach($elementsHSTS as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $hstsHeaderEnabled++;
                }else{
                    $hstsHeaderDisabled++;
                }
            }
        }

        foreach($elementsFolder as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $folderBrowsingDisabled++;
                }else{
                    $folderBrowsingEnabled++;
                }
            }
        }

        $object = new \stdClass();
        $object->safeBrowsingEnabled = $safeBrowsingEnabled;
        $object->safeBrowsingDisabled = $safeBrowsingDisabled;

        $object->crossOriginLinksEnabled = $crossOriginLinksEnabled;
        $object->crossOriginLinksDisabled  = $crossOriginLinksDisabled;

        $object->protocolRelativeEnabled = $protocolRelativeEnabled;
        $object->protocolRelativeDisabled = $protocolRelativeDisabled;

        $object->contentSecurityEnabled = $contentSecurityEnabled;
        $object->contentSecurityDisabled = $contentSecurityDisabled;

        $object->xFrameOptionsEnabled = $xFrameOptionsEnabled;
        $object->xFrameOptionsDisabled = $xFrameOptionsDisabled;

        $object->hstsHeaderEnabled = $hstsHeaderEnabled;
        $object->hstsHeaderDisabled = $hstsHeaderDisabled;

        $object->badContentEnabled = $badContentEnabled;
        $object->badContentDisabled = $badContentDisabled;

        $object->sslCertificateEnabled = $sslCertificateEnabled;
        $object->sslCertificateDisabled = $sslCertificateDisabled;

        $object->folderBrowsingEnabled = $folderBrowsingEnabled;
        $object->folderBrowsingDisabled = $folderBrowsingDisabled;

        echo json_encode($object);
    }

    public function mobileFriendly(Request $request){
        $elements = json_decode($request->input("data"));
        $mobileFriendlyPassed = 0;
        $mobileFriendlyFailed = 0;

        foreach($elements as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $mobileFriendlyPassed++;
                }else{
                    $mobileFriendlyFailed++;
                }
            }
        }

        $object = new \stdClass();
        $object->totalUrls = count($elements);
        $object->mobileFriendlyPassed = $mobileFriendlyPassed;
        $object->mobileFriendlyFailed = $mobileFriendlyFailed;

        echo json_encode($object);
    }


    public function pageSize(Request $request){
        $elements = json_decode($request->input("data"));
        $pageSizePassed = 0;
        $pageSizeFailed = 0;

        foreach($elements as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $pageSizePassed++;
                }else{
                    $pageSizeFailed++;
                }
            }
        }

        $object = new \stdClass();
        $object->settings = $elements[0]->settings;
        $object->totalUrls = count($elements);
        $object->pageSizePassed = $pageSizePassed;
        $object->pageSizeFailed = $pageSizeFailed;

        echo json_encode($object);
    }

    public function httpStatusCode(Request $request){
        $elements = json_decode($request->input("data"));
        $http200 = 0;
        $http100x = 0;
        $http200x = 0;
        $http300x = 0;
        $http400x = 0;
        $http500x = 0;

        foreach($elements as $element){
            if(!$element->testerrorcaught){
                $httpCode = intval($element->httpCode);
                if($httpCode == 200){
                    $http200++;
                }else{

                    if($httpCode >= 100 && $httpCode < 200){
                        $http100x++;
                    }

                    if($httpCode >= 200 && $httpCode < 300){
                        $http200x++;
                    }

                    if($httpCode >= 300 && $httpCode < 400){
                        $http300x++;
                    }

                    if($httpCode >= 400 && $httpCode < 500){
                        $http400x++;
                    }

                    if($httpCode > 500){
                        $http500x++;
                    }
                }
            }
        }

        $object = new \stdClass();
        $object->settings = $elements[0]->settings;
        $object->totalUrls = count($elements);
        $object->http200 = $http200;
        $object->http100x = $http100x;
        $object->http200x = $http200x;
        $object->http300x = $http300x;
        $object->http400x = $http400x;
        $object->http500x = $http500x;

        echo json_encode($object);
    }

    public function brokenLinks(Request $request){
        $elements = json_decode($request->input("data"));
        $http200 = 0;
        $http100x = 0;
        $http200x = 0;
        $http300x = 0;
        $http400x = 0;
        $http500x = 0;

        $totalBrokenLinks = 0;
        $totalBrokenWebPages = 0;
        $totalBrokenInternal = 0;
        $totalBrokenExternal = 0;

        foreach($elements as $element){
            if(!$element->testerrorcaught){
                if(!$element->status){
                    $totalBrokenWebPages++;
                    $totalBrokenLinks+=$element->totalBrokenLinks;
                    $totalBrokenInternal+=count($element->totalBrokenInternal);
                    $totalBrokenExternal+=count($element->totalBrokenExternal);
                }
            }
        }

        $object = new \stdClass();
        $object->settings = $elements[0]->settings;
        $object->totalUrls = count($elements);
        $object->totalBrokenLinks = $totalBrokenLinks;
        $object->totalBrokenWebPages = $totalBrokenWebPages;
        $object->totalBrokenInternal = $totalBrokenInternal;
        $object->totalBrokenExternal = $totalBrokenExternal;

        echo json_encode($object);
    }

    /**
     * Prefer stored robots_txt_url; fall back to tested_url origin so dashboard tiles still show a link
     * when older rows omit robots_txt_url or used a different payload shape.
     */
    private static function resolveRobotsTxtUrlFromStoredResult(object $element): string
    {
        foreach (['robots_txt_url', 'robotsTxtUrl'] as $prop) {
            if (! empty($element->{$prop}) && is_string($element->{$prop})) {
                return $element->{$prop};
            }
        }

        $testedUrl = $element->tested_url ?? '';
        if (! is_string($testedUrl) || $testedUrl === '') {
            return '';
        }

        $p = parse_url($testedUrl);
        if (empty($p['host'])) {
            return '';
        }
        $scheme = $p['scheme'] ?? '';
        if ($scheme === '') {
            $scheme = 'https';
        }

        return $scheme.'://'.$p['host'].'/robots.txt';
    }

    public function robotTextTest(Request $request)
    {
        $elements = json_decode($request->input('data'));
        if (! is_array($elements) && ! is_object($elements)) {
            $object = new \stdClass();
            $object->settings = null;
            $object->totalUrls = 0;
            $object->robotsTxtUrl = '';
            $object->urlsBlockedThroughRobots = 0;
            $object->resourcesBlockedThroughRobots = 0;
            echo json_encode($object);

            return;
        }

        $urlsBlockedThroughRobots = 0;
        $resourcesBlockedThroughRobots = 0;
        $robotsTxtUrl = '';
        $firstOk = null;

        foreach ($elements as $element) {
            if (! is_object($element)) {
                continue;
            }

            $candidateUrl = self::resolveRobotsTxtUrlFromStoredResult($element);
            if ($robotsTxtUrl === '' && $candidateUrl !== '') {
                $robotsTxtUrl = $candidateUrl;
            }

            if (! empty($element->testerrorcaught)) {
                continue;
            }
            if ($firstOk === null) {
                $firstOk = $element;
            }
            if (! empty($element->urlBlock)) {
                $urlsBlockedThroughRobots++;
            }
            $rc = intval($element->resources_blocked_count ?? 0);
            if ($rc > $resourcesBlockedThroughRobots) {
                $resourcesBlockedThroughRobots = $rc;
            }
        }

        $object = new \stdClass();
        $object->settings = $firstOk ? $firstOk->settings : null;
        $object->totalUrls = count((array) $elements);
        $object->robotsTxtUrl = $robotsTxtUrl;
        $object->urlsBlockedThroughRobots = $urlsBlockedThroughRobots;
        $object->resourcesBlockedThroughRobots = $resourcesBlockedThroughRobots;

        echo json_encode($object);
    }

    /**
     * Dashboard aggregate for the Headings (H1–H6) test — mirrors per-URL data from RunTest::h1HeadindTag.
     */
    public function headings(Request $request)
    {
        $elements = json_decode($request->input('data'));
        if (! is_array($elements) && ! is_object($elements)) {
            $object = new \stdClass();
            $object->settings = null;
            $object->totalUrls = 0;
            $object->urlsFailed = 0;
            $object->urlsPassed = 0;
            $object->urlsMissingH1 = 0;
            echo json_encode($object);

            return;
        }

        $urlsFailed = 0;
        $urlsPassed = 0;
        $urlsMissingH1 = 0;
        $firstOk = null;

        foreach ($elements as $element) {
            if (! is_object($element)) {
                continue;
            }
            if (! empty($element->testerrorcaught)) {
                continue;
            }
            if ($firstOk === null) {
                $firstOk = $element;
            }
            if (! empty($element->status)) {
                $urlsPassed++;
            } else {
                $urlsFailed++;
            }
            $ha = $element->headingArray ?? null;
            if ($ha !== null) {
                $h1 = is_array($ha) ? ($ha['h1'] ?? []) : ($ha->h1 ?? []);
                $n = is_countable($h1) ? count($h1) : 0;
                if ($n === 0) {
                    $urlsMissingH1++;
                }
            }
        }

        $object = new \stdClass();
        $object->settings = $firstOk ? $firstOk->settings : null;
        $object->totalUrls = count((array) $elements);
        $object->urlsFailed = $urlsFailed;
        $object->urlsPassed = $urlsPassed;
        $object->urlsMissingH1 = $urlsMissingH1;

        echo json_encode($object);
    }

    public function googleInsights(Request $request)
    {
        $helpers = new Helper();
    
        $rows = json_decode($request->input("data"), true);
        if (!is_array($rows)) {
            return response()->json(['error' => 'Invalid payload']);
        }
    
        // Counters
        $desktopCount = 0;
        $desktopSum = 0;
        $desktopGood = 0;
        $desktopAvg = 0;
        $desktopPoor = 0;
    
        $mobileCount = 0;
        $mobileSum = 0;
        $mobileGood = 0;
        $mobileAvg = 0;
        $mobilePoor = 0;
    
        foreach ($rows as $row) {
    
            // Skip anything not completed
            if (($row['status'] ?? '') !== 'completed') {
                continue;
            }
    
            // Must have strategy + data
            if (!isset($row['strategy']) || !isset($row['data'])) {
                continue;
            }
    
            // Decode data field
            $data = json_decode($row['data'], true);
            if (!is_array($data)) {
                continue;
            }
    
            $score = floatval($data['performance_score'] ?? 0);
            $strategy = $row['strategy'];
    
            // Desktop
            if ($strategy === 'desktop') {
                $desktopCount++;
                $desktopSum += $score;
    
                if ($score >= 90) $desktopGood++;
                elseif ($score >= 50) $desktopAvg++;
                else $desktopPoor++;
            }
    
            // Mobile
            if ($strategy === 'mobile') {
                $mobileCount++;
                $mobileSum += $score;
    
                if ($score >= 90) $mobileGood++;
                elseif ($score >= 50) $mobileAvg++;
                else $mobilePoor++;
            }
        }
    
        // Safely compute averages
        $desktopAvgScore = $desktopCount > 0 ? intval($desktopSum / $desktopCount) : 0;
        $mobileAvgScore  = $mobileCount > 0 ? intval($mobileSum / $mobileCount) : 0;
    
        // Build response
        $object = new \stdClass();
        $object->totalUrls = max($desktopCount, $mobileCount); // number of URLs tested
    
        $object->desktopOverallAvg = $desktopAvgScore;
        $object->desktopGood = $desktopGood;
        $object->desktopAvg = $desktopAvg;
        $object->desktopPoor = $desktopPoor;
    
        $object->mobileOverallAvg = $mobileAvgScore;
        $object->mobileGood = $mobileGood;
        $object->mobileAvg = $mobileAvg;
        $object->mobilePoor = $mobilePoor;
    
        $object->colorDesktop = $helpers->getGoogleInsightsColorByScore($desktopAvgScore);
        $object->colorMobile = $helpers->getGoogleInsightsColorByScore($mobileAvgScore);
    
        echo json_encode($object); 
    }
    
    public function googleLighthouse(Request $request)
{
    $helpers = new Helper();

    $rows = json_decode($request->input("data"), true);
    if (!is_array($rows)) {
        return response()->json(['error' => 'Invalid payload']);
    }

    // Desktop totals
    $desktopCount = 0;
    $desktopAccSum = 0;
    $desktopPerSum = 0;
    $desktopSeoSum = 0;
    $desktopBPSum = 0;

    $desktopGoodPer = $desktopAvgPer = $desktopPoorPer = 0;
    $desktopGoodAcc = $desktopAvgAcc = $desktopPoorAcc = 0;
    $desktopGoodBP  = $desktopAvgBP  = $desktopPoorBP  = 0;
    $desktopGoodSeo = $desktopAvgSeo = $desktopPoorSeo = 0;

    // Mobile totals
    $mobileCount = 0;
    $mobileAccSum = 0;
    $mobilePerSum = 0;
    $mobileSeoSum = 0;
    $mobileBPSum = 0;

    $mobileGoodPer = $mobileAvgPer = $mobilePoorPer = 0;
    $mobileGoodAcc = $mobileAvgAcc = $mobilePoorAcc = 0;
    $mobileGoodBP  = $mobileAvgBP  = $mobilePoorBP  = 0;
    $mobileGoodSeo = $mobileAvgSeo = $mobilePoorSeo = 0;


    // Loop through all lighthouse_result rows
    foreach ($rows as $row) {

        // Skip rows not completed
        if (($row['status'] ?? '') !== 'completed') {
            continue;
        }

        // Must have strategy + data
        if (!isset($row['strategy']) || !isset($row['data'])) {
            continue;
        }

        // Parse internal JSON data field
        $data = json_decode($row['data'], true);
        if (!is_array($data)) {
            continue;
        }

        $acc = floatval($data['accessibility_score'] ?? 0);
        $per = floatval($data['performance_score'] ?? 0);
        $bp  = floatval($data['best_practices_score'] ?? 0);
        $seo = floatval($data['seo_score'] ?? 0);

        $strategy = $row['strategy'];


        /** --------------------------
         * DESKTOP
         * -------------------------*/
        if ($strategy === 'desktop') {

            $desktopCount++;

            $desktopAccSum += $acc;
            $desktopPerSum += $per;
            $desktopBPSum  += $bp;
            $desktopSeoSum += $seo;

            // Performance bucket
            if ($per >= 90)      $desktopGoodPer++;
            elseif ($per >= 50) $desktopAvgPer++;
            else                $desktopPoorPer++;

            // Accessibility
            if ($acc >= 90)      $desktopGoodAcc++;
            elseif ($acc >= 50)  $desktopAvgAcc++;
            else                 $desktopPoorAcc++;

            // Best Practices
            if ($bp >= 90)       $desktopGoodBP++;
            elseif ($bp >= 50)   $desktopAvgBP++;
            else                 $desktopPoorBP++;

            // SEO
            if ($seo >= 90)      $desktopGoodSeo++;
            elseif ($seo >= 50)  $desktopAvgSeo++;
            else                 $desktopPoorSeo++;
        }


        /** --------------------------
         * MOBILE
         * -------------------------*/
        if ($strategy === 'mobile') {

            $mobileCount++;

            $mobileAccSum += $acc;
            $mobilePerSum += $per;
            $mobileBPSum  += $bp;
            $mobileSeoSum += $seo;

            // Performance bucket
            if ($per >= 90)      $mobileGoodPer++;
            elseif ($per >= 50)  $mobileAvgPer++;
            else                 $mobilePoorPer++;

            // Accessibility
            if ($acc >= 90)      $mobileGoodAcc++;
            elseif ($acc >= 50)  $mobileAvgAcc++;
            else                 $mobilePoorAcc++;

            // Best Practices
            if ($bp >= 90)       $mobileGoodBP++;
            elseif ($bp >= 50)   $mobileAvgBP++;
            else                 $mobilePoorBP++;

            // SEO
            if ($seo >= 90)      $mobileGoodSeo++;
            elseif ($seo >= 50)  $mobileAvgSeo++;
            else                 $mobilePoorSeo++;
        }
    }


    /** --------------------------
     * Averages
     * -------------------------*/
    $desktopAccAvg = $desktopCount ? $desktopAccSum / $desktopCount : 0;
    $desktopPerAvg = $desktopCount ? $desktopPerSum / $desktopCount : 0;
    $desktopBPAvg  = $desktopCount ? $desktopBPSum  / $desktopCount : 0;
    $desktopSeoAvg = $desktopCount ? $desktopSeoSum / $desktopCount : 0;

    $mobileAccAvg = $mobileCount ? $mobileAccSum / $mobileCount : 0;
    $mobilePerAvg = $mobileCount ? $mobilePerSum / $mobileCount : 0;
    $mobileBPAvg  = $mobileCount ? $mobileBPSum  / $mobileCount : 0;
    $mobileSeoAvg = $mobileCount ? $mobileSeoSum / $mobileCount : 0;


    /** --------------------------
     * Colors
     * -------------------------*/
    $colorPerDesktop = $helpers->getGoogleInsightsColorByScore($desktopPerAvg);
    $colorPerMobile  = $helpers->getGoogleInsightsColorByScore($mobilePerAvg);

    $colorAccDesktop = $helpers->getGoogleInsightsColorByScore($desktopAccAvg);
    $colorAccMobile  = $helpers->getGoogleInsightsColorByScore($mobileAccAvg);

    $colorBPDesktop  = $helpers->getGoogleInsightsColorByScore($desktopBPAvg);
    $colorBPMobile   = $helpers->getGoogleInsightsColorByScore($mobileBPAvg);

    $colorSeoDesktop = $helpers->getGoogleInsightsColorByScore($desktopSeoAvg);
    $colorSeoMobile  = $helpers->getGoogleInsightsColorByScore($mobileSeoAvg);


    /** --------------------------
     * Build Response
     * -------------------------*/
    $object = new \stdClass();

    $object->totalUrls = max($desktopCount, $mobileCount);

    // Desktop
    $object->desktopAccAvg = $desktopAccAvg;
    $object->desktopPerAvg = $desktopPerAvg;
    $object->desktopSeoAvg = $desktopSeoAvg;
    $object->desktopBPAvg  = $desktopBPAvg;

    $object->desktopGoodPer = $desktopGoodPer;
    $object->desktopAvgPer  = $desktopAvgPer;
    $object->desktopPoorPer = $desktopPoorPer;

    $object->desktopGoodAcc = $desktopGoodAcc;
    $object->desktopAvgAcc  = $desktopAvgAcc;
    $object->desktopPoorAcc = $desktopPoorAcc;

    $object->desktopGoodBP  = $desktopGoodBP;
    $object->desktopAvgBP   = $desktopAvgBP;
    $object->desktopPoorBP  = $desktopPoorBP;

    $object->desktopGoodSeo = $desktopGoodSeo;
    $object->desktopAvgSeo  = $desktopAvgSeo;
    $object->desktopPoorSeo = $desktopPoorSeo;


    // Mobile
    $object->mobileAccAvg = $mobileAccAvg;
    $object->mobilePerAvg = $mobilePerAvg;
    $object->mobileSeoAvg = $mobileSeoAvg;
    $object->mobileBPAvg  = $mobileBPAvg;

    $object->mobileGoodPer = $mobileGoodPer;
    $object->mobileAvgPer  = $mobileAvgPer;
    $object->mobilePoorPer = $mobilePoorPer;

    $object->mobileGoodAcc = $mobileGoodAcc;
    $object->mobileAvgAcc  = $mobileAvgAcc;
    $object->mobilePoorAcc = $mobilePoorAcc;

    $object->mobileGoodBP  = $mobileGoodBP;
    $object->mobileAvgBP   = $mobileAvgBP;
    $object->mobilePoorBP  = $mobilePoorBP;

    $object->mobileGoodSeo = $mobileGoodSeo;
    $object->mobileAvgSeo  = $mobileAvgSeo;
    $object->mobilePoorSeo = $mobilePoorSeo;


    // Colors
    $object->colorPerDesktop = $colorPerDesktop;
    $object->colorPerMobile  = $colorPerMobile;

    $object->colorAccDesktop = $colorAccDesktop;
    $object->colorAccMobile  = $colorAccMobile;

    $object->colorBPDesktop  = $colorBPDesktop;
    $object->colorBPMobile   = $colorBPMobile;

    $object->colorSeoDesktop = $colorSeoDesktop;
    $object->colorSeoMobile  = $colorSeoMobile;


    echo json_encode($object); 
}


public function googleCoreWebVitals(Request $request)
{
    $helpers = new Helper();

    $rows = json_decode($request->input("data"));

    // Counters
    $desktopCount = 0;
    $mobileCount = 0;

    // AVG values
    $desktop = $mobile = [
        "LCP" => 0, "FCP" => 0, "CLS" => 0, "FID" => 0, "TTI" => 0, "SI" => 0, "TBT" => 0,
    ];

    // Buckets
    $bucketNames = ["Good", "Avg", "Poor"];
    foreach (["desktop", "mobile"] as $type) {
        foreach (["LCP", "FCP", "CLS", "FID", "TTI", "SI", "TBT"] as $metric) {
            foreach ($bucketNames as $bucket) {
                ${$type . $bucket . $metric} = 0;
            }
        }
    }

    // -------------------------
    // PROCESS EACH RECORD
    // -------------------------
    foreach ($rows as $record) {

        if (!isset($record->status) || $record->status !== "completed") {
            continue;
        }

        $data = json_decode($record->data ?? "{}");
        if (!isset($data->largest_contentful_paint)) {
            continue;
        }

        $isDesktop = ($record->strategy === "desktop");
        $type = $isDesktop ? "desktop" : "mobile";

        if ($isDesktop) $desktopCount++;
        else $mobileCount++;

        // Extract metrics
        $LCP = $data->largest_contentful_paint;
        $FCP = $data->first_contentful_paint;
        $CLS = $data->cumulative_layout_shift;
        $FID = $data->max_potential_fid;
        $TTI = $data->interactive;
        $SI  = $data->speed_index;
        $TBT = $data->total_blocking_time;

        // Sum for averages
        ${$type}["LCP"] += $LCP;
        ${$type}["FCP"] += $FCP;
        ${$type}["CLS"] += $CLS;
        ${$type}["FID"] += $FID;
        ${$type}["TTI"] += $TTI;
        ${$type}["SI"]  += $SI;
        ${$type}["TBT"] += $TBT;

        // -------------------------
        // BUCKET LOGIC
        // -------------------------

        // LCP
        if ($LCP <= 3) ${$type . "GoodLCP"}++;
        elseif ($LCP < 4.5) ${$type . "AvgLCP"}++;
        else ${$type . "PoorLCP"}++;

        // FCP
        if ($FCP <= 3) ${$type . "GoodFCP"}++;
        elseif ($FCP <= 4.5) ${$type . "AvgFCP"}++;
        else ${$type . "PoorFCP"}++;

        // CLS
        if ($CLS <= 0.1) ${$type . "GoodCLS"}++;
        elseif ($CLS <= 0.25) ${$type . "AvgCLS"}++;
        else ${$type . "PoorCLS"}++;

        // FID
        if ($FID <= 100) ${$type . "GoodFID"}++;
        elseif ($FID <= 330) ${$type . "AvgFID"}++;
        else ${$type . "PoorFID"}++;

        // TBT
        if ($TBT <= 100) ${$type . "GoodTBT"}++;
        elseif ($TBT <= 330) ${$type . "AvgTBT"}++;
        else ${$type . "PoorTBT"}++;

        // SI
        if ($SI <= 2) ${$type . "GoodSI"}++;
        elseif ($SI <= 7) ${$type . "AvgSI"}++;
        else ${$type . "PoorSI"}++;

        // TTI
        if ($TTI <= 2) ${$type . "GoodTTI"}++;
        elseif ($TTI <= 7) ${$type . "AvgTTI"}++;
        else ${$type . "PoorTTI"}++;
    }

    // -------------------------
    // FINAL AVERAGES
    // -------------------------
    foreach (["desktop" => $desktopCount, "mobile" => $mobileCount] as $type => $count) {
        foreach (${$type} as $key => $value) {
            ${$type . $key . "Avg"} = $count > 0 ? $value / $count : 0;
        }
    }

    // -------------------------
    // COLORS
    // -------------------------
    $colors = [];
    foreach (["desktop", "mobile"] as $type) {
        foreach ([
            "LCP" => "LCP$type",
            "FCP" => "FCP$type",
            "CLS" => "CLS$type",
            "FID" => "FID$type",
            "TTI" => "TTI$type",
            "SI"  => "SI$type",
            "TBT" => "TBT$type",
        ] as $metric => $key) {
            $colors[$key] = $helpers->getGoogleCWVColorByScore(${$type . $metric . "Avg"}, $key);
        }
    }

    // -------------------------
    // BUILD RESPONSE OBJECT
    // -------------------------
    $obj = new \stdClass();
    $obj->totalUrls = max($desktopCount, $mobileCount);

    foreach (["desktop", "mobile"] as $type) {
        foreach (["LCP","FCP","CLS","FID","TTI","SI","TBT"] as $m) {
            $obj->{$type . $m . "Avg"} = ${$type . $m . "Avg"};

            foreach ($bucketNames as $bucket) {
                $obj->{$type . $bucket . $m} = ${$type . $bucket . $m};
            }
        }
    }

    // Colors
    foreach ($colors as $key => $value) {
        $obj->{"color".$key} = $value;
    }

    echo json_encode($obj);
}


    public function codingBestPractices(Request $request){
        $elements = json_decode($request->input("data"));
        $elementsHtmlCompression = $elements->html_compression;
        $elementsCssCompression = $elements->css_compression;
        $elementsJsCompression = $elements->js_compression;
        $elementsGzipCompression = $elements->gzip_compression;
        $elementsFrameset = $elements->nested_tables;
        $elementsNested = $elements->frameset;
        $elementsJsCaching = $elements->css_caching_enable;
        $elementsCssCaching = $elements->js_caching_enable;


        $htmlCompressed = 0;
        $htmlNotCompressed = 0;

        $cssCompressed = 0;
        $cssNotCompressed = 0;

        $jsCompressed = 0;
        $jsNotCompressed = 0;

        $gzipCompressed = 0;
        $gzipNotCompressed = 0;

        $frameset = 0;
        $framesetWithout = 0;

        $nestedTables = 0;
        $nestedTablesWithout = 0;

        $jsCachingEnable = 0;
        $jsCachingNotEnable = 0;

        $cssCachingEnable = 0;
        $cssCachingNotEnable = 0;



        foreach($elementsHtmlCompression as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $htmlCompressed++;       
                }else{
                    $htmlNotCompressed++;       
                }
            }
        }

        foreach($elementsCssCompression as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $cssCompressed++;       
                }else{
                    $cssNotCompressed++;       
                }
            }
        }

        foreach($elementsJsCompression as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $jsCompressed++;       
                }else{
                    $jsNotCompressed++;       
                }
            }
        }

        foreach($elementsGzipCompression as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $gzipCompressed++;       
                }else{
                    $gzipNotCompressed++;       
                }
            }
        }

        foreach($elementsJsCaching as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $jsCachingEnable++;       
                }else{
                    $jsCachingNotEnable++;       
                }
            }
        }

        foreach($elementsCssCaching as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $cssCachingEnable++;       
                }else{
                    $cssCachingNotEnable++;       
                }
            }
        }

        foreach($elementsNested as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $nestedTables++;       
                }else{
                    $nestedTablesWithout++;       
                }
            }
        }

        foreach($elementsFrameset as $element){
            if(!$element->testerrorcaught){
                if($element->status){
                    $frameset++;       
                }else{
                    $framesetWithout++;       
                }
            }
        }

        $object = new \stdClass();

        $object->htmlCompressed = $htmlCompressed;
        $object->htmlNotCompressed = $htmlNotCompressed;
        $object->cssCompressed = $cssCompressed;
        $object->cssNotCompressed = $cssNotCompressed;
        $object->jsCompressed = $jsCompressed;
        $object->jsNotCompressed = $jsNotCompressed;
        $object->gzipCompressed = $gzipCompressed;
        $object->gzipNotCompressed = $gzipNotCompressed;

        $object->jsCachingEnable = $jsCachingEnable;
        $object->jsCachingNotEnable = $jsCachingNotEnable;
        $object->cssCachingEnable = $cssCachingEnable;
        $object->cssCachingNotEnable = $cssCachingNotEnable;
        $object->nestedTables = $nestedTables;
        $object->nestedTablesWithout = $nestedTablesWithout;
        $object->frameset = $frameset;
        $object->framesetWithout = $framesetWithout;



        echo json_encode($object); 
    }

}
