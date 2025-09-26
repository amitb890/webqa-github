<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects;
use App\Models\projectSettings;
use App\Models\SettingsSub;
use Helper;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $project = Projects::find($id);
        if(!$project){
            return abort(404);
        }
        $settings = projectSettings::where("projects_id", $project->id)->with("settingsSub")->orderBy('id', 'DESC')->get()->first();
        return view("user.settings.index", compact("user", "settings", "project"));
    }

    public function saveSitemap(Request $request, $id)
    {
        $user = Auth::user();
        $project = Projects::find($id);
        if(!$project){
            return abort(404);
        }
        $sitemapString = $request->input('sitemapString');
        $settingsSub = SettingsSub::where("project_settings_id", $id)->get()->first();
        $settingsSub->xml_sitemap_val = $sitemapString;

        $settingsSubState = $settingsSub->save();

        if($settingsSubState){
            return response()->json(['status'=>1,'msg'=>'Settings updated successfully']);
        }else{
            return response()->json(['status'=>0,'msg'=>'There was an error while updating settings, please try again later.']);
        }
    }

    public function saveBrokenLinksExcluded(Request $request, $id)
    {
        $user = Auth::user();
        $project = Projects::find($id);
        if(!$project){
            return abort(404);
        }
        $excludedUrlsString = $request->input('excludedUrlsString');
        $settingsSub = SettingsSub::where("project_settings_id", $id)->get()->first();
        $settingsSub->broken_links_excluded_urls = $excludedUrlsString;

        $settingsSubState = $settingsSub->save();

        if($settingsSubState){
            return response()->json(['status'=>1,'msg'=>'Excluded URLs updated successfully']);
        }else{
            return response()->json(['status'=>0,'msg'=>'There was an error while updating excluded URLs, please try again later.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $helpers = new Helper();
        $projectId = projectSettings::find($id)->projects_id;
        $project = Projects::find($projectId);
        $projectUrl = $project->homepage;
        $projectUrlParse = parse_url($projectUrl);
        $projectUrlOrigin = explode('.', $projectUrlParse["host"])[1];

        $data = $request->input('data');

        $validator = \Validator::make($data,[
            'titleMaxLengthVal'=>['required_if:titleMaxLength,1'],
            'titleMinLengthVal'=>['required_if:titleMinLength,1'],
            'metaDescLengthMaxVal'=>'required_if:metaDescLengthMax,1',
            'metaDescLengthMinVal'=>'required_if:metaDescLengthMin,1',
            'maxUrlLengthVal'=>'required_if:maxUrlLength,1',
            'ogTitleMaxVal'=>'required_if:ogTitleMax,1',
            'ogTitleMinVal'=>'required_if:ogTitleMin,1',
            'OgDescMaxVal'=>'required_if:OgDescMax,1',
            'OgDescMinVal'=>'required_if:OgDescMin,1',
            'ogImageDimensionsLeastWidth'=>'required_if:ogImageDimensionsLeast,1',
            'ogImageDimensionsLeastHeight'=>'required_if:ogImageDimensionsLeast,1',
            'ogImageDimensionsExactWidth'=>'required_if:ogImageDimensionsExact,1',
            'ogImageDimensionsExactHeight'=>'required_if:ogImageDimensionsExact,1',
            'ogUrlMaxVal'=>'required_if:ogUrlMax,1',
            'twitterTitleLengthMaxVal'=>'required_if:twitterTitleLengthMax,1',
            'twitterTitleLengthMinVal'=>'required_if:twitterTitleLengthMin,1',
            'twitterImageWidthMin'=>'required_if:twitterImageDimensionsMin,1',
            'twitterImageHeightMin'=>'required_if:twitterImageDimensionsMin,1',
            'twitterImageWidthExact'=>'required_if:twitterImageDimensionsExact,1',
            'twitterImageHeightExact'=>'required_if:twitterImageDimensionsExact,1',
            'twitterImageAltMaxVal'=>'required_if:twitterImageAltMax,1',
            'faviconWidthMin'=>'required_if:faviconDimensionsMin,1',
            'faviconHeightMin'=>'required_if:faviconDimensionsMin,1',
            'faviconWidthExact'=>'required_if:faviconDimensionsExact,1',
            'faviconHeightExact'=>'required_if:faviconDimensionsExact,1',
            'xmlSitemapVal'=>'required_if:isXmlSitemap,1',
            'htmlSitemapVal'=>'required_if:isHtmlSitemap,1',
            'imageNameLengthVal'=>'required_if:imageNameLength,1',
            'maximumFileSizeVal'=>'required_if:maximumFileSize,1',

            'googleInsightsDesktopVal'=>'required_if:googleInsightsDesktop,1',
            'googleInsightsMobileVal'=>'required_if:googleInsightsMobile,1',
            'googlePerformanceDesktopVal'=>'required_if:googlePerformanceDesktop,1',
            'googlePerformanceMobileVal'=>'required_if:googlePerformanceMobile,1',
            'googleAccessibilityDesktopVal'=>'required_if:googleAccessibilityDesktop,1',
            'googleAccessibilityMobileVal'=>'required_if:googleAccessibilityMobile,1',
            'googleBestPracticesDesktopVal'=>'required_if:googleBestPracticesDesktop,1',
            'googleBestPracticesMobileVal'=>'required_if:googleBestPracticesMobile,1',
            'googleSeoDesktopVal'=>'required_if:googleSeoDesktop,1',
            'googleSeoMobileVal'=>'required_if:googleSeoMobile,1',
            'googleLCPDesktopVal'=>'required_if:googleLCPDesktop,1',
            'googleLCPMobileVal'=>'required_if:googleLCPMobile,1',
            'googleFCPDesktopVal'=>'required_if:googleFCPDesktop,1',
            'googleFCPMobileVal'=>'required_if:googleFCPMobile,1',
            'googleCLSDesktopVal'=>'required_if:googleCLSDesktop,1',
            'googleCLSMobileVal'=>'required_if:googleCLSMobile,1',
            'googleFIDDesktopVal'=>'required_if:googleFIDDesktop,1',
            'googleFIDMobileVal'=>'required_if:googleFIDMobile,1',
            'googleTBTDesktopVal'=>'required_if:googleTBTDesktop,1',
            'googleTBTMobileVal'=>'required_if:googleTBTMobile,1',
            'googleTTIDesktopVal'=>'required_if:googleTTIDesktop,1',
            'googleTTIMobileVal'=>'required_if:googleTTIMobile,1',
            'googleSIDesktopVal'=>'required_if:googleSIDesktop,1',
            'googleSIMobileVal'=>'required_if:googleSIMobile,1',

            'xmlSitemapVal'=>'required_if:isXmlSitemapCustom,1',
            'htmlSitemapVal'=>'required_if:isHtmlSitemapCustom,1',
        ],[
            'googleInsightsDesktopVal.required_if'=>'Please enter a value.',
            'googleInsightsMobileVal.required_if'=>'Please enter a value.',
            'googlePerformanceDesktopVal.required_if'=>'Please enter a value.',
            'googlePerformanceMobileVal.required_if'=>'Please enter a value.',
            'googleAccessibilityDesktopVal.required_if'=>'Please enter a value.',
            'googleAccessibilityMobileVal.required_if'=>'Please enter a value.',
            'googleBestPracticesDesktopVal.required_if'=>'Please enter a value.',
            'googleBestPracticesMobileVal.required_if'=>'Please enter a value.',
            'googleSeoDesktopVal.required_if'=>'Please enter a value.',
            'googleSeoMobileVal.required_if'=>'Please enter a value.',
            'googleLCPDesktopVal.required_if'=>'Please enter a value.',
            'googleLCPMobileVal.required_if'=>'Please enter a value.',
            'googleFCPDesktopVal.required_if'=>'Please enter a value.',
            'googleFCPMobileVal.required_if'=>'Please enter a value.',
            'googleCLSDesktopVal.required_if'=>'Please enter a value.',
            'googleCLSMobileVal.required_if'=>'Please enter a value.',
            'googleFIDDesktopVal.required_if'=>'Please enter a value.',
            'googleFIDMobileVal.required_if'=>'Please enter a value.',
            'googleTBTDesktopVal.required_if'=>'Please enter a value.',
            'googleTBTMobileVal.required_if'=>'Please enter a value.',
            'googleTTIDesktopVal.required_if'=>'Please enter a value.',
            'googleTTIMobileVal.required_if'=>'Please enter a value.',
            'googleSIDesktopVal.required_if'=>'Please enter a value.',
            'googleSIMobileVal.required_if'=>'Please enter a value.',

            'xmlSitemapVal.required_if'=>'Please enter address to the xml sitemap file.',
            'htmlSitemapVal.required_if'=>'Please enter address to the html sitemap.',


            'ogTitleMaxVal.required_if'=>'Please enter a value for maximum length of OG Title.',
            'ogTitleMinVal.required_if'=>'Please enter a value for minimum length of OG Title.',
            'maxUrlLengthVal.required_if'=>'Please enter a value for max URL length.',
            'maxUrlLengthVal.gte'=>'Max Length of a URL should be more than 0.',
            'maxUrlLengthVal.max'=>'The max URL length value must not be greater than 1000.',
            'maxUrlLengthVal.integer'=>'The max URL length value must be an integer.',

            'ogImageDimensionsLeastWidth.required_if'=>'Please enter a value for minimum width of OG image.',
            'ogImageDimensionsLeastWidth.max'=>'Minimum Width of OG image must not be greater than 100000.',
            'ogImageDimensionsLeastWidth.gte'=>'Minimum Width of OG image has to be greater than 0.',
            'ogImageDimensionsLeastWidth.integer'=>'Minimum Width of OG image must be an integer.',
            'ogImageDimensionsLeastHeight.required_if'=>'Please enter a value for minimum height of OG image.',
            'ogImageDimensionsLeastHeight.max'=>'Minimum Height of OG image must not be greater than 100000.',
            'ogImageDimensionsLeastHeight.gte'=>'Minimum Height of OG image has to be greater than 0.',
            'ogImageDimensionsLeastHeight.integer'=>'Minimum Height of OG image must be an integer.',

            'ogImageDimensionsExactWidth.required_if'=>'Please enter a value for exact width of OG image.',
            'ogImageDimensionsExactWidth.max'=>'Exact Width of OG image must not be greater than 100000.',
            'ogImageDimensionsExactWidth.gte'=>'Exact Width of OG image has to be greater than 0.',
            'ogImageDimensionsExactWidth.integer'=>'Exact Width of OG image must be an integer.',
            'ogImageDimensionsExactHeight.required_if'=>'Please enter a value for exact height of OG image.',
            'ogImageDimensionsExactHeight.max'=>'Exact Height of OG image must not be greater than 100000.',
            'ogImageDimensionsExactHeight.gte'=>'Exact Height of OG image has to be greater than 0.',
            'ogImageDimensionsExactHeight.integer'=>'Exact Height of OG image must be an integer.',

            'ogUrlMaxVal.required_if'=>'Please enter a value for max OG URL length.',
            'ogUrlMaxVal.gte'=>'Max Length of OG URL should be more than 0.',
            'ogUrlMaxVal.max'=>'The max OG URL length value must not be greater than 1000.',
            'ogUrlMaxVal.integer'=>'The max OG URL length value must be an integer.',

            'excludedWordsCasingVal.required_if'=>'You need to enter at least one word.',
        ]);

        // performance
        $validator->sometimes('googleInsightsDesktopVal', ['integer', 'max:100', 'gte:1'], function ($input) {
            return $input->googleInsightsDesktop == true;
        });
        $validator->sometimes('googleInsightsMobileVal', ['integer', 'max:100', 'gte:1'], function ($input) {
            return $input->googleInsightsMobile == true;
        });

        $validator->sometimes('googlePerformanceDesktopVal', ['integer', 'max:100', 'gte:1'], function ($input) {
            return $input->googlePerformanceDesktop == true;
        });
        $validator->sometimes('googlePerformanceMobileVal', ['integer', 'max:100', 'gte:1'], function ($input) {
            return $input->googlePerformanceMobile == true;
        });

        $validator->sometimes('googleAccessibilityDesktopVal', ['integer', 'max:100', 'gte:1'], function ($input) {
            return $input->googleAccessibilityDesktop == true;
        });
        $validator->sometimes('googleAccessibilityMobileVal', ['integer', 'max:100', 'gte:1'], function ($input) {
            return $input->googleAccessibilityMobile == true;
        });

        $validator->sometimes('googleBestPracticesDesktopVal', ['integer', 'max:100', 'gte:1'], function ($input) {
            return $input->googleBestPracticesDesktop == true;
        });
        $validator->sometimes('googleBestPracticesMobileVal', ['integer', 'max:100', 'gte:1'], function ($input) {
            return $input->googleBestPracticesMobile == true;
        });

        $validator->sometimes('googleSeoDesktopVal', ['integer', 'max:100', 'gte:1'], function ($input) {
            return $input->googleSeoDesktop == true;
        });
        $validator->sometimes('googleSeoMobileVal', ['integer', 'max:100', 'gte:1'], function ($input) {
            return $input->googleSeoMobile == true;
        });

        // core web vitals
        $validator->sometimes('googleLCPDesktopVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleLCPDesktop == true;
        });
        $validator->sometimes('googleLCPMobileVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleLCPMobile == true;
        });
        $validator->sometimes('googleFCPDesktopVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleFCPDesktop == true;
        });
        $validator->sometimes('googleFCPMobileVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleFCPMobile == true;
        });
        $validator->sometimes('googleCLSDesktopVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleCLSDesktop == true;
        });
        $validator->sometimes('googleCLSMobileVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleCLSMobile == true;
        });
        $validator->sometimes('googleFIDDekstopVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleFIDDekstop == true;
        });
        $validator->sometimes('googleFIDMobileVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleFIDMobile == true;
        });
        $validator->sometimes('googleTBTDesktopVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleTBTDesktop == true;
        });
        $validator->sometimes('googleTBTMobileVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleTBTMobile == true;
        });
        $validator->sometimes('googleTTIDesktopVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleTTIDesktop == true;
        });
        $validator->sometimes('googleTTIMobileVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleTTIMobile == true;
        });
        $validator->sometimes('googleSIDesktopVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleSIDesktop == true;
        });
        $validator->sometimes('googleSIMobileVal', ['numeric', 'max:1000', 'min:0'], function ($input) {
            return $input->googleSIMobile == true;
        });



        // meta title
        $validator->sometimes('titleMaxLengthVal', ['integer', 'max:1000', 'gte:1'], function ($input) {
            return $input->titleMaxLength == true;
        });

        $validator->sometimes('titleMinLengthVal', ['integer', 'max:1000', 'gte:1', function($attribute, $value, $fail) use($data){
            if( $value > $data["titleMaxLengthVal"] ){
                return $fail(__('Minimum length of Title can not be greater than maximum length'));
            }
        }], function ($input) {
            return $input->titleMinLength == true;
        });



        // meta desc
        $validator->sometimes('metaDescLengthMaxVal', ['integer', 'max:1000', 'gte:1'], function ($input) {
            return $input->metaDescLengthMax == true;
        });

        $validator->sometimes('metaDescLengthMinVal', ['integer', 'max:1000', 'gte:1', function($attribute, $value, $fail) use($data){
            if( $value > $data["metaDescLengthMaxVal"] ){
                return $fail(__('Minimum length of Meta Description can not be greater than maximum length'));
            }
        }], function ($input) {
            return $input->metaDescLengthMin == true;
        });


        // url
        $validator->sometimes('maxUrlLengthVal', ['integer', 'max:1000', 'gte:1'], function ($input) {
            return $input->maxUrlLength == true;
        });




        // og title
        $validator->sometimes('ogTitleMaxVal', ['integer', 'max:1000', 'gte:1'], function ($input) {
            return $input->ogTitleMax == true;
        });

        $validator->sometimes('ogTitleMinVal', ['integer', 'max:1000', 'gte:1', function($attribute, $value, $fail) use($data){
            if( $value > $data["ogTitleMaxVal"] ){
                return $fail(__('Minimum length of OG Title can not be greater than maximum length'));
            }
        }], function ($input) {
            return $input->ogTitleMin == true;
        });






        // og desc
        $validator->sometimes('OgDescMaxVal', ['integer', 'max:1000', 'gte:1'], function ($input) {
            return $input->OgDescMax == true;
        });

        $validator->sometimes('OgDescMinVal', ['integer', 'max:1000', 'gte:1', function($attribute, $value, $fail) use($data){
            if( $value > $data["OgDescMaxVal"] ){
                return $fail(__('Minimum length of Title can not be greater than maximum length'));
            }
        }], function ($input) {
            return $input->OgDescMin == true;
        });


         // og url
         $validator->sometimes('ogUrlMaxVal', ['integer', 'max:1000', 'gte:1'], function ($input) {
            return $input->ogUrlMax == true;
        });



        // og image
        $validator->sometimes(['ogImageDimensionsLeastWidth', 'ogImageDimensionsLeastHeight'], ['integer', 'max:100000', 'gte:1'], function ($input) {
            return $input->ogImageDimensionsLeast == true;
        });
        $validator->sometimes(['ogImageDimensionsExactWidth', 'ogImageDimensionsExactHeight'], ['integer', 'max:100000', 'gte:1'], function ($input) {
            return $input->ogImageDimensionsExact == true;
        });



        // twitter image
        $validator->sometimes(['twitterImageWidthMin', 'twitterImageHeightMin'], ['integer', 'max:100000', 'gte:1'], function ($input) {
            return $input->twitterImageDimensionsMin == true;
        });
        $validator->sometimes(['twitterImageWidthExact', 'twitterImageHeightExact'], ['integer', 'max:100000', 'gte:1'], function ($input) {
            return $input->twitterImageDimensionsExact == true;
        });



        // twitter title
        $validator->sometimes('twitterTitleLengthMaxVal', ['integer', 'max:1000', 'gte:1'], function ($input) {
            return $input->twitterTitleLengthMax == true;
        });

        $validator->sometimes('twitterTitleLengthMinVal', ['integer', 'max:1000', 'gte:1', function($attribute, $value, $fail) use($data){
            if( $value > $data["twitterTitleLengthMaxVal"] ){
                return $fail(__('Minimum length of Title can not be greater than maximum length'));
            }
        }], function ($input) {
            return $input->twitterTitleLengthMin == true;
        });


        // og url
        $validator->sometimes('twitterImageAltMaxVal', ['integer', 'max:1000', 'gte:1'], function ($input) {
            return $input->twitterImageAltMax == true;
        });


        // favicon
        $validator->sometimes(['faviconWidthMin', 'faviconHeightMin'], ['integer', 'max:1000000', 'gte:1'], function ($input) {
            return $input->faviconDimensionsMin == true;
        });
        $validator->sometimes(['faviconWidthExact', 'faviconHeightExact'], ['integer', 'max:1000000', 'gte:1'], function ($input) {
            return $input->faviconDimensionsExact == true;
        });


        // xml sitemap
        $validator->sometimes('xmlSitemapVal', ['url', function($attribute, $value, $fail) use($data, $projectUrl, $projectUrlOrigin, $helpers){
            if(!$helpers->isLinkSameAsOrigin($value, $projectUrlOrigin)){
                $msg = "This URL does not exist in the website address - "  . $projectUrl;
                return $fail(__($msg));
            }
        }], function ($input) {
            return $input->isXmlSitemap == true;
        });
 

        // html sitemap
        $validator->sometimes('htmlSitemapVal', ['url', function($attribute, $value, $fail) use($data, $projectUrl, $projectUrlOrigin, $helpers){
            if(!$helpers->isLinkSameAsOrigin($value, $projectUrlOrigin)){
                $msg = "This URL does not exist in the website address - "  . $projectUrl;
                return $fail(__($msg));
            }
        }], function ($input) {
            return $input->isHtmlSitemap == true;
        });
      

        // images
        $validator->sometimes('maximumFileSizeVal', ['integer', 'max:100099', 'gte:1'], function ($input) {
            return $input->maximumFileSize == true;
        });
        $validator->sometimes('imageNameLengthVal', ['integer', 'max:1000', 'gte:1'], function ($input) {
            return $input->imageNameLength == true;
        });


       if( !$validator->passes() ){
           return response()->json(['status'=>0,'msg'=>$validator->errors()->toArray()]);
       }else{
            $settings = projectSettings::find($id);
            $settings->meta_title = $data["switchMetaTitle"];
            $settings->meta_desc = $data["switchMetaDesc"];
            $settings->robots_meta = $data["switchRobotsMeta"];
            $settings->canonical_url = $data["switchCanonical"];
            $settings->url_slug = $data["switchUrlSlug"];
            $settings->open_graph_tags = $data["switchOgTitle"];
            $settings->twitter_tags = $data["switchTwitterTitle"];
            $settings->favicon = $data["switchFavicon"];
            $settings->xml_sitemap = $data["switchXML"];
            $settings->html_sitemap = $data["switchHTML"];
            $settings->images = $data["switchImages"];
            $settings->html_compression = $data["switchHTMLCompression"];
            $settings->css_compression = $data["switchCSSCompression"];
            $settings->js_compression = $data["switchJSCompression"];
            $settings->gzip_compression = $data["switchGZIPCompression"];
            $settings->google_overall = $data["switchGoogleOverall"];
            $settings->google_lighthouse = $data["switchGoogleLighthouse"];
            $settings->core_web_vitals = $data["switchCoreWebVitals"];
            
            $settings->meta_viewport = $data["switchViewport"];
            $settings->frameset = $data["switchFrameset"];
            $settings->doctype = $data["switchDoctype"];
            $settings->http_status_code = $data["switchHttpStatusCode"];
            $settings->page_size = $data["switchPageSize"];
            $settings->hsts_header = $data["switchHSTS"];
            $settings->nested_tables = $data["switchNestedTables"];
            $settings->content_security_policy_header = $data["switchContentSecurityPolicyHeader"];
            $settings->x_frame_options_header = $data["switchXFrameOptionsHeader"];
            $settings->ssl_certificate_enable = $data["switchSSLCertificateEnableHeader"];
            $settings->folder_browsing_enable = $data["switchFolderBrowsingEnableHeader"];
            $settings->bad_content_type = $data["switchBadContentTypeHeader"];
            $settings->css_caching_enable = $data["switchCssCachingEnableHeader"];
            $settings->js_caching_enable = $data["switchJsCachingEnableHeader"];
            $settings->mobile_friendly = $data["switchMobileFriendly"];

        
            $settings->is_safe_browsing = $data["switchIsSafeBrowsingHeader"];
            $settings->protocol_relative_resource = $data["switchProtocolRelativeResourceHeader"];
            $settings->cross_origin_links = $data["switchCrossOriginLinksHeader"];
            $settings->h1_heading_tag = $data["switchH1HeadingTag"];
            $settings->robot_text_test = $data["switchRobotTxtTestHeader"];
            $settings->broken_links = $data["switchBrokenLinksHeader"];
            

            // meta title
            $settingsSub = SettingsSub::where("project_settings_id", $settings->id)->get()->first();
            $settingsSub->meta_title = $data["isMetaTitle"];
            $settingsSub->max_title_length = $data["titleMaxLength"];
            $settingsSub->max_title_length_val = $data["titleMaxLengthVal"];
            $settingsSub->min_title_length = $data["titleMinLength"];
            $settingsSub->min_title_length_val = $data["titleMinLengthVal"];
            $settingsSub->is_title_equal_h1 = $data["titleEquaH1"];
            $settingsSub->title_casing_both = $data["casingBoth"];
            $settingsSub->title_casing_camel = $data["casingCamel"];
            $settingsSub->title_casing_sentence = $data["casingSentence"];
            $settingsSub->is_excluded_words = $data["excludedWordsCasing"];
            $settingsSub->excluded_words = $data["excludedWordsCasingVal"];
        

            // meta desc
            $settingsSub->meta_desc = $data["isMetaDesc"];
            $settingsSub->max_desc_length = $data["metaDescLengthMax"];
            $settingsSub->max_desc_length_val = $data["metaDescLengthMaxVal"];
            $settingsSub->min_desc_length = $data["metaDescLengthMin"];
            $settingsSub->min_desc_length_val = $data["metaDescLengthMinVal"];


            // robots meta
            // $settingsSub->staging_urls_robots_meta = $data["stagingRobotsMeta"];
            $settingsSub->live_urls_robots_meta = $data["liveRobotsMeta"];


            // canonical
            $settingsSub->canonical_url = $data["canonicalUrl"];
            $settingsSub->canonical_url_equal_url = $data["canonicalEqualUrl"];
            $settingsSub->canonical_url_ignore_slash = $data["canonicalIgnoreSlash"];



            // url
            $settingsSub->url_slug_lowercase = $data["UrlLowercase"];
            $settingsSub->url_no_numbers = $data["UrlNoNumbers"];
            $settingsSub->url_no_special = $data["UrlNoSpecial"];
            $settingsSub->max_url_length = $data["maxUrlLength"];
            $settingsSub->max_url_length_val = $data["maxUrlLengthVal"];
            $settingsSub->url_casing_only_hyphens = $data["UrlOnlyHyphens"];
            $settingsSub->url_casing_only_underscores = $data["UrlOnlyUnderscores"];
            $settingsSub->url_casing_both = $data["UrlBoth"];
            $settingsSub->url_stop_words = $data["UrlStopWords"];
            $settingsSub->url_stop_words_val = $data["UrlStopWordsVal"];

            
            // og title
            $settingsSub->og_title = $data["isOgTitle"];
            $settingsSub->max_og_title_length = $data["ogTitleMax"];
            $settingsSub->max_og_title_length_val = $data["ogTitleMaxVal"];
            $settingsSub->min_og_title_length = $data["ogTitleMin"];
            $settingsSub->min_og_title_length_val = $data["ogTitleMinVal"];
            $settingsSub->is_og_title_equal_title = $data["ogTitleEqualTitle"];
            $settingsSub->og_title_casing_sentence = $data["ogTitleCasingSentence"];
            $settingsSub->og_title_casing_camel = $data["ogTitleCasingCamel"];
            $settingsSub->og_title_casing_both = $data["ogTitleCasingBoth"];


            // og desc
            $settingsSub->og_desc = $data["isOgDesc"];
            $settingsSub->max_og_desc_length = $data["OgDescMax"];
            $settingsSub->max_og_desc_length_val = $data["OgDescMaxVal"];
            $settingsSub->min_og_desc_length = $data["OgDescMin"];
            $settingsSub->min_og_desc_length_val = $data["OgDescMinVal"];


            // og image
            $settingsSub->og_image = $data["isOgImage"];
            $settingsSub->og_image_dimensions_min = $data["ogImageDimensionsLeast"];
            $settingsSub->og_image_width_min = $data["ogImageDimensionsLeastWidth"];
            $settingsSub->og_image_height_min = $data["ogImageDimensionsLeastHeight"];
            $settingsSub->og_image_dimensions_exact = $data["ogImageDimensionsExact"];
            $settingsSub->og_image_width_exact = $data["ogImageDimensionsExactWidth"];
            $settingsSub->og_image_height_exact = $data["ogImageDimensionsExactHeight"];

            
            // og_url
            $settingsSub->og_url = $data["isOgUrl"];
            $settingsSub->is_og_url_equal_url = $data["ogUrlEqualUrl"];
            $settingsSub->max_og_url_length = $data["ogUrlMax"];
            $settingsSub->max_og_url_length_val = $data["ogUrlMaxVal"];

            
            // twitter title
            $settingsSub->twitter_title = $data["isTwitterTitle"];
            $settingsSub->max_twitter_title_length = $data["twitterTitleLengthMax"];
            $settingsSub->max_twitter_title_length_val = $data["twitterTitleLengthMaxVal"];
            $settingsSub->min_twitter_title_length = $data["twitterTitleLengthMin"];
            $settingsSub->min_twitter_title_length_val = $data["twitterTitleLengthMinVal"];
            $settingsSub->is_twitter_title_equal_title = $data["twitterTitleEqualTitle"];
            $settingsSub->twitter_title_casing_sentence = $data["twitterTitleCasingSentence"];
            $settingsSub->twitter_title_casing_camel = $data["twitterTitleCasingCamel"];
            $settingsSub->twitter_title_casing_both = $data["twitterTitleCasingBoth"];


            // twitter image
            $settingsSub->twitter_image = $data["isTwitterImage"];
            $settingsSub->twitter_image_dimensions_min = $data["twitterImageDimensionsMin"];
            $settingsSub->twitter_image_width_min = $data["twitterImageWidthMin"];
            $settingsSub->twitter_image_height_min = $data["twitterImageHeightMin"];
            $settingsSub->twitter_image_dimensions_exact = $data["twitterImageDimensionsExact"];
            $settingsSub->twitter_image_width_exact = $data["twitterImageWidthExact"];
            $settingsSub->twitter_image_height_exact = $data["twitterImageHeightExact"];


            // twitter alt
            $settingsSub->twitter_image_alt = $data["isTwitterImageAlt"];
            $settingsSub->max_twitter_image_alt_length = $data["twitterImageAltMax"];
            $settingsSub->max_twitter_image_alt_length_val = $data["twitterImageAltMaxVal"];

            // favicon
            $settingsSub->favicon = $data["isFavicon"];
            $settingsSub->favicon_dimensions_min = $data["faviconDimensionsMin"];
            $settingsSub->favicon_width_min = $data["faviconWidthMin"];
            $settingsSub->favicon_height_min = $data["faviconHeightMin"];
            $settingsSub->favicon_dimensions_exact = $data["faviconDimensionsExact"];
            $settingsSub->favicon_width_exact = $data["faviconWidthExact"];
            $settingsSub->favicon_height_exact = $data["faviconHeightExact"];


            // xml sitemap
            $settingsSub->xml_sitemap = $data["isXmlSitemap"];
            if($data["isXmlSitemapCustom"]){
                $settingsSub->xml_sitemap_val = $data["xmlSitemapVal"];
            }

            // html sitemap
            $settingsSub->html_sitemap = $data["isHtmlSitemap"];
            if($data["isHtmlSitemapCustom"]){
                $settingsSub->html_sitemap_val = $data["htmlSitemapVal"];
            }

            // meta viewport
            $settingsSub->meta_viewport = $data["isMetaViewport"];

            // frameset
            $settingsSub->no_frameset = $data["isFrameset"];

            // doctype
            $settingsSub->doctype = $data["isDoctype"];

            // http status
            $settingsSub->http_status_code_accepted = $data["http_status_code_accepted"];

            // HSTS
            $settingsSub->hsts_header = $data["isHSTS"];

            // page size
            $settingsSub->page_size = $data["pageSize"];
            $settingsSub->page_size_val = $data["pageSizeVal"];

            // Nested Tables
            $settingsSub->no_nested_tables = $data["noNestedTables"];

            // Content Security Policy Header
            $settingsSub->content_security_policy_header = $data["IsContentSecurityPolicyHeader"];

            // X Frame Options Header
            $settingsSub->x_frame_options_header = $data["IsXFrameOptionsHeader"];

            // ssl certificate
            $settingsSub->ssl_certificate_enable = $data["isSSLCertificateEnableType"];

            //Folder Browsing
            $settingsSub->folder_browsing_enable = $data["isFolderBrowsingEnable"];

            // bad content type
            $settingsSub->bad_content_type = $data["isBadContentType"];

            // css caching
            $settingsSub->css_caching_enable = $data["isCssCachingEnable"];

            // js caching
            $settingsSub->js_caching_enable = $data["isJsCachingEnable"];

            // mobile friendly
            $settingsSub->mobile_friendly = $data["isMobileFriendly"];

            // images
            $settingsSub->image_max_size = $data["maximumFileSize"];
            $settingsSub->image_max_size_val = $data["maximumFileSizeVal"];
            $settingsSub->image_name_only_hyphens = $data["imageNameHyphen"];
            $settingsSub->image_name_no_uppercase = $data["imageNameUppercase"];
            $settingsSub->image_name_no_special = $data["imageNameSpecial"];
            $settingsSub->image_name_max_characters = $data["imageNameLength"];
            $settingsSub->image_name_max_characters_val = $data["imageNameLengthVal"];
            $settingsSub->image_alt = $data["imageAlt"];
            $settingsSub->image_alt_only_spaces = $data["imageAltSpaces"];

            // html compression
            $settingsSub->is_html_compression = $data["htmlCompression"];

            // css compression
            $settingsSub->is_css_compression = $data["cssCompression"];

            // js compression
            $settingsSub->is_js_compression = $data["jsCompression"];

            // gzip compression
            $settingsSub->is_gzip_compression = $data["gzipCompression"];

            // google insights
            $settingsSub->google_insights_desktop = $data["googleInsightsDesktop"];
            $settingsSub->google_insights_desktop_val = $data["googleInsightsDesktop"];
            $settingsSub->google_insights_mobile = $data["googleInsightsMobile"];
            $settingsSub->google_insights_mobile_val = $data["googleInsightsMobileVal"];

            // google lighthouse
            $settingsSub->google_insights_desktop = $data["googleInsightsDesktop"];
            $settingsSub->google_insights_desktop_val = $data["googleInsightsDesktopVal"];
            $settingsSub->google_insights_mobile = $data["googleInsightsMobile"];
            $settingsSub->google_insights_mobile_val = $data["googleInsightsMobileVal"];
            
            $settingsSub->google_performance_desktop = $data["googlePerformanceDesktop"];
            $settingsSub->google_performance_desktop_val = $data["googlePerformanceDesktopVal"];
            $settingsSub->google_performance_mobile = $data["googlePerformanceMobile"];
            $settingsSub->google_performance_mobile_val = $data["googlePerformanceMobileVal"];

            $settingsSub->google_best_practices_desktop = $data["googleBestPracticesDesktop"];
            $settingsSub->google_best_practices_desktop_val = $data["googleBestPracticesDesktopVal"];
            $settingsSub->google_best_practices_mobile = $data["googleBestPracticesMobile"];
            $settingsSub->google_best_practices_mobile_val = $data["googleBestPracticesMobileVal"];

            $settingsSub->google_accessibility_desktop = $data["googleAccessibilityDesktop"];
            $settingsSub->google_accessibility_desktop_val = $data["googleAccessibilityDesktopVal"];
            $settingsSub->google_accessibility_mobile = $data["googleAccessibilityMobile"];
            $settingsSub->google_accessibility_mobile_val = $data["googleAccessibilityMobileVal"];

            $settingsSub->google_seo_desktop = $data["googleSeoDesktop"];
            $settingsSub->google_seo_desktop_val = $data["googleSeoDesktopVal"];
            $settingsSub->google_seo_mobile = $data["googleSeoMobile"];
            $settingsSub->google_seo_mobile_val = $data["googleSeoMobileVal"];

            // google core web vitals
            $settingsSub->google_fcp_desktop = $data["googleFCPDesktop"];
            $settingsSub->google_fcp_desktop_val = $data["googleFCPDesktopVal"];
            $settingsSub->google_fcp_mobile = $data["googleFCPMobile"];
            $settingsSub->google_fcp_mobile_val = $data["googleFCPMobileVal"];
            
            $settingsSub->google_lcp_desktop = $data["googleLCPDesktop"];
            $settingsSub->google_lcp_desktop_val = $data["googleLCPDesktopVal"];
            $settingsSub->google_lcp_mobile = $data["googleLCPMobile"];
            $settingsSub->google_lcp_mobile_val = $data["googleLCPMobileVal"];

            $settingsSub->google_cls_desktop = $data["googleCLSDesktop"];
            $settingsSub->google_cls_desktop_val = $data["googleCLSDesktopVal"];
            $settingsSub->google_cls_mobile = $data["googleCLSMobile"];
            $settingsSub->google_cls_mobile_val = $data["googleCLSMobileVal"];

            $settingsSub->google_fid_desktop = $data["googleFIDDesktop"];
            $settingsSub->google_fid_desktop_val = $data["googleFIDDesktopVal"];
            $settingsSub->google_fid_mobile = $data["googleFIDMobile"];
            $settingsSub->google_fid_mobile_val = $data["googleFIDMobileVal"];

            $settingsSub->google_tbt_desktop = $data["googleTBTDesktop"];
            $settingsSub->google_tbt_desktop_val = $data["googleTBTDesktopVal"];
            $settingsSub->google_tbt_mobile = $data["googleTBTMobile"];
            $settingsSub->google_tbt_mobile_val = $data["googleTBTMobileVal"];

            $settingsSub->google_tti_desktop = $data["googleTTIDesktop"];
            $settingsSub->google_tti_desktop_val = $data["googleTTIDesktopVal"];
            $settingsSub->google_tti_mobile = $data["googleTTIMobile"];
            $settingsSub->google_tti_mobile_val = $data["googleTTIMobileVal"];

            $settingsSub->google_speed_index_desktop = $data["googleSIDesktop"];
            $settingsSub->google_speed_index_desktop_val = $data["googleSIDesktopVal"];
            $settingsSub->google_speed_index_mobile = $data["googleSIMobile"];
            $settingsSub->google_speed_index_mobile_val = $data["googleSIMobileVal"];


            $settingsSub->is_safe_browsing = $data["isSafeBrowsingEnable"];
            $settingsSub->protocol_relative_resource = $data["isProtocolRelativeResourceEnable"];
            $settingsSub->cross_origin_links = $data["isCrossOriginLinksEnable"];
            $settingsSub->broken_links = $data["isBrokenLinksEnable"];
            $settingsSub->broken_links_exclude_urls = $data["brokenLinksExcludeUrls"];
            // $settingsSub->broken_links_excluded_urls = $data["addBrokenLinksExcludedVal"];

            // Robot.txt test
            $settingsSub->robot_text_test_block_url = $data["isRobotTextTestBlockUrlEnable"];
            
            // H1 heading test
            $settingsSub->h1_heading_tag = $data["isH1HeadingTagEnable"];
            $settingsSub->h1_heading_tag_length_val = $data["h1HeadingTagLengthVal"];
            $settingsSub->h1_heading_tag_length = $data["h1HeadingTagLength"];

            $settingsSub->h2_heading_tag_length = $data["h2HeadingTagLength"];
            $settingsSub->h2_heading_tag_length_val = $data["h2HeadingTagLength"];
            $settingsSub->h3_heading_tag_length = $data["h3HeadingTagLength"];
            $settingsSub->h3_heading_tag_length_val = $data["h3HeadingTagLength"];
            $settingsSub->h4_heading_tag_length = $data["h4HeadingTagLength"];
            $settingsSub->h4_heading_tag_length_val = $data["h4HeadingTagLength"];
            $settingsSub->h5_heading_tag_length = $data["h5HeadingTagLength"];
            $settingsSub->h5_heading_tag_length_val = $data["h5HeadingTagLength"];
            $settingsSub->h6_heading_tag_length = $data["h6HeadingTagLength"];
            $settingsSub->h6_heading_tag_length_val = $data["h6HeadingTagLength"];


            $settingsState = $settings->save();
            $settingsSubState = $settingsSub->save();

            if($settingsState && $settingsSubState){
                return response()->json(['status'=>1,'msg'=>'Settings updated successfully']);
            }else{
                return response()->json(['status'=>0,'msg'=>'There was an error while updating settings, please try again later.']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
