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
            if($element->isExists){
                $withCanonical+=1;
            }

            if(!$element->isExists){
                $withoutCanonical+=1;
            }

        }

        $object = new \stdClass();
        $object->withCanonical = $withCanonical;
        $object->withoutCanonical = $withoutCanonical;
        echo json_encode($object);
    }


    public function xmlSitemap(Request $request){
        $elements = json_decode($request->input("data"));
        $fileExists = $elements[0]->fileExists;
        $object = new \stdClass();
        $object->fileExists = $fileExists;

        if($fileExists){
            $sitemapExists = 0;
            $sitemapNotFound = [];
            $sitemapNotFoundString = "";
            $index = 1;
            foreach($elements as $element){
                $index++;
                if($element->status){
                    $sitemapExists+=1;
                }else{
                    array_push($sitemapNotFound, $element->tested_url);
                    $sitemapNotFoundString .= $index . ". " . $element->tested_url;
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

        $object = new \stdClass();
        $object->settings = $elements[0]->settings;
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
        $fileExists = $elements[0]->fileExists;
        $object = new \stdClass();
        $object->fileExists = $fileExists;

        if($fileExists){
            $sitemapExists = 0;
            $sitemapNotFound = [];
            $sitemapNotFoundString = "";
            $index = 1;
            foreach($elements as $element){
                $index++;
                if($element->status){
                    $sitemapExists+=1;
                }else{
                    array_push($sitemapNotFound, $element->tested_url);
                    $sitemapNotFoundString .= $index . ". " . $element->tested_url;
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
            if($element->status){
                $safeBrowsingEnabled++;
            }else{
                $safeBrowsingDisabled++;
            }
        }

        foreach($elementsCrossOriginLinks as $element){
            if($element->status){
                $crossOriginLinksEnabled++;
            }else{
                $crossOriginLinksDisabled++;
            }
        }

        foreach($elementsBadContent as $element){
            if($element->status){
                $badContentEnabled++;
            }else{
                $badContentDisabled++;
            }
        }

        foreach($elementsSSL as $element){
            if($element->status){
                $sslCertificateEnabled++;
            }else{
                $sslCertificateDisabled++;
            }
        }

        foreach($elementsXframe as $element){
            if($element->status){
                $xFrameOptionsEnabled++;
            }else{
                $xFrameOptionsDisabled++;
            }
        }

        foreach($elementsProtocol as $element){
            if($element->status){
                $protocolRelativeEnabled++;
            }else{
                $protocolRelativeDisabled++;
            }
        }

        foreach($elementsContentSecurity as $element){
            if($element->status){
                $contentSecurityEnabled++;
            }else{
                $contentSecurityDisabled++;
            }
        }

        foreach($elementsHSTS as $element){
            if($element->status){
                $hstsHeaderEnabled++;
            }else{
                $hstsHeaderDisabled++;
            }
        }

        foreach($elementsFolder as $element){
            if($element->status){
                $folderBrowsingDisabled++;
            }else{
                $folderBrowsingEnabled++;
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
            if($element->status){
                $mobileFriendlyPassed++;
            }else{
                $mobileFriendlyFailed++;
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
            if($element->status){
                $pageSizePassed++;
            }else{
                $pageSizeFailed++;
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
            if(!$element->status){
                $totalBrokenWebPages++;
                $totalBrokenLinks+=$element->totalBrokenLinks;
                $totalBrokenInternal+=count($element->totalBrokenInternal);
                $totalBrokenExternal+=count($element->totalBrokenExternal);
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

    public function googleInsights(Request $request){
        $helpers = new Helper();

        $elements = json_decode($request->input("data"));
        $totalElements = 0;
        $desktopOverallAvg = 0;
        $desktopGood = 0;
        $desktopAvg = 0;
        $desktopPoor = 0;

        $mobileOverallAvg = 0;
        $mobileGood = 0;
        $mobileAvg = 0;
        $mobilePoor = 0;

        $desktopStatus = true;

        foreach($elements as $element){
            // Skip if this element is an error object
            if (!isset($element->desktop) || !isset($element->mobile)) {
                continue;
            }
            $totalElements++;
            $desktopOverallAvg+=$element->desktop->performance_score;
            $mobileOverallAvg+=$element->mobile->performance_score;

            // desktop
            if($element->desktop->performance_score >= 90){
                $desktopGood++;
            }
            if($element->desktop->performance_score >= 50 &&  $element->desktop->performance_score < 90){
                $desktopAvg++;
            }
            if($element->desktop->performance_score < 50){
                $desktopPoor++;
            }


            // mobile
            if($element->mobile->performance_score >= 90){
                $mobileGood++;
            }
            if($element->mobile->performance_score >= 50 &&  $element->mobile->performance_score < 90){
                $mobileAvg++;
            }
            if($element->mobile->performance_score < 50){
                $mobilePoor++;
            }
        }

        if ($totalElements > 0) {
            $desktopOverallAvg = intVal($desktopOverallAvg/$totalElements);
            $mobileOverallAvg = intVal($mobileOverallAvg/$totalElements);
        } else {
            $desktopOverallAvg = 0;
            $mobileOverallAvg = 0;
        }

        $colorDesktop = $helpers->getGoogleInsightsColorByScore($desktopOverallAvg);
        $colorMobile = $helpers->getGoogleInsightsColorByScore($mobileOverallAvg);


        $object = new \stdClass();
        $object->totalUrls = $totalElements;
        $object->desktopOverallAvg = $desktopOverallAvg;
        $object->desktopGood = $desktopGood;
        $object->desktopAvg = $desktopAvg;
        $object->desktopPoor = $desktopPoor;

        $object->mobileOverallAvg = $mobileOverallAvg;
        $object->mobileGood = $mobileGood;
        $object->mobileAvg = $mobileAvg;
        $object->mobilePoor = $mobilePoor;

        $object->colorDesktop = $colorDesktop;
        $object->colorMobile = $colorMobile;

        echo json_encode($object); 
    }

    public function googleLighthouse(Request $request){
        $helpers = new Helper();

        $elements = json_decode($request->input("data"));
        $totalElements = 0;

        $desktopAccAvg = 0;
        $desktopPerAvg = 0;
        $desktopSeoAvg = 0;
        $desktopBPAvg = 0;

        $desktopGoodPer = 0;
        $desktopAvgPer = 0;
        $desktopPoorPer = 0;

        $desktopGoodAcc = 0;
        $desktopAvgAcc = 0;
        $desktopPoorAcc = 0;

        $desktopGoodBP = 0;
        $desktopAvgBP = 0;
        $desktopPoorBP = 0;

        $desktopGoodSeo = 0;
        $desktopAvgSeo = 0;
        $desktopPoorSeo = 0;


    
        // mobile
        $mobileAccAvg = 0;
        $mobilePerAvg = 0;
        $mobileSeoAvg = 0;
        $mobileBPAvg = 0;

        $mobileGoodPer = 0;
        $mobileAvgPer = 0;
        $mobilePoorPer = 0;

        $mobileGoodAcc = 0;
        $mobileAvgAcc = 0;
        $mobilePoorAcc = 0;

        $mobileGoodBP = 0;
        $mobileAvgBP = 0;
        $mobilePoorBP = 0;

        $mobileGoodSeo = 0;
        $mobileAvgSeo = 0;
        $mobilePoorSeo = 0;


        foreach($elements as $element){
            if (!isset($element->desktop) || !isset($element->mobile)) {
                continue;
            }
            $totalElements++;
            $desktopAccAvg+=$element->desktop->accessibility_score;
            $desktopPerAvg+=$element->desktop->performance_score;
            $desktopBPAvg+=$element->desktop->best_practices_score;
            $desktopSeoAvg+=$element->desktop->seo_score;

            $mobileAccAvg+=$element->mobile->accessibility_score;
            $mobilePerAvg+=$element->mobile->performance_score;
            $mobileBPAvg+=$element->mobile->best_practices_score;
            $mobileSeoAvg+=$element->mobile->seo_score;

            // desktop
            if($element->desktop->performance_score >= 90){ // performance
                $desktopGoodPer++;
            }
            if($element->desktop->performance_score >= 50 &&  $element->desktop->performance_score < 90){
                $desktopAvgPer++;
            }
            if($element->desktop->performance_score < 50){
                $desktopPoorPer++;
            }

            if($element->desktop->accessibility_score >= 90){ // accessibility
                $desktopGoodAcc++;
            }
            if($element->desktop->accessibility_score >= 50 &&  $element->desktop->accessibility_score < 90){
                $desktopAvgAcc++;
            }
            if($element->desktop->accessibility_score < 50){
                $desktopPoorAcc++;
            }

            if($element->desktop->best_practices_score >= 90){ // best practices
                $desktopGoodBP++;
            }
            if($element->desktop->best_practices_score >= 50 &&  $element->desktop->best_practices_score < 90){
                $desktopAvgBP++;
            }
            if($element->desktop->best_practices_score < 50){
                $desktopPoorBP++;
            }

            if($element->desktop->seo_score >= 90){ // seo
                $desktopGoodSeo++;
            }
            if($element->desktop->seo_score >= 50 &&  $element->desktop->seo_score < 90){
                $desktopAvgSeo++;
            }
            if($element->desktop->seo_score < 50){
                $desktopPoorSeo++;
            }



            // mobile
            if($element->mobile->performance_score >= 90){ // performance
                $mobileGoodPer++;
            }
            if($element->mobile->performance_score >= 50 &&  $element->mobile->performance_score < 90){
                $mobileAvgPer++;
            }
            if($element->mobile->performance_score < 50){
                $mobilePoorPer++;
            }

            if($element->mobile->accessibility_score >= 90){ // accessibility
                $mobileGoodAcc++;
            }
            if($element->mobile->accessibility_score >= 50 &&  $element->mobile->accessibility_score < 90){
                $mobileAvgAcc++;
            }
            if($element->mobile->accessibility_score < 50){
                $mobilePoorAcc++;
            }

            if($element->desktop->best_practices_score >= 90){ // best practices
                $mobileGoodBP++;
            }
            if($element->desktop->best_practices_score >= 50 &&  $element->desktop->best_practices_score < 90){
                $mobileAvgBP++;
            }
            if($element->desktop->best_practices_score < 50){
                $mobilePoorBP++;
            }

            if($element->mobile->seo_score >= 90){ // seo
                $mobileGoodSeo++;
            }
            if($element->mobile->seo_score >= 50 &&  $element->mobile->seo_score < 90){
                $mobileAvgSeo++;
            }
            if($element->mobile->seo_score < 50){
                $mobilePoorSeo++;
            }
        }

        if ($totalElements > 0) {
            $desktopAccAvg = $desktopAccAvg/$totalElements;
            $desktopPerAvg = $desktopPerAvg/$totalElements;
            $desktopBPAvg = $desktopBPAvg/$totalElements;
            $desktopSeoAvg = $desktopSeoAvg/$totalElements;
            $mobileAccAvg = $mobileAccAvg/$totalElements;
            $mobilePerAvg = $mobilePerAvg/$totalElements;
            $mobileBPAvg = $mobileBPAvg/$totalElements;
            $mobileSeoAvg = $mobileSeoAvg/$totalElements;
        } else {
            $desktopAccAvg = $desktopPerAvg = $desktopBPAvg = $desktopSeoAvg = 0;
            $mobileAccAvg = $mobilePerAvg = $mobileBPAvg = $mobileSeoAvg = 0;
        }

        
        // color
        $colorPerDesktop = $helpers->getGoogleInsightsColorByScore($desktopPerAvg);
        $colorPerMobile = $helpers->getGoogleInsightsColorByScore($mobilePerAvg);

        $colorAccDesktop = $helpers->getGoogleInsightsColorByScore($desktopAccAvg);
        $colorAccMobile = $helpers->getGoogleInsightsColorByScore($mobileAccAvg);

        $colorBPDesktop = $helpers->getGoogleInsightsColorByScore($desktopBPAvg);
        $colorBPMobile = $helpers->getGoogleInsightsColorByScore($mobileBPAvg);

        $colorSeoDesktop = $helpers->getGoogleInsightsColorByScore($desktopSeoAvg);
        $colorSeoMobile = $helpers->getGoogleInsightsColorByScore($mobileSeoAvg);

        $object = new \stdClass();
        $object->totalUrls = $totalElements;
        $object->desktopAccAvg = $desktopAccAvg;
        $object->desktopPerAvg = $desktopPerAvg;
        $object->desktopSeoAvg = $desktopSeoAvg;
        $object->desktopBPAvg = $desktopBPAvg;

        $object->desktopGoodPer = $desktopGoodPer;
        $object->desktopAvgPer = $desktopAvgPer;
        $object->desktopPoorPer = $desktopPoorPer;

        $object->desktopGoodAcc = $desktopGoodAcc;
        $object->desktopAvgAcc = $desktopAvgAcc;
        $object->desktopPoorAcc = $desktopPoorAcc;

        $object->desktopGoodBP = $desktopGoodBP;
        $object->desktopAvgBP = $desktopAvgBP;
        $object->desktopPoorBP = $desktopPoorBP;

        $object->desktopGoodSeo = $desktopGoodSeo;
        $object->desktopAvgSeo = $desktopAvgSeo;
        $object->desktopPoorSeo = $desktopPoorSeo;



        // mobile
        $object->mobileAccAvg = $mobileAccAvg;
        $object->mobilePerAvg = $mobilePerAvg;
        $object->mobileSeoAvg = $mobileSeoAvg;
        $object->mobileBPAvg = $mobileBPAvg;

        $object->mobileGoodPer = $mobileGoodPer;
        $object->mobileAvgPer = $mobileAvgPer;
        $object->mobilePoorPer = $mobilePoorPer;

        $object->mobileGoodAcc = $mobileGoodAcc;
        $object->mobileAvgAcc = $mobileAvgAcc;
        $object->mobilePoorAcc = $mobilePoorAcc;

        $object->mobileGoodBP = $mobileGoodBP;
        $object->mobileAvgBP = $mobileAvgBP;
        $object->mobilePoorBP = $mobilePoorBP;

        $object->mobileGoodSeo = $mobileGoodSeo;
        $object->mobileAvgSeo = $mobileAvgSeo;
        $object->mobilePoorSeo = $mobilePoorSeo;

        // color
        $object->colorPerDesktop = $colorPerDesktop;
        $object->colorPerMobile = $colorPerMobile;

        $object->colorAccDesktop = $colorAccDesktop;
        $object->colorAccMobile = $colorAccMobile;

        $object->colorBPDesktop = $colorBPDesktop;
        $object->colorBPMobile = $colorBPMobile;

        $object->colorSeoDesktop = $colorSeoDesktop;
        $object->colorSeoMobile = $colorSeoMobile;




        echo json_encode($object); 
    }

    public function googleCoreWebVitals(Request $request){
        $helpers = new Helper();

        $elements = json_decode($request->input("data"));
        $totalElements = 0;

        $desktopLCPAvg = 0;
        $desktopFCPAvg = 0;
        $desktopCLSAvg = 0;
        $desktopFIDAvg = 0;
        $desktopTTIAvg = 0;
        $desktopSIAvg = 0;
        $desktopTBTAvg = 0;

        $desktopGoodLCP = 0;
        $desktopAvgLCP = 0;
        $desktopPoorLCP = 0;

        $desktopGoodFCP = 0;
        $desktopAvgFCP = 0;
        $desktopPoorFCP = 0;

        $desktopGoodCLS = 0;
        $desktopAvgCLS = 0;
        $desktopPoorCLS = 0;

        $desktopGoodFID = 0;
        $desktopAvgFID = 0;
        $desktopPoorFID = 0;

        $desktopGoodTTI = 0;
        $desktopAvgTTI = 0;
        $desktopPoorTTI = 0;

        $desktopGoodSI = 0;
        $desktopAvgSI = 0;
        $desktopPoorSI = 0;

        $desktopGoodTBT = 0;
        $desktopAvgTBT = 0;
        $desktopPoorTBT = 0;


        // MOBILE
        $mobileLCPAvg = 0;
        $mobileFCPAvg = 0;
        $mobileCLSAvg = 0;
        $mobileFIDAvg = 0;
        $mobileTTIAvg = 0;
        $mobileSIAvg = 0;
        $mobileTBTAvg = 0;

        $mobileGoodLCP = 0;
        $mobileAvgLCP = 0;
        $mobilePoorLCP = 0;

        $mobileGoodFCP = 0;
        $mobileAvgFCP = 0;
        $mobilePoorFCP = 0;

        $mobileGoodCLS = 0;
        $mobileAvgCLS = 0;
        $mobilePoorCLS = 0;

        $mobileGoodFID = 0;
        $mobileAvgFID = 0;
        $mobilePoorFID = 0;

        $mobileGoodTTI = 0;
        $mobileAvgTTI = 0;
        $mobilePoorTTI = 0;

        $mobileGoodSI = 0;
        $mobileAvgSI = 0;
        $mobilePoorSI = 0;

        $mobileGoodTBT = 0;
        $mobileAvgTBT = 0;
        $mobilePoorTBT = 0;


        foreach($elements as $element){
            if (!isset($element->desktop) || !isset($element->mobile)) {
                continue;
            }
            $totalElements++;

            // DESKTOP AVG SCORES
            $desktopLCPAvg+=$element->desktop->largest_contentful_paint;
            $desktopFCPAvg+=$element->desktop->first_contentful_paint;
            $desktopCLSAvg+=$element->desktop->cumulative_layout_shift;
            $desktopFIDAvg+=$element->desktop->max_potential_fid;
            $desktopTTIAvg+=$element->desktop->interactive;
            $desktopSIAvg+=$element->desktop->speed_index;
            $desktopTBTAvg+=$element->desktop->total_blocking_time;

            // MOBILE AVG SCORES
            $mobileLCPAvg+=$element->mobile->largest_contentful_paint;
            $mobileFCPAvg+=$element->mobile->first_contentful_paint;
            $mobileCLSAvg+=$element->mobile->cumulative_layout_shift;
            $mobileFIDAvg+=$element->mobile->max_potential_fid;
            $mobileTTIAvg+=$element->mobile->interactive;
            $mobileSIAvg+=$element->mobile->speed_index;
            $mobileTBTAvg+=$element->mobile->total_blocking_time;

            // desktop
            if($element->desktop->largest_contentful_paint <= 3){ // LCP
                $desktopGoodLCP++;
            }
            if($element->desktop->largest_contentful_paint > 3 &&  $element->desktop->largest_contentful_paint < 4.5){
                $desktopAvgLCP++;
            }
            if($element->desktop->largest_contentful_paint >= 4.5){
                $desktopPoorLCP++;
            }


            if($element->desktop->first_contentful_paint <= 3){ // FCP
                $desktopGoodFCP++;
            }
            if($element->desktop->first_contentful_paint > 3 &&  $element->desktop->first_contentful_paint <= 4.5){
                $desktopAvgFCP++;
            }
            if($element->desktop->first_contentful_paint > 4.5){
                $desktopPoorFCP++;
            }


            if($element->desktop->cumulative_layout_shift <= 0.1){ // CLS
                $desktopGoodCLS++;
            }
            if($element->desktop->cumulative_layout_shift > 0.1 &&  $element->desktop->cumulative_layout_shift <= 0.25){
                $desktopAvgCLS++;
            }
            if($element->desktop->cumulative_layout_shift >= 0.25){
                $desktopPoorCLS++;
            }


            if($element->desktop->max_potential_fid <= 100){ // FID
                $desktopGoodFID++;
            }
            if($element->desktop->max_potential_fid > 100 &&  $element->desktop->max_potential_fid <= 330){
                $desktopAvgFID++;
            }
            if($element->desktop->max_potential_fid > 330){
                $desktopPoorFID++;
            }


            if($element->desktop->total_blocking_time <= 100){ // TBT
                $desktopGoodTBT++;
            }
            if($element->desktop->total_blocking_time > 100 &&  $element->desktop->total_blocking_time <= 330){
                $desktopAvgTBT++;
            }
            if($element->desktop->total_blocking_time > 330){
                $desktopPoorTBT++;
            }


            if($element->desktop->speed_index <= 2){ // SI
                $desktopGoodSI++;
            }
            if($element->desktop->speed_index > 2 &&  $element->desktop->speed_index <= 7){
                $desktopAvgSI++;
            }
            if($element->desktop->speed_index > 7){
                $desktopPoorSI++;
            }


            if($element->desktop->interactive <= 2){ // TTI
                $desktopGoodTTI++;
            }
            if($element->desktop->interactive > 2 &&  $element->desktop->interactive <= 7){
                $desktopAvgTTI++;
            }
            if($element->desktop->interactive > 7){
                $desktopPoorTTI++;
            }





            // mobile
            if($element->mobile->largest_contentful_paint <= 3){ // LCP
                $mobileGoodLCP++;
            }
            if($element->mobile->largest_contentful_paint > 3 &&  $element->mobile->largest_contentful_paint < 4.5){
                $mobileAvgLCP++;
            }
            if($element->mobile->largest_contentful_paint >= 4.5){
                $mobilePoorLCP++;
            }


            if($element->mobile->first_contentful_paint <= 3){ // FCP
                $mobileGoodFCP++;
            }
            if($element->mobile->first_contentful_paint > 3 &&  $element->mobile->first_contentful_paint <= 4.5){
                $mobileAvgFCP++;
            }
            if($element->mobile->first_contentful_paint > 4.5){
                $mobilePoorFCP++;
            }


            if($element->mobile->cumulative_layout_shift <= 0.1){ // CLS
                $mobileGoodCLS++;
            }
            if($element->mobile->cumulative_layout_shift > 0.1 &&  $element->mobile->cumulative_layout_shift <= 0.25){
                $mobileAvgCLS++;
            }
            if($element->mobile->cumulative_layout_shift >= 0.25){
                $mobilePoorCLS++;
            }


            if($element->mobile->max_potential_fid <= 100){ // FID
                $mobileGoodFID++;
            }
            if($element->mobile->max_potential_fid > 100 &&  $element->mobile->max_potential_fid <= 330){
                $mobileAvgFID++;
            }
            if($element->mobile->max_potential_fid > 330){
                $mobilePoorFID++;
            }


            if($element->mobile->total_blocking_time <= 100){ // TBT
                $mobileGoodTBT++;
            }
            if($element->mobile->total_blocking_time > 100 &&  $element->mobile->total_blocking_time <= 330){
                $mobileAvgTBT++;
            }
            if($element->mobile->total_blocking_time > 330){
                $mobilePoorTBT++;
            }


            if($element->mobile->speed_index <= 2){ // SI
                $mobileGoodSI++;
            }
            if($element->mobile->speed_index > 2 &&  $element->mobile->speed_index <= 7){
                $mobileAvgSI++;
            }
            if($element->mobile->speed_index > 7){
                $mobilePoorSI++;
            }


            if($element->mobile->interactive <= 2){ // TTI
                $mobileGoodTTI++;
            }
            if($element->mobile->interactive > 2 &&  $element->mobile->interactive <= 7){
                $mobileAvgTTI++;
            }
            if($element->mobile->interactive > 7){
                $mobilePoorTTI++;
            }
        }

        // Division by zero protection for averages
        if ($totalElements > 0) {
            $desktopLCPAvg = $desktopLCPAvg/$totalElements;
            $desktopFCPAvg = $desktopFCPAvg/$totalElements;
            $desktopCLSAvg = $desktopCLSAvg/$totalElements;
            $desktopFIDAvg = $desktopFIDAvg/$totalElements;
            $desktopTTIAvg = $desktopTTIAvg/$totalElements;
            $desktopSIAvg = $desktopSIAvg/$totalElements;
            $desktopTBTAvg = $desktopTBTAvg/$totalElements;

            $mobileLCPAvg = $mobileLCPAvg/$totalElements;
            $mobileFCPAvg = $mobileFCPAvg/$totalElements;
            $mobileCLSAvg = $mobileCLSAvg/$totalElements;
            $mobileFIDAvg = $mobileFIDAvg/$totalElements;
            $mobileTTIAvg = $mobileTTIAvg/$totalElements;
            $mobileSIAvg = $mobileSIAvg/$totalElements;
            $mobileTBTAvg = $mobileTBTAvg/$totalElements;
        } else {
            $desktopLCPAvg = $desktopFCPAvg = $desktopCLSAvg = $desktopFIDAvg = $desktopTTIAvg = $desktopSIAvg = $desktopTBTAvg = 0;
            $mobileLCPAvg = $mobileFCPAvg = $mobileCLSAvg = $mobileFIDAvg = $mobileTTIAvg = $mobileSIAvg = $mobileTBTAvg = 0;
        }

        // color
        $colorLCPDesktop = $helpers->getGoogleCWVColorByScore($desktopLCPAvg, "LCPMobile");
        $colorLCPMobile = $helpers->getGoogleCWVColorByScore($mobileLCPAvg, "LCPMobile");

        $colorFCPDesktop = $helpers->getGoogleCWVColorByScore($desktopFCPAvg, "FCPDesktop");
        $colorFCPMobile = $helpers->getGoogleCWVColorByScore($mobileFCPAvg, "FCPMobile");

        $colorCLSDesktop = $helpers->getGoogleCWVColorByScore($desktopCLSAvg, "CLSDesktop");
        $colorCLSMobile = $helpers->getGoogleCWVColorByScore($mobileCLSAvg, "CLSMobile");

        $colorFIDDesktop = $helpers->getGoogleCWVColorByScore($desktopFIDAvg, "FIDDesktop");
        $colorFIDMobile = $helpers->getGoogleCWVColorByScore($mobileFIDAvg, "FIDMobile");

        $colorTTIDesktop = $helpers->getGoogleCWVColorByScore($desktopTTIAvg, "TTIDesktop");
        $colorTTIMobile = $helpers->getGoogleCWVColorByScore($mobileTTIAvg, "TTIMobile");

        $colorSIDesktop = $helpers->getGoogleCWVColorByScore($desktopSIAvg, "SIDesktop");
        $colorSIMobile = $helpers->getGoogleCWVColorByScore($mobileSIAvg, "SIMobile");

        $colorTBTDesktop = $helpers->getGoogleCWVColorByScore($desktopTBTAvg, "TBTDesktop");
        $colorTBTMobile = $helpers->getGoogleCWVColorByScore($mobileTBTAvg, "TBTMobile");

        $object = new \stdClass();
        $object->totalUrls = $totalElements;
        $object->desktopLCPAvg = $desktopLCPAvg;
        $object->desktopFCPAvg = $desktopFCPAvg;
        $object->desktopCLSAvg = $desktopCLSAvg;
        $object->desktopFIDAvg = $desktopFIDAvg;
        $object->desktopTTIAvg = $desktopTTIAvg;
        $object->desktopSIAvg = $desktopSIAvg;
        $object->desktopTBTAvg = $desktopTBTAvg;

        $object->desktopGoodLCP = $desktopGoodLCP;
        $object->desktopAvgLCP = $desktopAvgLCP;
        $object->desktopPoorLCP = $desktopPoorLCP;

        $object->desktopGoodFCP = $desktopGoodFCP;
        $object->desktopAvgFCP = $desktopAvgFCP;
        $object->desktopPoorFCP = $desktopPoorFCP;

        $object->desktopGoodTTI = $desktopGoodTTI;
        $object->desktopAvgTTI = $desktopAvgTTI;
        $object->desktopPoorTTI = $desktopPoorTTI;

        $object->desktopGoodTBT = $desktopGoodTBT;
        $object->desktopAvgTBT = $desktopAvgTBT;
        $object->desktopPoorTBT = $desktopPoorTBT;

        $object->desktopGoodCLS = $desktopGoodCLS;
        $object->desktopAvgCLS = $desktopAvgCLS;
        $object->desktopPoorCLS = $desktopPoorCLS;

        $object->desktopGoodFID = $desktopGoodFID;
        $object->desktopAvgFID = $desktopAvgFID;
        $object->desktopPoorFID = $desktopPoorFID;

        $object->desktopGoodSI = $desktopGoodSI;
        $object->desktopAvgSI = $desktopAvgSI;
        $object->desktopPoorSI = $desktopPoorSI;


        // mobile
        $object->mobileLCPAvg = $mobileLCPAvg;
        $object->mobileFCPAvg = $mobileFCPAvg;
        $object->mobileCLSAvg = $mobileCLSAvg;
        $object->mobileFIDAvg = $mobileFIDAvg;
        $object->mobileTTIAvg = $mobileTTIAvg;
        $object->mobileSIAvg = $mobileSIAvg;
        $object->mobileTBTAvg = $mobileTBTAvg;

        $object->mobileGoodLCP = $mobileGoodLCP;
        $object->mobileAvgLCP = $mobileAvgLCP;
        $object->mobilePoorLCP = $mobilePoorLCP;

        $object->mobileGoodFCP = $mobileGoodFCP;
        $object->mobileAvgFCP = $mobileAvgFCP;
        $object->mobilePoorFCP = $mobilePoorFCP;

        $object->mobileGoodTTI = $mobileGoodTTI;
        $object->mobileAvgTTI = $mobileAvgTTI;
        $object->mobilePoorTTI = $mobilePoorTTI;

        $object->mobileGoodTBT = $mobileGoodTBT;
        $object->mobileAvgTBT = $mobileAvgTBT;
        $object->mobilePoorTBT = $mobilePoorTBT;

        $object->mobileGoodCLS = $mobileGoodCLS;
        $object->mobileAvgCLS = $mobileAvgCLS;
        $object->mobilePoorCLS = $mobilePoorCLS;

        $object->mobileGoodFID = $mobileGoodFID;
        $object->mobileAvgFID = $mobileAvgFID;
        $object->mobilePoorFID = $mobilePoorFID;

        $object->mobileGoodSI = $mobileGoodSI;
        $object->mobileAvgSI = $mobileAvgSI;
        $object->mobilePoorSI = $mobilePoorSI;   
        
        // COLOR
        $object->colorLCPDesktop = $colorLCPDesktop;        
        $object->colorLCPMobile = $colorLCPMobile;   

        $object->colorFCPDesktop = $colorFCPDesktop;        
        $object->colorFCPMobile = $colorFCPMobile;   

        $object->colorTTIDesktop = $colorTTIDesktop;        
        $object->colorTTIMobile = $colorTTIMobile;   

        $object->colorFIDDesktop = $colorFIDDesktop;        
        $object->colorFIDMobile = $colorFIDMobile;   

        $object->colorCLSDesktop = $colorCLSDesktop;        
        $object->colorCLSMobile = $colorCLSMobile;   

        $object->colorSIDesktop = $colorSIDesktop;        
        $object->colorSIMobile = $colorSIMobile;   

        $object->colorTBTDesktop = $colorTBTDesktop;        
        $object->colorTBTMobile = $colorTBTMobile;   



        echo json_encode($object); 
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
            if($element->status){
                $htmlCompressed++;       
            }else{
                $htmlNotCompressed++;       
            }
        }

        foreach($elementsCssCompression as $element){
            if($element->status){
                $cssCompressed++;       
            }else{
                $cssNotCompressed++;       
            }
        }

        foreach($elementsJsCompression as $element){
            if($element->status){
                $jsCompressed++;       
            }else{
                $jsNotCompressed++;       
            }
        }

        foreach($elementsGzipCompression as $element){
            if($element->status){
                $gzipCompressed++;       
            }else{
                $gzipNotCompressed++;       
            }
        }

        foreach($elementsJsCaching as $element){
            if($element->status){
                $jsCachingEnable++;       
            }else{
                $jsCachingNotEnable++;       
            }
        }

        foreach($elementsCssCaching as $element){
            if($element->status){
                $cssCachingEnable++;       
            }else{
                $cssCachingNotEnable++;       
            }
        }

        foreach($elementsNested as $element){
            if($element->status){
                $nestedTables++;       
            }else{
                $nestedTablesWithout++;       
            }
        }

        foreach($elementsFrameset as $element){
            if($element->status){
                $frameset++;       
            }else{
                $framesetWithout++;       
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
