<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\CustomURL;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Illuminate\Support\Facades\Session;
use App\Models\Projects;
use App\Models\TestResults;
use App\Models\projectSettings;
use App\Models\SettingsSub;
use App\Mail\EmailReportMail;
use Helper;
use Illuminate\Support\Facades\Http;
use Exception;
use Auth;
use Illuminate\Support\Facades\Cookie;

class TestController extends Controller
{
    private $crawler;

    public function collect(Request $request){
        $helpers = new Helper();
        $data = $request->input('data');
        $validator = \Validator::make($data,[
            'urlValue'=>['required', new CustomURL],
        ],[
            'urlValue.required'=>'URL is required.',
        ]);

       if( !$validator->passes() ){
           return response()->json(['status'=>0,'msg'=>$validator->errors()->toArray()]);
       }else{
            // $data["urlValue"] = $helpers->removeQueryParams($data["urlValue"]);
            $failedUrls = [];
            $failedStatus = [404,'404'];
            Session::forget('google_page_speed_desktop');
            Session::forget('google_page_speed_mobile');
            Session::forget('project');
            Session::forget('settings');


            // HTTP STATUS CODE ---
            $client = HttpClient::create([
                'timeout' => 60,
                'max_redirects' => 0, // prevent following redirects
            ]);
            
            try {
                $response = $client->request('GET', $data["urlValue"]);
                $statusCode = $response->getStatusCode();
            } catch (RedirectionExceptionInterface $e) {
                // This block is hit if there's a 3xx redirect
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
            }
            // END HTTP STATUS CODE ---
            

            $goutteClient = new Client(HttpClient::create(['timeout' => 60]));
            $crawler = $goutteClient->request('GET', $data["urlValue"]);
            $contentType = $goutteClient->getResponse()->getHeader('Content-Type');
            Session::put('contentType', $contentType);

            if(in_array($statusCode, $failedStatus)){ 
                $result =  [
                    'status' => 0,
                    'failed' => $data["urlValue"],
                ];
                return $result;
            } else {
                $pathInfo = pathinfo($data["urlValue"]);
                if(isset($pathInfo['extension'])) {
                $extension = strtolower($pathInfo['extension']);
                // List of common file extensions
                $fileExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'zip', 'rar', '7z', 'mp3', 'mp4', 'avi', 'mov', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'];

                // Check if the extension corresponds to a file
                if (in_array($extension, $fileExtensions)) {
                    $result =  [
                        'status' => 2,
                        'failed' => $data["urlValue"],
                        'msg' => 'Sorry, but we can not test a '. $extension .' document.'
                    ];
                    return $result;
                    }
                }
            }

            if($data["project"] === "default"){
                $settings = projectSettings::where("type", "default")->with("settingsSub")->get()->first();
                Session::put('settings', json_encode($settings));
            }else if($data["project"] === "bulk" || $data["project"] === "analysis"){
                $settings = $data["settingsVal"];
                Session::put('settings', json_encode($settings));
                if(isset($data["bulkUrl"])) {
                    Session::put('bulkUrl', $data["bulkUrl"]);
                }
            }else{
                $data = $request->input('data');
                 $parsedUrl = parse_url($data["urlValue"]);
                 $normalizeUrl = strtolower($parsedUrl['host']); 
                 
                 $cookies = Cookie::get();
                if (!isset($_COOKIE["remember_cookie_".Auth::id()]) && !isset($_COOKIE["test_cookie_".Auth::id()])) { 
                    $projectCount = Projects::where("user_id", Auth::id())
                    ->whereRaw("LOWER(homepage) LIKE ?", ["%" . $normalizeUrl . "%"])
                    ->count();
                    if($projectCount == 0) {
                        return response()->json(['status'=>11,'count'=>$projectCount]);
                    } 
                }else {
                    if (isset($_COOKIE['test_cookie_'.Auth::id()])) {
                        unset($_COOKIE['test_cookie_'.Auth::id()]);
                    }
                    Cookie::queue(Cookie::forget('test_cookie_'.Auth::id()));
                }
                

                $project = Projects::find($data["project"]);
                $settings = projectSettings::where("projects_id", $data["project"])->with("settingsSub")->get()->first();
                Session::put('project', json_encode($project));
                Session::put('settings', json_encode($settings));
            }

           

            if(!in_array($statusCode, $failedStatus)){
                
                $html = $crawler->html();
                Session::put('html_code', $html);
                Session::put('http_status_code', $statusCode);
                $internalResponse = $statusCode = $goutteClient->getInternalResponse();
                Session::put('internal_response', $internalResponse);

                $meta = $crawler->filter("table,frameset,title,meta,link[rel='canonical'],link[rel='icon'],a,img,link[rel='stylesheet'],script")->each(function($node) {
                    $name = $node->attr('name');
                    $content = $node->attr('content');
                    if($name === null){
                        $name = $node->getNode(0)->tagName;
                    }
                    if($name === "meta"){
                        $name = $node->attr('property');
                    }
                    if($content === null){
                        $content = $node->getNode(0)->textContent;
                    }

                    if($name === "link"){
                        $name = $node->extract(array('rel'))[0];
                        $content = $node->extract(array('href'))[0];
                    }

                    if($name === "a"){
                        $content = $node->extract(array('href'))[0];
                    }

                    if($name === "img"){
                        $content = [
                            'src' => $node->attr('src') != "" ? $node->attr('src') : $node->attr('data-src'),
                            'alt' => $node->attr('alt')
                        ];
                    }

                    if($name === "script"){
                        $content = $node->extract(array('src'))[0];
                    }

                    if($name === "table"){
                        $content = $node->html();
                    }

                    return [
                        'name' => $name,
                        'content' => $content,
                    ];
                });


                if(isset($data["saveInDB"])){
                    $ref_id = $helpers->generateRandomString();
                    $test = new TestResults();
                    $test->url = $data["urlValue"];
                    $test->testLabels = $data["testLabels"];
                    $test->ref_id = $ref_id;
                    $test->data = json_encode($meta);
                    $test->html_code = $html;
                    $test->http_user_agent = '';
                    $test->save();
                    return response()->json(['status'=>1,'ref_id'=>$ref_id]);
                }else{
                    $result =  [
                        'status' => 1,
                        'response' => $meta,
                    ];
                    echo json_encode($result);
                }

            }
        }
    }



    public function emailReport(Request $request){
        $data["name"] = $request->file_name;
        $data["message"] = $request->message;
        $data["link"] = $request->link;
        $data["subject"] = $request->subject;
        $emails = $request->emails;
        foreach($emails as $email){
            \Mail::to($email)->send(new EmailReportMail($data));
        }

        return response()->json(['status'=>1,'msg'=>'Email sent successfully.']);
    }

    public function getAnalysis(Request $request){
        $helpers = new Helper();
        $id = $request->input('ref_id');

        $test = TestResults::where("ref_id", $id)->get()->first();
        return response()->json(['status'=>1,'data'=>$test]);
    }

    public function nestedTables(Request $request){
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');

        $noNested = $settings->settings_sub->no_nested_tables;


        $title = "Nested Tables";
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $message = "Nested Tables check excluded.";
  
        $tables = isset($data["links"]) ? $data["links"] : [];

        if($noNested){
            $message = "HTML Page does not consist of Nested Tables.";
            if($helpers->nestedTablesExist($tables)){
                $status = false;     
                $message = "HTML Page consists of Nested Tables.";
            }
        }
   


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Nested Tables";
        $object->parentCard = "codingBestPractices";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function httpStatusCode(Request $request){
        $helpers = new Helper();

        $status = true;
        $isExists = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $httpCode = session()->get('http_status_code');
        $httpCodeName = $helpers->getHttpStatusName($httpCode);
        $httpAllowed = $settings->settings_sub->http_status_code_accepted;
        $httpAllowedArray = explode(",",$httpAllowed);


        $title = "HTTP Status Code";
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $message = "Your webpage returned an HTTP Status Code - " . $httpCode . " " . $httpCodeName . ".";
  


        if(!in_array($httpCode, $httpAllowedArray)){
            $status = false;     
        }




        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->isExists = $isExists;
        $object->httpCode = $httpCode;
        $object->httpCodeName = $httpCodeName;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "HTTP Status Code";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function contentSecurity(Request $request){
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $contentSecurityVal = $internalResponse->getHeader('Content-Security-Policy');

        $isContentSecurity = $settings->settings_sub->content_security_policy_header;


        $title = "Content Security Policy Header";
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $message = "Content Security Policy Header check excluded.";
  

        if($isContentSecurity){
            $message = "Content Security Policy Header is enabled.";
            if($contentSecurityVal == ""){
                $status = false;     
                $message = "Content Security Policy Header is not enabled.";
            }
        }
   


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Content Security Policy Header";
        $object->parentCard = "security";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function XFrameOptions(Request $request){
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $xFrameVal = $internalResponse->getHeader('X-Frame-Options');

        $isXFrame = $settings->settings_sub->x_frame_options_header;


        $title = "X Frame Options Header";
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $message = "X Frame Options Header check excluded.";
  

        if($isXFrame){
            $message = "X Frame Options Header is enabled.";
            if($xFrameVal == ""){
                $status = false;     
                $message = "X Frame Options Header is not enabled.";
            }
        }
   


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "X Frame Options Header";
        $object->parentCard = "security";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function hstsHeader(Request $request){
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $hstsVal = $internalResponse->getHeader('Strict-Transport-Security');

        $isHSTS = $settings->settings_sub->hsts_header;


        $title = "HSTS Header";
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $message = "HSTS Header check excluded.";
  

        if($isHSTS){
            $message = "HSTS Header is enabled.";
            if($hstsVal == ""){
                $status = false;     
                $message = "HSTS Header is not enabled.";
            }
        }
   


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "HSTS Header";
        $object->parentCard = "security";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function pageSize(Request $request){
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $contentLength = $helpers->convertBytesToKb($internalResponse->getHeader('Content-Length')); // converting bytes to KBs
        $contentLengthUnits = $helpers->formatSizeUnits($internalResponse->getHeader('Content-Length')); // converting bytes to units

        $isPageSize = $settings->settings_sub->page_size;
        $pageSizeVal = $settings->settings_sub->page_size_val;


        $title = "HTML Page Size";
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $message = "HTML Page Size check excluded.";
  

        if($isPageSize){
            $message = "HTML Page Size(" . $contentLengthUnits . ") is less than the maximum limit.";
            if($contentLength > $pageSizeVal){
                $status = false;
                $message = "HTML Page Size(" . $contentLengthUnits . ") exceeds the maximum limit.";
            }
        }
   


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->contentLengthUnits = $contentLengthUnits;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "HTML Page Size";
        $object->parentCard = "codingBestPractices";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function doctype(Request $request){
        $helpers = new Helper();

        $status = true;
        $isExists = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');

        $isDoctype = $settings->settings_sub->doctype;


        $title = "Doctype";
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $message = "Doctype validation check excluded.";
  
        if(!$helpers->doctypeExists($html)){
            $isExists = false;     
        }

        if($isDoctype){
            $message = "Your webpage is using a Doctype tag.";
            if(!$helpers->doctypeExists($html)){
                $status = false;     
                $message = "Your webpage is not using a Doctype tag.";
            }
        }
   


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->isExists = $isExists;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Doctype";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function frameset(Request $request){
        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));

        $isFrameset = $settings->settings_sub->no_frameset;


        $title = "Frameset";
        $content = isset($data["name"]) ? isset($data["name"]) : null;
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $message = "Frameset tag check excluded.";
  

        if($isFrameset){
            $message = "Your webpage is not using a frameset tag.";
            if($content != null){
                $status = false;     
                $message = "Your webpage is using a frameset tag.";
            }
        }
   


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Frameset";
        $object->parentCard = "codingBestPractices";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function metaViewport(Request $request){
        $status = true;
        $problems = [];
        $isExists = true;
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));

        $isViewport = $settings->settings_sub->meta_viewport;


        $title = "Meta Viewport";
        $content = $data["content"];
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $message = "Your webpage is using a Meta Viewport tag";
  
        if($content === "" || $content === null){ // for dashboard
            $isExists = false;     
        }

        if($isViewport){
            if($content === "" || $content === null){
                $status = false;     
                $message = "Meta Viewport tag either does not exist or is empty";
            }
        }
   


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->isExists = $isExists;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Meta Viewport";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function title(Request $request){
        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));

        $isTitle = $settings->settings_sub->meta_title;
        $isMax = $settings->settings_sub->max_title_length;
        $isMin = $settings->settings_sub->min_title_length;
        $max = $settings->settings_sub->max_title_length_val;
        $min = $settings->settings_sub->min_title_length_val;
        $titleCasingCamel = $settings->settings_sub->title_casing_camel;
        $titleCasingBoth = $settings->settings_sub->title_casing_both;
        $titleCasingSentence = $settings->settings_sub->title_casing_sentence;
        $isExcludedWords = $settings->settings_sub->is_excluded_words;
        $excludedWords = $settings->settings_sub->excluded_words;
        $excludedWordsVal = "";
        if($isExcludedWords){
            $excludedWordsVal = $excludedWords;
        }

        $title = "Meta Title";
        $content = $data["content"];
        $description = "A meta title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $message = "Your webpage is using a title tag";
        $length = strlen($content);
        $lengthClass = "result_pass";
        $casingStatus = true;
        $showContent = true;
        $showSnippet = true;
        $tagStatus = true;

        if($isTitle){
            if($content === "" || $content === null){
                $status = false;
                $casingStatus = false;
                $showContent = false;
                $tagStatus = false;        
                $message = "Title tag either does not exist or is empty";
            }
        }
        if($status){
            if($isMax){
                if($length > $max){
                    $status = false;
                    array_push($problems, "Title tag is more than " . $max . " characters.");
                    $lengthClass = "result_fail";
                }
            }
            if($isMin){
                if($length < $min){
                    $status = false;
                    array_push($problems, "Title tag is less than " . $min . " characters.");
                    $lengthClass = "result_fail";
                }
            }
        };


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = $showContent;
        $object->snippetContent = "This is how the content of meta title will appear in Google search.";
        $object->showSnippet = $showSnippet;
        $object->tagStatus = $tagStatus;
        $object->casingStatus = $casingStatus;
        $object->lengthClass = $lengthClass;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Title Tag";
        $object->titleCasingCamel = intval($titleCasingCamel);
        $object->titleCasingBoth = intval($titleCasingBoth);
        $object->titleCasingSentence = intval($titleCasingSentence);
        $object->excludedWordsVal = $excludedWordsVal;
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }



    public function description(Request $request){
        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));

        $isDesc = $settings->settings_sub->meta_desc;
        $isMax = $settings->settings_sub->max_desc_length;
        $isMin = $settings->settings_sub->min_desc_length;
        $max = $settings->settings_sub->max_desc_length_val;
        $min = $settings->settings_sub->min_desc_length_val;
        $title = "Meta Description";
        $content = $data["content"];
        $description = "Meta description refers to an HTML attribute that acts as a descriptor on organic search results to provide a brief summary of a web page. Usually shown directly below the title tag on search engines, the meta description is your chance to describe the page's content and give searchers a reason to click";
        $message = "Your webpage is using a meta description tag";
        $length = strlen($content);
        $lengthClass = "result_pass";
        $casingStatus = true;
        $showContent = true;
        $showSnippet = true;
        $tagStatus = true;

        if($isDesc){
            if($content === "" || $content === null){
                $status = false;
                $casingStatus = false;
                $showContent = false;
                $tagStatus = false;      
                $message = "Meta Description tag either does not exist or is empty";
            }
        }
        if($status){
            if($isMax){
                if(strlen($content) > $max){
                    $status = false;
                    array_push($problems, "Meta Description tag is more than " . $max . " characters.");
                    $lengthClass = "result_fail";
                }
            }
            if($isMin){
                if(strlen($content) < $min){
                    $status = false;
                    array_push($problems, "Meta Description tag is less than " . $min . " characters.");
                    $lengthClass = "result_fail";
                }
            }
        };


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = $showContent;
        $object->snippetContent = "This is how the content of meta description will appear in Google search.";
        $object->showSnippet = $showSnippet;
        $object->tagStatus = $tagStatus;
        $object->casingStatus = false;
        $object->lengthClass = $lengthClass;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Meta Description Tag";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function canonical(Request $request){
        $status = true;
        $statusIsEqualURL = null;
        
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];

        $isCanonical = $settings->settings_sub->canonical_url;
        $isCanonicalEqualUrl = $settings->settings_sub->canonical_url_equal_url;
        $isCanonicalIgnoreSlash = $settings->settings_sub->canonical_url_ignore_slash;
        $title = "Canonical URL";
        $content = $data["content"];
        $description = "A canonical tag (rel=canonical) is a snippet of HTML code that defines the main version for duplicate, near-duplicate and similar pages.";
        $message = "Your webpage is using a canonical link tag";
        $url = $urlValue;
        $canonicalURL = $content;
        


        if($isCanonical){
            if($content === "" || $content === null){
                $status = false;
                $message = "Canonical tag is missing or canonical tag is empty.";
            }
        }
        if($status){
            if($isCanonicalEqualUrl){
                $statusIsEqualURL = true;

                if($isCanonicalIgnoreSlash){
                    $url = rtrim($urlValue, '/');
                    $canonicalURL = rtrim($content, '/');
                }

                if($canonicalURL != $url){
                    $status = false;
                    $statusIsEqualURL = false;
                    array_push($problems, "Canonical URL is not exactly the same with the actual URL.");
                }
            }
        };

        if($content === "" || $content === null){
            $content = "-";
        }


        $object = new \stdClass();
        $object->status = $status;
        $object->statusIsEqualURL = $statusIsEqualURL;
        $object->title = $title;
        $object->status = $status;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function robots(Request $request){
        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];
        $pageType = "live";

        $robotsLive = $settings->settings_sub->live_urls_robots_meta;
        $title = "Robots Meta";
        $content = strtolower($data["content"]);
        $description = "A Robots meta tag provide crawlers specific instructions on how to crawl or index web page content. The Noindex tag tells a search engine not to index a page and the Nofollow tag tells a search engine not to follow any links on a page or pass along any link equity.";
        $message = "Your webpage is not using a Robots Meta Tag";
        $isExists = false;
        $contentExists = $content != "" ? true : false;

        if($content === "noindex, nofollow" || $content === "noindex,nofollow"){
            $isExists = true;
            $message = "Your webpage is using a Robots Meta Tag";
        }

        if($robotsLive){
            if($pageType === "live"){
                if(!$isExists){
                    $status = true;
                    $message = "Noindex,Nofollow does not exist.";
                }else{
                    $status = false;
                    $message = "Noindex,Nofollow meta tag exists.";
                }
            }
        }


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->isExists = $isExists;
        $object->contentExists = $contentExists;
        $object->description = $description;
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function urlSlug(Request $request){
        $helpers = new Helper();
        $status = true;
        $exists = true;
        $statusLowercase = true;
        $statusHyphens = true;
        $statusSpecial = true;
        $statusNumbers = true;
        $statusUnderscore = true;
        $statusStopWords = true;

        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));

        $urlValue = $data["urlValue"];
        $urlSlugLowercase = $settings->settings_sub->url_slug_lowercase;
        $urlNoNumbers = $settings->settings_sub->url_no_numbers;
        $urlNoSpecial = $settings->settings_sub->url_no_special;
        $maxUrlLength = $settings->settings_sub->max_url_length;
        $maxUrlLengthVal = $settings->settings_sub->max_url_length_val;
        $urlCasingOnlyHyphens = $settings->settings_sub->url_casing_only_hyphens;
        $urlCasingOnlyUnderscores = intval($settings->settings_sub->url_casing_only_underscores);
        $urlCasingBoth = $settings->settings_sub->url_casing_both;
        $urlStopWords = $settings->settings_sub->url_stop_words;
        $urlStopWordsVal = $settings->settings_sub->url_stop_words_val;
        $title = "URL Slug";
        $content = "";
        if(isset(parse_url($urlValue)["path"])){
            $path = parse_url($urlValue)["path"];
            $content = substr($path, strpos($path, '/') + 1);
        }

        $description = "A URL slug refers to the end part of a URL after the backslash that identifies the specific page or post. Each slug on your web pages needs to be unique, and they provide readers and search engines with information about the content of a page.";
        $message = "URL Slug has no issues.";
        $length = strlen($content);
        $lengthClass = "result_pass";
        $lowercaseClass = "result_pass";
        $numbersClass = "result_pass";
        $specialClass = "result_pass";
        $hyphenClass = "result_pass";
        $underscoreClass = "result_pass";
        $stopWordsClass = "result_pass";

        $showContent = true;
        $tagStatus = true;

        if(strlen($content) === 0){
            $status = true;
            $tagStatus = false;
            $showContent = false;
            $exists = false;
            $message = "You have tested the root domain, so there isn't a URL slug available.";
        }else{
            if($urlSlugLowercase){
                if($helpers->hasUppercase($content)){
                    $status = false;
                    $statusLowercase = false;
                    array_push($problems, "URL Slug contains uppercase characters.");
                }
            }
            if($urlNoNumbers){
                if($helpers->hasNumbers($content)){
                    $status = false;
                    $statusNumbers = false;
                    array_push($problems, "URL Slug contains numbers.");
                }
            }
            if($urlNoSpecial){
                if($helpers->hasSpecial($content)){
                    $status = false;
                    $statusSpecial = false;
                    array_push($problems, "URL Slug contains special characters.");
                }
            }
            if($maxUrlLength){
                if(strlen($content) > $maxUrlLengthVal){
                    $status = false;
                    array_push($problems, "Length of URL Slug is more than " . $maxUrlLengthVal . " characters.");
                    $lengthClass = "result_fail";
                }
            }
            if($urlCasingOnlyHyphens){
                if(!$helpers->onlyHyphen($content)){
                    $status = false;
                    $statusHyphens = false;
                    array_push($problems, "Words in URL slug are not separated by hyphens.");
                }
            }

         
            if($urlCasingOnlyUnderscores){
                if(str_contains($content, "-") || str_contains($content, "/") || count(explode(" ", $content)) > 1){
                    $status = false;
                    $statusUnderscore = false;
                    array_push($problems, "Words in URL slug are not separated by underscores.");
                }
            }
            // if($urlCasingBoth){
            //     if(str_contains($content, "-")){
            //         $status = false;
            //         $statusUnderscore = false;
            //         array_push($problems, "Words in URL slug are not separated by underscores.");
            //     }

            //     if(str_contains($content, "_")){
            //         $status = false;
            //         $statusHyphens = false;
            //         array_push($problems, "Words in URL slug are not separated by hyphens.");
            //     }
            // }
            if($urlStopWords){
                $urlStopWordsArr = explode(",",$urlStopWordsVal);
                $status1 = true;
                foreach($urlStopWordsArr as $word){
                    if(str_contains($content, $word)){
                        $status1 = false;
                    }
                }
                if(!$status1){
                    $status = false;
                    $statusStopWords = false;
                    array_push($problems, "URL slug contains stop words specified by you in project settings.");
                }
            }
        }


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->exists = $exists;
        $object->status = $status;
        $object->statusLowercase = $statusLowercase;
        $object->statusHyphens = $statusHyphens;
        $object->statusSpecial = $statusSpecial;
        $object->statusNumbers = $statusNumbers;
        $object->statusUnderscore = $statusUnderscore;
        $object->statusStopWords = $statusStopWords;

        $object->lowercaseClass = $lowercaseClass;
        $object->numbersClass = $numbersClass;
        $object->specialClass = $specialClass;
        $object->hyphenClass = $hyphenClass;
        $object->underscoreClass = $underscoreClass;
        $object->stopWordsClass = $stopWordsClass;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = $showContent;
        $object->tagStatus = $tagStatus;
        $object->casingStatus = false;
        $object->lengthClass = $lengthClass;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "URL Slug";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function ogTags(Request $request){
        $helpers = new Helper();

        $status = true;
        $statusTitle = true;
        $statusDesc = true;
        $statusURL = true;
        $statusImage = true;

        $isEqualStatus = true;
        $isEqualDescStatus = true;
        $isEqualURLStatus = true;

        $dimensions = null;

        $problems = [];
        $problemsDesc = [];
        $problemsImage = [];
        $problemsURL = [];

        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];
        $urlParse = parse_url($urlValue);
        $domain = $urlParse["scheme"] . "://" . $urlParse["host"];
        $contentImage  = '';

        $isTitle = $settings->settings_sub->og_title;
        $isMax = $settings->settings_sub->max_og_title_length;
        $isMin = $settings->settings_sub->min_og_title_length;
        $max = $settings->settings_sub->max_og_title_length_val;
        $min = $settings->settings_sub->min_og_title_length_val;
        $isEqualTitle = $settings->settings_sub->is_og_title_equal_title;
        $titleCasingCamel = $settings->settings_sub->og_title_casing_camel;
        $titleCasingBoth = $settings->settings_sub->og_title_casing_both;
        $titleCasingSentence = $settings->settings_sub->og_title_casing_sentence;
        $excludedWordsVal = "";
        $titleContent = $data['metaContent']["content"];
        $title = "Open Graph Tags";
        $message = "Your webpage is
        using all the open graph tags.";
        $description = "Open Graph tags are structured markup that you can add to your HTML documents to gain control of the snippets that are shown when your URLs are shared on social media platforms like Facebook, LinkedIn, Twitter, and apps like Slack, WhatsApp and Telegram.<br><br>The og: title is how you define your content's title. It serves a similar purpose as the traditional meta title tag in your code.";
        $content = $data["content"];
        $contentDesc = $data["ogDesc"]["content"] ?? '';
        $contentImage = $data["ogImage"]["content"] ?? '';
        $contentURL = $data["ogURL"]["content"] ?? '';
        $contentURL = $contentURL != "" ? $helpers->getAbsolutePath($contentURL, $domain) : "";

        $casingStatus = true;
        $showContent = true;
        $tagStatus = true;
        $length = strlen($content);
        $lengthClass = "result_pass";
        $isEqualClass = "result_pass";
        $messageTitle = "No problems found.";

        $lengthDesc = strlen($content);
        $lengthDescClass = "result_pass";
        $isEqualDescClass = "result_pass";
        $messageDesc = "No problems found.";

        $showImage = true;
        $lengthImageClass = "result_pass";
        $widthImageClass = "result_pass";;
        $heightImageClass = "result_pass";;
        $messageImage = "No problems found.";

        $lengthURL = strlen($content);
        $lengthURLClass = "result_pass";
        $isEqualURLClass = "result_pass";
        $messageURL = "No problems found.";


        // title
        if($content != $titleContent){
            $isEqualStatus = false;
        } 

        if($isTitle){
            if($content === "" || $content === null){
                $status = false;
                $statusTitle = false;
                $casingStatus = false;
                $showContent = false;
                $tagStatus = false;            
                $messageTitle = "OG Title tag either does not exist or is empty";
            }
        }

        if($status){
            if($isMax){
                if($length > $max){
                    $status = false;
                    $statusTitle = false;
                    array_push($problems, "OG Title tag is more than " . $max . " characters.");
                    $lengthClass = "result_fail";
                }
            }
            if($isMin){
                if($length < $min){
                    $status = false;
                    $statusTitle = false;
                    array_push($problems, "OG Title tag is less than " . $min . " characters.");
                    $lengthClass = "result_fail";
                }
            }
            if($isEqualTitle){
                if($content != $titleContent){
                    $status = false;
                    $statusTitle = false;
                    $isEqualClass = "result_fail";
                    array_push($problems, "OG Title is not exactly the same with the title.");
                }    
            }
        }

        // desc
        $isDesc = $settings->settings_sub->og_desc;
        $isMaxDesc = $settings->settings_sub->max_og_desc_length;
        $isMinDesc = $settings->settings_sub->min_og_desc_length;
        $maxDesc = $settings->settings_sub->max_og_desc_length_val;
        $minDesc = $settings->settings_sub->min_og_desc_length_val;
        $isEqualDesc = $settings->settings_sub->is_og_desc_equal_desc;

        if($content != $contentDesc){
            $isEqualDescStatus = false;
        }

        if($isDesc){
            if($contentDesc === "" || $contentDesc === null){
                $status = false;
                $statusDesc = false;
                $messageDesc = "OG Description tag either does not exist or is empty";
            }
        }

        if($statusDesc){
            if($isMaxDesc){
                if($lengthDesc > $maxDesc){
                    $status = false;
                    array_push($problemsDesc, "OG Description tag is more than " . $max . " characters.");
                    $lengthDescClass = "result_fail";
                }
            }
            if($isMinDesc){
                if($lengthDesc < $minDesc){
                    $status = false;
                    $statusDesc = false;
                    array_push($problemsDesc, "OG Description tag is less than " . $min . " characters.");
                    $lengthDescClass = "result_fail";
                }
            }
            if($isEqualDesc){
                if($content != $descContent){
                    $status = false;
                    $statusDesc = false;
                    $isEqualDescClass = "result_fail";
                    array_push($problemsDesc, "OG Description is not exactly the same with the meta description.");
                }
            }
        };

        // og image
        $isOgImage = $settings->settings_sub->og_image;
        $ogImageDimensionsMin = $settings->settings_sub->og_image_dimensions_min;
        $ogImageWidthMin = $settings->settings_sub->og_image_width_min;
        $ogImageHeightMin = $settings->settings_sub->og_image_height_min;
        $ogImageDimensionsExact = $settings->settings_sub->og_image_dimensions_exact;
        $ogImageWidthExact = $settings->settings_sub->og_image_width_exact;
        $ogImageHeightExact = $settings->settings_sub->og_image_height_exact;

        if($isOgImage){
            if($contentImage === "" || $contentImage === null){
                $status = false;
                $statusImage = false;
                $showImage = false;
                $messageDesc = "OG Image tag either does not exist or is empty";
            }

            if(!$helpers->isValidUrl($contentImage)){
                $status = false;
                $statusImage = false;
                $showImage = false;
                $messageDesc = "OG Image tag either does not exist or is empty";
            }
        }

        if($statusImage){
            list($width, $height) = getimagesize($contentImage); 
            $dimensions = array('h' => $height, 'w' => $width );
            if($ogImageDimensionsMin){
                if($dimensions['w'] < $ogImageWidthMin){
                    $status = false;
                    $statusImage = false;
                    array_push($problemsImage, "Width of OG Image is less than " . $ogImageWidthMin . " pixels.");
                    $lengthImageClass = "result_fail";
                    $widthImageClass = "result_fail";
                }
                if($dimensions['h'] < $ogImageHeightMin){
                    $status = false;
                    $statusImage = false;
                    array_push($problemsImage, "Height of OG Image is less than " . $ogImageHeightMin . " pixels.");
                    $lengthImageClass = "result_fail";
                    $heightImageClass = "result_fail";
                }
            }
            if($ogImageDimensionsExact){
                if($dimensions['w'] != $ogImageWidthExact){
                    $status = false;
                    $statusImage = false;
                    array_push($problemsImage, "Width of OG Image is not equal to " . $ogImageWidthExact . " pixels.");
                    $lengthImageClass = "result_fail";
                    $widthImageClass = "result_fail";
                }
                if($dimensions['h'] != $ogImageHeightExact){
                    $status = false;
                    $statusImage = false;
                    array_push($problemsImage, "Height of OG Image is not equal to " . $ogImageHeightExact . " pixels.");
                    $lengthImageClass = "result_fail";
                    $heightImageClass = "result_fail";
                }
            }
        }

        // URL
        $isUrl = $settings->settings_sub->og_url;
        $isMaxUrl = $settings->settings_sub->max_og_url_length;
        $maxUrl = $settings->settings_sub->max_og_url_length_val;
        $isEqualUrl = $settings->settings_sub->is_og_url_equal_url;

        if($contentURL != $urlValue){
            $isEqualURLStatus = false;
        }

        if($isUrl){
            if($contentURL === "" || $contentURL === null){
                $status = false;
                $statusURL = false;
                $showContent = false;
                $tagStatus = false;
                $messageURL = "OG URL tag either does not exist or is empty";
            }
        }

        if($statusURL){
            if($isMaxUrl){
                if($lengthURL > $maxUrl){
                    $status = false;
                    $statusURL = false;
                    array_push($problemsURL, "Length of OG URL tag is more than " . $max . " characters.");
                    $lengthURLClass = "result_fail";
                }
            }
            if($isEqualUrl){
                if($contentURL != $urlValue){
                    $status = false;
                    $statusURL = false;
                    $isEqualURLClass = "result_fail";
                    array_push($problemsURL, "OG URL is not exactly the same with the actual URL.");
                }
            }
        }


        $object = new \stdClass();
        $object->status = $status;
        // desc
        $object->statusDesc = $statusDesc;
        $object->isEqualDescStatus = $isEqualDescStatus;
        $object->contentDesc = $contentDesc;
        $object->problemsDesc = $problemsDesc;
        $object->messageDesc = $messageDesc;
        $object->lengthDescClass = $lengthDescClass;
        $object->isEqualDescClass = $isEqualDescClass;

        // image
        $object->statusImage = $statusImage;
        $object->contentImage = $contentImage;
        $object->problemsImage = $problemsImage;
        $object->messageImage = $messageImage;
        $object->showImage = $showImage;
        $object->lengthImageClass = $lengthImageClass;
        $object->widthImageClass = $widthImageClass;
        $object->heightImageClass = $heightImageClass;
        $object->dimensions = $dimensions;

        // url
        $object->statusURL = $statusURL;
        $object->isEqualURLStatus = $isEqualURLStatus;
        $object->contentURL = $contentURL;
        $object->problemsURL = $problemsURL;
        $object->messageURL = $messageURL;
        $object->lengthURLClass = $lengthURLClass;
        $object->isEqualURLClass = $isEqualURLClass;

        // title
        $object->title = $title;
        $object->statusTitle = $statusTitle;
        $object->status = $status;
        $object->isEqualStatus = $isEqualStatus;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->messageTitle = $messageTitle;
        $object->description = $description;
        $object->showContent = $showContent;
        $object->tagStatus = $tagStatus;
        $object->casingStatus = $casingStatus;
        $object->lengthClass = $lengthClass;
        $object->isEqualClass = $isEqualClass;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "OG Title Tag";
        $object->name = "og_tags";
        $object->type = "title";
        $object->titleCasingCamel = intval($titleCasingCamel);
        $object->titleCasingBoth = intval($titleCasingBoth);
        $object->titleCasingSentence = intval($titleCasingSentence);
        $object->excludedWordsVal = $excludedWordsVal;
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function twitterTags(Request $request){
        $helpers = new Helper();

        $status = true;
        $statusTitle = true;
        $statusImage = true;
        $statusImageAlt = true;

        $isEqualStatus = true;

        $dimensions = null;

        
        $problems = [];
        $problemsImage = [];
        $problemsImageAlt = [];

        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));

        $isTitle = $settings->settings_sub->twitter_title;
        $isMax = $settings->settings_sub->max_twitter_title_length;
        $isMin = $settings->settings_sub->min_twitter_title_length;
        $max = $settings->settings_sub->max_twitter_title_length_val;
        $min = $settings->settings_sub->min_twitter_title_length_val;
        $isEqualTitle = $settings->settings_sub->is_twitter_title_equal_title;
        $titleCasingCamel = $settings->settings_sub->twitter_title_casing_camel;
        $titleCasingBoth = $settings->settings_sub->twitter_title_casing_both;
        $titleCasingSentence = $settings->settings_sub->twitter_title_casing_sentence;
        $excludedWordsVal = "";

        $urlValue = $data["urlValue"];
        $urlParse = parse_url($urlValue);
        $domain = $urlParse["scheme"] . "://" . $urlParse["host"];
        
        $titleContent = $data['metaContent']["content"];
        $title = "Twitter Tags";
        $content = $data["content"];
        $contentImage = $data["twitterImage"]["content"] ?? '';

        $contentImage = $contentImage != "" ? $helpers->getAbsolutePath($contentImage, $domain) : "";
        $contentImageAlt = isset($data["twitterImageAlt"]["content"]) ? $data["twitterImageAlt"]["content"] : '';

        $description = "Twitter Cards is a protocol used by Twitter to display content from your website on Twitter, when a link of your website is shared on Twitter.<br><br> Twitter:Title shows the Title of the page as the Title of the Twitter Post, when the link is shared on Twitter.";
        $message = "Your webpage is using all the twitter tags.";
        $messageTitle = "No problems found.";
        $length = strlen($content);
        $lengthClass = "result_pass";
        $isEqualClass = "result_pass";
        $casingStatus = true;
        $showContent = true;
        $tagStatus = true;

        // image
        $messageImage = "No problems found.";
        $isTwitterImage = $settings->settings_sub->twitter_image;
        $twitterImageDimensionsMin = $settings->settings_sub->twitter_image_dimensions_min;
        $twitterImageWidthMin = $settings->settings_sub->twitter_image_width_min;
        $twitterImageHeightMin = $settings->settings_sub->twitter_image_height_min;
        $twitterImageDimensionsExact = $settings->settings_sub->twitter_image_dimensions_exact;
        $twitterImageWidthExact = $settings->settings_sub->twitter_image_width_exact;
        $twitterImageHeightExact = $settings->settings_sub->twitter_image_height_exact;
        $lengthImage = strlen($content);
        $lengthImageClass = "result_pass";
        $widthImageClass = "result_pass";
        $heightImageClass = "result_pass";
        $showImage = true;

        // image alt
        $messageImageAlt = "No problems found.";
        $isAlt = $settings->settings_sub->twitter_image_alt;
        $isMaxImageAlt = $settings->settings_sub->max_twitter_image_alt_length;
        $maxImageAlt = $settings->settings_sub->max_twitter_image_alt_length_val;
        $lengthImageAlt = strlen($content);
        $lengthImageAltClass = "result_pass";



        // title
        if($content != $titleContent){
            $isEqualStatus = false;
        } 


        if($isTitle){
            if($content === "" || $content === null){
                $status = false;
                $statusTitle = false;
                $casingStatus = false;
                $showContent = false;
                $tagStatus = false;
                $message = "Twitter Title tag either does not exist or is empty";
            }
        }

        if($status){
            if($isMax){
                if($length > $max){
                    $status = false;
                    array_push($problems, "Twitter Title tag is more than " . $max . " characters.");
                    $lengthClass = "result_fail";
                }
            }
            if($isMin){
                if($length < $min){
                    $status = false;
                    array_push($problems, "Twitter Title tag is less than " . $min . " characters.");
                    $lengthClass = "result_fail";
                }
            }
            if($isEqualTitle){
                if($content != $titleContent){
                    $status = false;
                    $isEqualClass = "result_fail";
                    array_push($problems, "Twitter Title is not exactly the same with the title.");
                }    
            }
        }



        // image
        if($isTwitterImage){
            if($contentImage === "" || $contentImage === null){
                $status = false;
                $statusImage = false;
                $showImage = false;
                $messageImage = "Twitter Image tag either does not exist or is empty";
            }

            if(!$helpers->isValidUrl($contentImage)){
                $status = false;
                $statusImage = false;
                $showImage = false;
                $messageImage = "Twitter Image tag either does not exist or is empty";
            }
        }
        if($statusImage){
            list($width, $height) = getimagesize($contentImage); 
            $dimensions = array('h' => $height, 'w' => $width );
            if($twitterImageDimensionsMin){
                if($dimensions['w'] < $twitterImageWidthMin){
                    $status = false;
                    $statusImage = false;
                    array_push($problemsImage, "Width of Twitter Image is less than " . $twitterImageWidthMin . " pixels.");
                    $lengthImageClass = "result_fail";
                    $widthImageClass = "result_fail";
                }
                if($dimensions['h'] < $twitterImageHeightMin){
                    $status = false;
                    $statusImage = false;
                    array_push($problemsImage, "Height of Twitter Image is less than " . $twitterImageHeightMin . " pixels.");
                    $lengthImageClass = "result_fail";
                    $heightImageClass = "result_fail";
                }
            }
            if($twitterImageDimensionsExact){
                if($dimensions['w'] != $twitterImageWidthExact){
                    $status = false;
                    $statusImage = false;
                    array_push($problemsImage, "Width of Twitter Image is not equal to " . $twitterImageWidthExact . " pixels.");
                    $lengthImageClass = "result_fail";
                    $widthImageClass = "result_fail";
                }
                if($dimensions['h'] != $twitterImageHeightExact){
                    $status = false;
                    $statusImage = false;
                    array_push($problemsImage, "Height of Twitter Image is not equal to " . $twitterImageHeightExact . " pixels.");
                    $lengthImageClass = "result_fail";
                    $heightImageClass = "result_fail";
                }
            }
        }



        if($isAlt){
            if($contentImageAlt === "" || $contentImageAlt === null){
                $status = false;
                $statusImageAlt = false;
                $messageImageAlt = "Twitter Image Alt tag either does not exist or is empty";
            }
        }

        if($statusImageAlt){
            if($isMaxImageAlt){
                if(strlen($contentImageAlt) > $maxImageAlt){
                    $status = false;
                    $statusImageAlt = false;
                    array_push($problemsImageAlt, "Twitter Image Alt tag is more than " . $max . " characters.");
                    $lengthImageAltClass = "result_fail";
                }
            }
        };



        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;

        // image alt
        $object->statusImageAlt = $statusImageAlt;
        $object->contentImageAlt = $contentImageAlt;
        $object->problemsImageAlt = $problemsImageAlt;
        $object->messageImageAlt = $messageImageAlt;
        $object->lengthImageAltClass = $lengthImageAltClass;

        // image
        $object->statusImage = $statusImage;
        $object->contentImage = $contentImage;
        $object->problemsImage = $problemsImage;
        $object->messageImage = $messageImage;
        $object->showImage = $showImage;
        $object->lengthImageClass = $lengthImageClass;
        $object->widthImageClass = $widthImageClass;
        $object->heightImageClass = $heightImageClass;
        $object->dimensions = $dimensions;

        // title
        $object->statusTitle = $statusTitle;
        $object->isEqualStatus = $isEqualStatus;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->messageTitle = $messageTitle;
        $object->description = $description;
        $object->showContent = $showContent;
        $object->tagStatus = $tagStatus;
        $object->casingStatus = $casingStatus;
        $object->lengthClass = $lengthClass;
        $object->isEqualClass = $isEqualClass;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Twitter Title Tag";
        $object->name = "twitter_tags";
        $object->titleCasingCamel = intval($titleCasingCamel);
        $object->titleCasingBoth = intval($titleCasingBoth);
        $object->titleCasingSentence = intval($titleCasingSentence);
        $object->excludedWordsVal = $excludedWordsVal;
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }



    public function favicon(Request $request){
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];
        $urlParse = parse_url($urlValue);
        $domain = $urlParse["scheme"] . "://" . $urlParse["host"];

        $isFavicon = $settings->settings_sub->favicon;
        $faviconDimensionsMin = $settings->settings_sub->favicon_dimensions_min;
        $faviconWidthMin = $settings->settings_sub->favicon_width_min;
        $faviconHeightMin = $settings->settings_sub->favicon_height_min;
        $faviconDimensionsExact = $settings->settings_sub->favicon_dimensions_exact;
        $faviconWidthExact = $settings->settings_sub->favicon_width_exact;
        $faviconHeightExact = $settings->settings_sub->favicon_height_exact;
        $dimensions = null;

        $title = "Favicon";
        $content = $data["content"];
        $description = "A favicon is a small 16×16 pixel icon that serves as a branding element for your website. Its main purpose is to help visitors locate your page easier when they have multiple tabs open.<br><br>";
        $message = "Your webpage is using a Favicon tag";
        $length = strlen($content);
        $lengthClass = "result_pass";
        $showImage = true;


        $content = $helpers->getFavicon($urlValue);


        if($isFavicon){
            if($content === "" || $content === null){
                $status = false;
                $showImage = false;
                $message = "Favicon tag either does not exist or is empty";
            }

            if(!$helpers->isValidUrl($content)){
                $status = false;
                $showImage = false;
                $message = "Favicon tag either does not exist or is empty";
            }
        }
        if($status){
            list($width, $height) = getimagesize($content); 
            $dimensions = array('h' => $height, 'w' => $width );
            if($faviconDimensionsMin){
                if($dimensions['w'] < $faviconWidthMin){
                    $status = false;
                    array_push($problems, "Width of Favicon is less than " . $faviconWidthMin . " pixels.");
                    $lengthClass = "result_fail";
                }
                if($dimensions['h'] < $faviconHeightMin){
                    $status = false;
                    array_push($problems, "Height of Favicon is less than " . $faviconHeightMin . " pixels.");
                    $lengthClass = "result_fail";
                }
            }
            if($faviconDimensionsExact){
                if($dimensions['w'] != $faviconWidthExact){
                    $status = false;
                    array_push($problems, "Width of Favicon is not equal to " . $faviconWidthExact . " pixels.");
                    $lengthClass = "result_fail";
                }
                if($dimensions['h'] != $faviconHeightExact){
                    $status = false;
                    array_push($problems, "Height of Favicon is not equal to " . $faviconHeightExact . " pixels.");
                    $lengthClass = "result_fail";
                }
            }
        }


        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showImage = $showImage;
        $object->showContent = false;
        $object->tagStatus = false;
        $object->casingStatus = false;
        $object->lengthClass = $lengthClass;
        $object->dimensions = $dimensions;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Favicon";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function xmlSitemap(Request $request){
        $helpers = new Helper();
        $status = true;
        $fileExists = true;

        $problems = [];
        $data = $request->input('data');
        isset($data["sitemapContent"]) ? $statusSitemapGetValues = $data["sitemapContent"] : 0;

        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];
        $urlParse = parse_url($urlValue);
        $domain = $urlParse["scheme"] . "://" . $urlParse["host"];
        $urlValueTwo = preg_replace('#^(http(s)?://)?w{3}\.#', '$1', $domain);
        if(isset($data["sitemapContent"])){
            $isSitemap = true;
            $isSitemapVal = $data["xmlSitemap"];
        }else{
            $isSitemap = $settings->settings_sub->xml_sitemap;
            $isSitemapVal = $settings->settings_sub->xml_sitemap_val;
        }

        $title = "XML Sitemap";
        $content = $data["content"];
        $description = "An XML sitemap is a file that lists a website's important pages, making sure search engines can find and crawl them all. It also helps search engines understand your website structure. <br><br>An XML sitemap can help speed up content discovery, crawlability, and indexability.";
        $message = "XML Sitemap check excluded.";
        $xmldata = "";

        if($isSitemap){
            if(!$helpers->isValidUrl($isSitemapVal)){
                $status = false;
                $fileExists = false;

                $message = "XML Sitemap is missing, please make sure you have added the right sitemap file.";
            }else{
                $xmldata = @simplexml_load_file($isSitemapVal);
                if(!$xmldata){
                    $status = false;
                    $fileExists = false;

                    $message = "XML Sitemap is missing, please make sure you have added the right sitemap file.";
                }else{
                    $fileExists = true;

                    foreach($xmldata as $data){
                        if(strcmp($data->loc,$urlValue) === 0 || strcmp($data->loc,$urlValueTwo) === 0){
                            $status = true;
                            $message = "Page is added in XML Sitemap";
                            break;
                        }else{
                            $status = false;
                            $message = "Page is not added in XML Sitemap";
                        }
                    }
                }
            }
        }

        $statusA = 1;
        $object = new \stdClass();
        $object->status = $status;
        $object->fileExists = $fileExists;
        $object->title = $title;
        $object->status = $status;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = false;
        $object->tagStatus = false;
        $object->casingStatus = false;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "XML Sitemap";
        if(!isset($statusSitemapGetValues)){
            $object->settings = $settings->settings_sub;
        }
        $object->xmldata = $xmldata;

        echo json_encode($object);
    }
    
    public function xmlSitemapMultiple(Request $request) {
        $helpers = new Helper();
        $status = true;
        $fileExists = true;
    
        $problems = [];
        $data = $request->input('data');
        isset($data["sitemapContent"]) ? $statusSitemapGetValues = $data["sitemapContent"] : 0;
    
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];
        $urlParse = parse_url($urlValue);
        $domain = $urlParse["scheme"] . "://" . $urlParse["host"];
        $urlValueTwo = preg_replace('#^(http(s)?://)?w{3}\.#', '$1', $domain);
        
        $isSitemap = isset($data["sitemapContent"]) ? true : $settings->settings_sub->xml_sitemap;
        $isSitemapVal = isset($data["sitemapContent"]) ? $data["xmlSitemap"] : $settings->settings_sub->xml_sitemap_val;
    
        $multipleSitemap = isset($data["multipleSitemap"]) ? json_decode($data["multipleSitemap"], true) : [];
        
        $title = "XML Sitemap";
        $content = $data["content"];
        $description = "An XML sitemap is a file that lists a website's important pages, making sure search engines can find and crawl them all. It also helps search engines understand your website structure. <br><br>An XML sitemap can help speed up content discovery, crawlability, and indexability.";
        $message = "XML Sitemap check excluded.";
        $xmldata = [];
        $foundUrls = [];
    
        if ($isSitemap) {
            $sitemaps = $multipleSitemap ?: [$isSitemapVal];
    
            foreach ($sitemaps as $sitemapUrl) {
                if (!$helpers->isValidUrl($sitemapUrl)) {
                    $status = false;
                    $fileExists = false;
                    $message = "Invalid sitemap URL: $sitemapUrl.";
                    continue;
                }
    
                $sitemapData = @simplexml_load_file($sitemapUrl);
                if (!$sitemapData) {
                    $status = false;
                    $fileExists = false;
                    $message = "Failed to load sitemap from URL: $sitemapUrl.";
                    continue;
                }
    
                foreach ($sitemapData as $entry) {
                    $entryUrl = (string) $entry->loc;
    
                    // Exclude URLs ending with .xml
                    if (pathinfo(parse_url($entryUrl, PHP_URL_PATH), PATHINFO_EXTENSION) === 'xml') {
                        continue;
                    }
    
                    $foundUrls[] = $entryUrl;
    
                    if (strcmp($entryUrl, $urlValue) === 0 || strcmp($entryUrl, $urlValueTwo) === 0) {
                        $status = true;
                        $message = "Page is added in XML Sitemap";
                    }
                }
            }
    
            if (empty($foundUrls)) {
                $status = false;
                $message = "No URLs found in the provided sitemaps.";
            } else {
                $xmldata = $foundUrls;
            }
        }
    
        $statusA = 1;
        $object = new \stdClass();
        $object->status = $status;
        $object->fileExists = $fileExists;
        $object->title = $title;
        $object->status = $status;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = false;
        $object->tagStatus = false;
        $object->casingStatus = false;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "XML Sitemap";
        if (!isset($statusSitemapGetValues)) {
            $object->settings = $settings->settings_sub;
        }
        $object->xmldata = $xmldata;
    
        echo json_encode($object);
    }

    public function htmlSitemap(Request $request){
        $helpers = new Helper();
        $status = true;
        $fileExists = true;

        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];
        $urlParse = parse_url($urlValue);
        $domain = $urlParse["scheme"] . "://" . $urlParse["host"];
        $urlValueTwo = rtrim(str_replace("www.", "", $urlValue), "/");
        $isSitemap = $settings->settings_sub->html_sitemap;
        $sitemapVal = $settings->settings_sub->html_sitemap_val;

        $title = "HTML Sitemap";
        $description = "An HTML Sitemap is the same as an XML Sitemap, except that it is meant for actual users. An HTML Sitemap allows your site visitors to find all the content of a website from a single reference page. <br><br>HTML Sitemap is also used by search engines to crawl and index pages, which search engines cannot otherwise find and crawl.";
        $message = "HTML Sitemap check excluded.";


        if($isSitemap){
            if(!$helpers->isValidUrl($sitemapVal)){
                $status = false;
                $fileExists = false;
                $message = "HTML Sitemap is missing, please make sure you have added the right sitemap file.";
            }else{
                $goutteClient = new Client(HttpClient::create(['timeout' => 60]));
                $crawler = $goutteClient->request('GET', $sitemapVal);
                $links = $crawler->filter("a")->each(function($node){
                    return $node->extract(array('href'))[0];
                });

                if(count($links) > 0){
                    for($i=0;$i<count($links);$i++){
                        $content = $links[$i];
                        $link = $helpers->getAbsolutePath($content, $domain);
                        $linkCustom = str_replace("www.", "", $link);
                        if($linkCustom === $urlValueTwo){
                            $status = true;
                            $message = "Page is added in HTML Sitemap";
                            break;
                        }else{
                            $status = false;
                            $message = "Page is not added in HTML Sitemap";
                        }
                    }
                }else{
                    $status = false;
                    $fileExists = false;
                    $message = "HTML Sitemap is missing, please make sure you have added the right sitemap file.";
                }
            }
        }

        $object = new \stdClass();
        $object->status = $status;
        $object->fileExists = $fileExists;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = false;
        $object->tagStatus = false;
        $object->casingStatus = false;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "HTML Sitemap";
        $object->settings = $settings->settings_sub;
        // $object->links = $settings->links;
        echo json_encode($object);
    }


    public function images(Request $request){
        $helpers = new Helper();
        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));

        $images = isset($data["links"]) ? $data["links"] : [];
        $urlValue = $data["urlValue"];
        $urlParse = parse_url($urlValue);
        $domain = $urlParse["scheme"] . "://" . $urlParse["host"];
        $origin = explode('.', $urlParse["host"])[1];
        $imageMaxSize = $settings->settings_sub->image_max_size;
        $imageMaxSizeVal = $settings->settings_sub->image_max_size_val;
        $imageNameOnlyHyphens = $settings->settings_sub->image_name_only_hyphens;
        $imageNameNoUppercase = $settings->settings_sub->image_name_no_uppercase;
        $imageNameNoSpecial = $settings->settings_sub->image_name_no_special;
        $imageNameMaxCharacters = $settings->settings_sub->image_name_max_characters;
        $imageNameMaxCharactersVal = $settings->settings_sub->image_name_max_characters_val;
        $imageAltDB = $settings->settings_sub->image_alt;
        $imageAltOnlySpaces = $settings->settings_sub->image_alt_only_spaces;

        $title = "Images";
        $description = "Images make any content more interesting and appealing by helping readers understand your content better. Plus, images add value to your SEO efforts by increasing user engagement and accessibility of your website. There are a number of important factors that can be optimized to help improve image SEO on your site.<br><br>";
        $message = "Your webpage has no images.";

        // Counters for tracking image results
        $totalImages = 0;
        $passedImages = 0;
        $failedImages = 0;

        if(count($images) > 0){
            $totalImages = count($images);
            foreach($images as $image){
                // getting all values again
                $imageLengthStatus = true;
                $imageMaxSize = $settings->settings_sub->image_max_size;
                $imageMaxSizeVal = $settings->settings_sub->image_max_size_val;
                $imageNameOnlyHyphens = $settings->settings_sub->image_name_only_hyphens;
                $imageNameNoUppercase = $settings->settings_sub->image_name_no_uppercase;
                $imageNameNoSpecial = $settings->settings_sub->image_name_no_special;
                $imageNameMaxCharacters = $settings->settings_sub->image_name_max_characters;
                $imageNameMaxCharactersVal = $settings->settings_sub->image_name_max_characters_val;
                $imageAltDB = $settings->settings_sub->image_alt;
                $imageAltOnlySpaces = $settings->settings_sub->image_alt_only_spaces;

                // if($helpers->isLinkSameAsOrigin($image["content"]["src"], $origin)){
                $imageAltDB = $settings->settings_sub->image_alt;
                $imgSize = "";
                $imageProblems = [];
                $imageStatus = true;
                $imageHyphenStatus = true;
                $imageUppercaseStatus = true;
                $imageSpecialStatus = true;
                $imageAltSpacesStatus = true;

                $content = $image["content"];
                $imageAlt = $content["alt"];
                $imageSrc = $helpers->removeParams($content["src"]);
                $imageSrc = $helpers->getAbsolutePath($imageSrc, $domain);
                $imageName = substr($imageSrc, strrpos($imageSrc, '/') + 1);
                // if($helpers->isSVG($imageName)){
                //     $imageAltDB = false;
                //     $imageNameOnlyHyphens = false;
                //     $imageNameNoUppercase = false;
                //     $imageNameNoSpecial = false;
                //     $imageNameMaxCharacters = false;
                //     $imageLengthStatus = false;
                //     $imageName = "Since it's an SVG, there is no file name.";
                // }


                $imageNameLength = strlen($imageName);
                $imageNameClass = "result_pass";
                $imageAltClass = "result_pass";
                $imageSizeClass = "result_pass";
                $imageHyphenClass = "result_pass";
                $imageLengthClass = "result_pass";
                $imageUppercaseClass = "result_pass";
                $imageSpecialClass = "result_pass";
                $imageAltSpacesClass = "result_pass";

            
                if(!$helpers->onlyHyphen($imageName)){
                    $imageHyphenStatus = false;
                }
                if($helpers->hasUppercase($imageName) == 0){
                    $imageUppercaseStatus = false;
                }
             
                if($helpers->hasSpecialImages($imageName) == 0){
                    $imageSpecialStatus = false;
                }

                if(!$helpers->onlySpaces($imageAlt)){
                    $imageAltSpacesStatus = false;
                }

                $imageAlt = $imageAlt == null ? "" : $imageAlt;
               


                
                if($imageMaxSize){
                    $imgDetails = @get_headers($imageSrc, 1);
                    // Check if headers were successfully retrieved
                    if ($imgDetails === false) {
                        continue;
                    }
                    if(isset($imgDetails["Content-Length"])){
                        $imgSize = (int)$imgDetails["Content-Length"];
                        if($imgSize > 0){
                            $imgSize = round($imgSize / 1024, 2);
                        }
                    }else{
                        $imgSize = 0;
                    }
                    // $imgSize = 1000;

                    if($imgSize > $imageMaxSizeVal){
                        $imageStatus = false;
                        $status = false;
                        $imageNameClass = "result_fail";
                        $imageSizeClass = "result_fail";
                        $issueMsg = "Image file size exceeds " . $imageMaxSizeVal . " KB";
                        array_push($imageProblems, $issueMsg);
                    }
                }else{

                }

                if($imageNameOnlyHyphens){
                    if(!$helpers->onlyHyphen($imageName)){
                        $imageStatus = false;
                        $status = false;
                        $imageNameClass = "result_fail";
                        $imageHyphenClass = "result_fail";
                        array_push($imageProblems, "Words in file name must be separated by hyphens.");
                    }
                } 

                if($imageNameNoUppercase){
                    if($helpers->hasUppercase($imageName)){
                        $imageStatus = false;
                        $status = false;
                        $imageNameClass = "result_fail";
                        $imageUppercaseClass = "result_fail";
                        array_push($imageProblems, "Image file name has uppercase characters.");
                    }
                } 

                
                if($imageNameNoSpecial){
                    if($helpers->hasSpecialImages($imageName)){
                        $imageStatus = false;
                        $status = false;
                        $imageNameClass = "result_fail";
                        $imageSpecialClass = "result_fail";
                        array_push($imageProblems, "Image file name has special characters.");
                    }
                } 
// dd($imageStatus, $imageName);
                if($imageNameMaxCharacters){
                    if($imageNameLength > $imageNameMaxCharactersVal){
                        $imageStatus = false;
                        $status = false;
                        $imageNameClass = "result_fail";
                        $imageLengthClass = "result_fail";
                        array_push($imageProblems, "Image file name length exceeds maximum limit of " . $imageNameMaxCharactersVal . " characters.");
                    }
                }

                if($imageAltDB){
                    if($imageAlt === "" || $imageAlt === null){
                        $imageStatus = false;
                        $status = false;
                        $imageAltClass = "result_fail";
                        array_push($imageProblems, "Alternate text either does not exist or is empty.");
                    }else{
                        if($imageAltOnlySpaces){
                            if(!$helpers->onlySpaces($imageAlt)){
                                $imageStatus = false;
                                $status = false;
                                $imageAltClass = "result_fail";
                                $imageAltSpacesClass = "result_fail";
                                array_push($imageProblems, "Words in alternate text are not separated by spaces.");
                            }
                        }
                    }
                }

                // Count passed/failed images
                if($imageStatus) {
                    $passedImages++;
                } else {
                    $failedImages++;
                }

                $imageDetail = [
                    'status' => $imageStatus,
                    'imageHyphenStatus' => $imageHyphenStatus,
                    'imageUppercaseStatus' => $imageUppercaseStatus,
                    'imageSpecialStatus' => $imageSpecialStatus,
                    'imageAltSpacesStatus' => $imageAltSpacesStatus,

                    'imageSize' => $imageStatus,
                    'imageSizeClass' => $imageSizeClass,
                    'imageProblems' => $imageProblems,
                    'imageAlt' => $imageAlt,
                    'imageSrc' => $imageSrc,
                    'imageName' => $imageName,
                    'imageNameClass' => $imageNameClass,
                    'imageAltClass' => $imageAltClass,
                    'imageLengthClass' => $imageLengthClass,
                    'imageHyphenClass' => $imageHyphenClass,
                    'imageUppercaseClass' => $imageUppercaseClass,
                    'imageSpecialClass' => $imageSpecialClass,
                    'imageAltSpacesClass' => $imageAltSpacesClass,
                    'imageLengthStatus' => $imageLengthStatus,
                ];

                $imageDetail["imageSizeValue"] = $imageMaxSize ? $imgSize . " KB" : "File size check excluded.";
          
                array_push($problems, $imageDetail);
            }

            // Set message based on results
            if($failedImages === 0) {
                $message = "All the Images meet quality requirements.";
            } elseif($passedImages === 0) {
                $message = "None of the Images meet quality requirements.";
            } else {
                $message = "While " . $passedImages . " Images were meeting quality requirements, there are " . $failedImages . " of them that are not meeting quality requirements.";
            }
        }

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = false;
        $object->tagStatus = false;
        $object->casingStatus = false;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Images";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function gzipCompression(Request $request){
        $helpers = new Helper();
        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');

        $urlValue = $data["urlValue"];
        $isGzipCompression = $settings->settings_sub->is_gzip_compression;
        $title = "Gzip Compression";
        $content = $data["content"];
        $description = "Gzip is a file format used to compress HTTP content before it's served to a client. GZip is a form of data compression, it takes a chunk of data and makes it smaller. <br><br> When Gzip compression is enabled,people visiting the site will be downloading smaller files which will help in quicker page loads.";
        $message = "Gzip compression is enabled";
        $showContent = false;
        $tagStatus = false;

        if($isGzipCompression){
            $response = $helpers->IsGzip($urlValue);
            switch($response){
                case 0:
                    $status = false;
                    $message = "Technical error.";
                    break;
                case 1:
                    $status = true;
                    $message = "Gzip compression is enabled";
                    break;
                case 1:
                    $status = false;
                    $message = "Gzip compression is not enabled";
                    break;
                case 3:
                    $status = false;
                    $message = "Technical error.";
                    break;
            } 
        }
   

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = $showContent;
        $object->tagStatus = $tagStatus;
        $object->casingStatus = false;
        $object->learnMoreURL = "https://setmore.com/";
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "GZIP Compression";
        $object->parentCard = "codingBestPractices";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function htmlCompression(Request $request){
        $helpers = new Helper();
        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');

        $urlValue = $data["urlValue"];
        $isHTMLCompression = $settings->settings_sub->is_html_compression;
        $title = "HTML Compression";
        $content = $data["content"];
        $description = "HTML compression shrinks file size of the page being served to the visitor. Because the HTTP protocol supports compression, your web server can compress the page before sending it to the visitor, and then the visitor's browser can decompress the page back to its original state, resulting in faster page loads.<br><br>";
        $message = "HTML compression is enabled";
        $showContent = false;
        $tagStatus = false;

        if($isHTMLCompression){
            if($helpers->isHTMLCompressed($html)){
                $status = true;
                $message = "HTML Code is compressed.";
            }else{
                $status = false;
                $message = "HTML Code is not compressed.";
            }
        }
   

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->content = $content;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = $showContent;
        $object->tagStatus = $tagStatus;
        $object->casingStatus = false;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "HTML Compression";
        $object->parentCard = "codingBestPractices";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function cssCompression(Request $request){
        $helpers = new Helper();
        $status = true;
        $problems = [];
        $data = $request->input('data');
        $files = isset($data["links"]) ? $data["links"] : [];
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');

        $urlValue = $data["urlValue"];
        $urlParse = parse_url($urlValue);
        $domain = $urlParse["scheme"] . "://" . $urlParse["host"];
        $isCSSCompression = $settings->settings_sub->is_css_compression;
        $title = "CSS Compression";
        $description = "CSS compression is a methodology to detect and remove older CSS scripts that modern web pages do not use to display your web pages. It also involves minifying unnecessary large CSS rules into much smaller code. The actual style and layout of the web page will not be affected by using this methodology, but it will lead to performance improvements.<br><br>";
        $message = "CSS compression is enabled";
        $showContent = false;
        $tagStatus = false;

        if($isCSSCompression){
            $response = $helpers->checkMinificationMain($files, ".css", 4, $domain, $urlParse["host"]);
            if(count($response) > 0){
                $strNew = "";
                foreach($response as $key=>$value){
                    $index = $key+1 === count($response) ? $key+1 : $key+1 . ", ";
                    $strNew .=  "<a target='_blank' href='$value'>Link $index</a>";
                }
                $status = false;
                $message = "All CSS Files are not compressed or minified <br>" . $strNew;
            }else{
                $status = true;
                $message = "All CSS Files are compressed and minified.";
            }
        }   
   

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = $showContent;
        $object->tagStatus = $tagStatus;
        $object->casingStatus = false;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "CSS Compression";
        $object->parentCard = "codingBestPractices";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function jsCompression(Request $request){
        $helpers = new Helper();
        $status = true;
        $problems = [];
        $data = $request->input('data');
        $files = isset($data["links"]) ? $data["links"] : [];
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');

        $urlValue = $data["urlValue"];
        $urlParse = parse_url($urlValue);
        $domain = $urlParse["scheme"] . "://" . $urlParse["host"];
        $isJSCompression = $settings->settings_sub->is_js_compression;
        $title = "JS Compression";
        $description = "JavaScript compression is a methodology to detect and remove older JS scripts that modern web pages do not use to display in your web pages. It also involves minifying unnecessary large JS files into much smaller code. The actual style, layout and functionality of the web page will not be affected by using this methodology, but it will lead to performance improvements.<br><br>";
        $message = "JS compression is enabled";
        $showContent = false;
        $tagStatus = false;

        if($isJSCompression){
            $response = $helpers->checkMinificationMain($files, ".js", 3, $domain, $urlParse["host"]);
            if(count($response) > 0){
                $strNew = "";
                foreach($response as $key=>$value){
                    $index = $key+1 === count($response) ? $key+1 : $key+1 . ", ";
                    $strNew .=  "<a target='_blank' href='$value'>Link $index </a>";
                }
                $status = false;
                $message = "All JS Files are not compressed or minified <br>" . $strNew;
            }else{
                $status = true;
                $message = "All JS Files are compressed and minified.";
            }
        }   
   

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->showContent = $showContent;
        $object->tagStatus = $tagStatus;
        $object->casingStatus = false;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "JS Compression";
        $object->parentCard = "codingBestPractices";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function googleInsights(Request $request){
        $status = true;
        $statusDesktop = true;
        $statusMobile = true;

        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];
        $key = "AIzaSyCKPTSNwVnuuHkMvKmzZO3UDUb6q79JxRY";

        $googleInsightsDesktop = $settings->settings_sub->google_insights_desktop;
        $googleInsightsDesktopVal = $settings->settings_sub->google_insights_desktop_val;
        $googleInsightsMobile = $settings->settings_sub->google_insights_mobile;
        $googleInsightsMobileVal = $settings->settings_sub->google_insights_mobile_val;
 
        $title = "Google Page Speed Overall Score";
        $titleDesktop = "Google Page Speed (Desktop)";
        $titleMobile = "Google Page Speed (Mobile)";

        $description = "Google PageSpeed Insights (PSI) reports on the performance of a page on both mobile and desktop devices, and provides suggestions on how that page may be improved in terms of performance, accessibility, speed and SEO.<br><br>";

        $message = "Google Page Speed Insights check excluded.";
        $messageDesktop = "Google Page Speed Insights check excluded.";
        $messageMobile = "Google Page Speed Insights check excluded.";
        $dataDesktop = Session::get("google_page_speed_desktop");
        $dataMobile = Session::get("google_page_speed_mobile");
        if(!$dataDesktop || !$dataMobile){
            $dataDesktop = json_decode(file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$urlValue&screenshot=true&strategy=desktop&category=performance&category=best-practices&category=accessibility&category=seo&key=$key"));
            $dataMobile = json_decode(file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$urlValue&screenshot=true&strategy=mobile&category=performance&category=best-practices&category=accessibility&category=seo&key=$key"));

            Session::put('google_page_speed_desktop', json_encode($dataDesktop));
            Session::put('google_page_speed_mobile', json_encode($dataMobile));
        }else{
            $dataDesktop = json_decode($dataDesktop);
            $dataMobile = json_decode($dataMobile);
        }

        $scoreDesktop = floatval($dataDesktop->lighthouseResult->categories->performance->score * 100);
        $scoreMobile = floatval($dataMobile->lighthouseResult->categories->performance->score * 100);

        // screenshots
        // Retrieve screenshot image data 
        $screenshotDataDesktop = $dataDesktop->lighthouseResult->audits->{'final-screenshot'}->details->data; 
        $screenshotDataMobile = $dataMobile->lighthouseResult->audits->{'final-screenshot'}->details->data; 


        if($googleInsightsDesktop){
            $messageDesktop = "Google Page Speed Insights Score for Desktop is meeting quality reqruirements.";
            if($scoreDesktop < $googleInsightsDesktopVal){
                $messageDesktop = "Google Page Speed Insights Score for Desktop is not meeting quality reqruirements.";
                $status = false;
                $statusDesktop = false;
            }
        }
      
        
        if($googleInsightsMobile){
            $messageMobile = "Google Page Speed Insights Score for Mobile is meeting quality reqruirements.";
            if($scoreMobile < $googleInsightsMobileVal){
                $messageMobile = "Google Page Speed Insights Score for Mobile is not meeting quality reqruirements.";
                $status = false;
                $statusMobile = false;
            }
        }

        $object = new \stdClass();
        $object->status = $status;
        $object->statusDesktop = $statusDesktop;
        $object->statusMobile = $statusMobile;
        $object->title = $title;
        $object->titleDesktop = $titleDesktop;
        $object->titleMobile = $titleMobile;
        $object->message = $message;
        $object->messageDesktop = $messageDesktop;
        $object->messageMobile = $messageMobile;
        $object->description = $description;
        $object->scoreDesktop = $scoreDesktop;
        $object->scoreMobile = $scoreMobile;
        $object->screenshotDataDesktop = $screenshotDataDesktop;
        $object->screenshotDataMobile = $screenshotDataMobile;
        $object->googleInsightsDesktop = $googleInsightsDesktop;
        $object->googleInsightsMobile = $googleInsightsMobile;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "insights";
        $object->name = "google_check";
        $object->parentCard = "performance";
        
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function googleLighthouse(Request $request){
        $status = true;
        $statusDesktop = true;
        $statusMobile = true;
        $statusPerformanceDesktop = true;
        $statusPerformanceMobile = true;
        $statusAccessibilityDesktop = true;
        $statusAccessibilityMobile = true;
        $statusBestPracticesDesktop = true;
        $statusBestPracticesMobile = true;
        $statusSeoDesktop = true;
        $statusSeoMobile = true;


        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];
        $key = "AIzaSyCKPTSNwVnuuHkMvKmzZO3UDUb6q79JxRY";

        $googlePerformanceDesktop = $settings->settings_sub->google_performance_desktop;
        $googlePerformanceDesktopVal = $settings->settings_sub->google_performance_desktop_val;
        $googlePerformanceMobile = $settings->settings_sub->google_performance_mobile;
        $googlePerformanceMobileVal = $settings->settings_sub->google_performance_mobile_val;
        
        $googleAccessibilityDesktop = $settings->settings_sub->google_accessibility_desktop;
        $googleAccessibilityDesktopVal = $settings->settings_sub->google_accessibility_desktop_val;
        $googleAccessibilityMobile = $settings->settings_sub->google_accessibility_mobile;
        $googleAccessibilityMobileVal = $settings->settings_sub->google_accessibility_mobile_val;

        $googleBestPracticesDesktop = $settings->settings_sub->google_best_practices_desktop;
        $googleBestPracticesDesktopVal = $settings->settings_sub->google_best_practices_desktop_val;
        $googleBestPracticesMobile = $settings->settings_sub->google_best_practices_mobile;
        $googleBestPracticesMobileVal = $settings->settings_sub->google_best_practices_mobile_val;

        $googleSeoDesktop = $settings->settings_sub->google_seo_desktop;
        $googleSeoDesktopVal = $settings->settings_sub->google_seo_desktop_val;
        $googleSeoMobile = $settings->settings_sub->google_seo_mobile;
        $googleSeoMobileVal = $settings->settings_sub->google_seo_mobile_val;

        $googleLighthouseCheckDesktop = $googlePerformanceDesktop || $googleAccessibilityDesktop || $googleBestPracticesDesktop || $googleSeoDesktop ? true : false;
        $googleLighthouseCheckMobile = $googlePerformanceMobile || $googleAccessibilityMobile || $googleBestPracticesMobile || $googleSeoMobile ? true : false;
        $googleLighthouseCheckOverall = $googleLighthouseCheckDesktop || $googleLighthouseCheckMobile ? true : false;

 
        $title = "Lighthouse Score";
        $titleDesktop = "Lighthouse Audit (Desktop)";
        $titleMobile = "Lighthouse Audit (Mobile)";

        $description = "Lighthouse is an open-source, automated tool for improving the quality of web pages. You can run it against any web page, public or requiring authentication. It has audits for performance, accessibility, progressive web apps, SEO and more. Give Lighthouse a URL to audit, it runs a series of audits against the page, and then it generates a report on how well the page did. From there, use the failing audits as indicators on how to improve the page.<br><br>";
        
        $message = "Lighthouse audit check excluded.";
        $messageDesktop = "Lighthouse audit for dekstop is meeting quality reqruirements.";
        $messageMobile = "Lighthouse audit for mobile is meeting quality reqruirements.";
        
        $dataDesktop = Session::get("google_page_speed_desktop");
        $dataMobile = Session::get("google_page_speed_mobile");
        
        if(!$dataDesktop || !$dataMobile){
            $dataDesktop = json_decode(file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$urlValue&strategy=desktop&category=performance&category=best-practices&category=accessibility&category=seo&key=$key"));
            $dataMobile = json_decode(file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$urlValue&strategy=mobile&category=performance&category=best-practices&category=accessibility&category=seo&key=$key"));

            Session::put('google_page_speed_desktop', json_encode($dataDesktop));
            Session::put('google_page_speed_mobile', json_encode($dataMobile));
        }else{
            $dataDesktop = json_decode($dataDesktop);
            $dataMobile = json_decode($dataMobile);
        }

        $scoreDesktop = floatval($dataDesktop->lighthouseResult->categories->performance->score * 100);
        $scoreMobile = floatval($dataMobile->lighthouseResult->categories->performance->score * 100);

        $accessibilityDesktop = floatval($dataDesktop->lighthouseResult->categories->accessibility->score * 100);
        $accessibilityMobile = floatval($dataMobile->lighthouseResult->categories->accessibility->score * 100);

        $bestPracticesDesktop = floatval($dataDesktop->lighthouseResult->categories->{"best-practices"}->score * 100);
        $bestPracticesMobile = floatval($dataMobile->lighthouseResult->categories->{"best-practices"}->score * 100);

        $seoDesktop = floatval($dataDesktop->lighthouseResult->categories->seo->score * 100);
        $seoMobile = floatval($dataMobile->lighthouseResult->categories->seo->score * 100);

        if($googlePerformanceDesktop){
            if($scoreDesktop < $googlePerformanceDesktopVal){
                $messageDesktop = "Lighthouse audit for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusPerformanceDesktop = false;
                $status = false;
            }
        }

        if($googlePerformanceMobile){
            if($scoreMobile < $googlePerformanceMobileVal){
                $messageMobile = "Lighthouse audit for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusPerformanceMobile = false;
                $status = false;
            }
        }
      
        
        if($googleAccessibilityDesktop){
            if($accessibilityDesktop < $googleAccessibilityDesktopVal){
                $messageDesktop = "Lighthouse audit for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusAccessibilityDesktop = false;
                $status = false;
            }
        }

        if($googleAccessibilityDesktop){
            if($accessibilityMobile < $googleAccessibilityMobileVal){
                $messageMobile = "Lighthouse audit for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusAccessibilityMobile = false;
                $status = false;
            }
        }

        if($googleBestPracticesDesktop){
            if($bestPracticesDesktop < $googleBestPracticesDesktopVal){
                $messageDesktop = "Lighthouse audit for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusBestPracticesDesktop = false;
                $status = false;
            }
        }

        if($googleBestPracticesMobile){
            if($bestPracticesMobile < $googleBestPracticesMobileVal){
                $messageMobile = "Lighthouse audit for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusBestPracticesMobile = false;
                $status = false;
            }
        }


        if($googleSeoDesktop){
            if($seoDesktop < $googleSeoDesktopVal){
                $messageDesktop = "Lighthouse audit for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusSeoDesktop = false;
                $status = false;
            }
        }

        if($googleSeoMobile){
            if($seoMobile < $googleSeoMobileVal){
                $messageMobile = "Lighthouse audit for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusSeoMobile = false;
                $status = false;
            }
        }

    

        
        $object = new \stdClass();
        $object->status = $status;
        $object->googleLighthouseCheckDesktop = $googleLighthouseCheckDesktop;
        $object->googleLighthouseCheckMobile = $googleLighthouseCheckMobile;
        $object->googleLighthouseCheckOverall = $googleLighthouseCheckOverall;
        $object->statusDesktop = $statusDesktop;
        $object->statusMobile = $statusMobile;
        $object->title = $title;
        $object->titleDesktop = $titleDesktop;
        $object->titleMobile = $titleMobile;
        $object->message = $message;
        $object->messageDesktop = $messageDesktop;
        $object->messageMobile = $messageMobile;
        $object->description = $description;
        $object->scoreDesktop = $scoreDesktop;
        $object->scoreMobile = $scoreMobile;
        $object->accessibilityDesktop = $accessibilityDesktop;
        $object->accessibilityMobile = $accessibilityMobile;
        $object->bestPracticesDesktop = $bestPracticesDesktop;
        $object->bestPracticesMobile = $bestPracticesMobile;
        $object->seoDesktop = $seoDesktop;
        $object->seoMobile = $seoMobile;
        $object->googlePerformanceDesktop = $googlePerformanceDesktop;
        $object->googlePerformanceMobile = $googlePerformanceMobile;
        $object->googleAccessibilityDesktop = $googleAccessibilityDesktop;
        $object->googleAccessibilityMobile = $googleAccessibilityMobile;
        $object->googleBestPracticesDesktop = $googleBestPracticesDesktop;
        $object->googleBestPracticesMobile = $googleBestPracticesMobile;
        $object->googleSeoDesktop = $googleSeoDesktop;
        $object->googleSeoMobile = $googleSeoMobile;

        $object->statusPerformanceDesktop = $statusPerformanceDesktop;
        $object->statusPerformanceMobile = $statusPerformanceMobile;
        $object->statusAccessibilityDesktop = $statusAccessibilityDesktop;
        $object->statusAccessibilityMobile = $statusAccessibilityMobile;
        $object->statusBestPracticesDesktop = $statusBestPracticesDesktop;
        $object->statusBestPracticesMobile = $statusBestPracticesMobile;
        $object->statusSeoDesktop = $statusSeoDesktop;
        $object->statusSeoMobile = $statusSeoMobile;

        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "lighthouse";
        $object->name = "google_check";
        $object->parentCard = "performance";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }



    public function googleCoreWebVitals(Request $request){
        $status = true;
        $statusDesktop = true;
        $statusMobile = true;
        $statusLCPDesktop = true;
        $statusLCPMobile = true;
        $statusFCPDesktop = true;
        $statusFCPMobile = true;
        $statusCLSDesktop = true;
        $statusCLSMobile = true;
        $statusFIDDesktop = true;
        $statusFIDMobile = true;
        $statusTTIDesktop = true;
        $statusTTIMobile = true;
        $statusTBTDesktop = true;
        $statusTBTMobile = true;
        $statusSIDesktop = true;
        $statusSIMobile = true;


        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];
        $key = "AIzaSyCKPTSNwVnuuHkMvKmzZO3UDUb6q79JxRY";

        $googleLCPDesktop = $settings->settings_sub->google_lcp_desktop;
        $googleLCPDesktopVal = $settings->settings_sub->google_lcp_desktop_val;
        $googleLCPMobile = $settings->settings_sub->google_lcp_mobile;
        $googleLCPMobileVal = $settings->settings_sub->google_lcp_mobile_val;
        
        $googleCLSDesktop = $settings->settings_sub->google_cls_desktop;
        $googleCLSDesktopVal = $settings->settings_sub->google_cls_desktop_val;
        $googleCLSMobile = $settings->settings_sub->google_cls_mobile;
        $googleCLSMobileVal = $settings->settings_sub->google_cls_mobile_val;

        $googleFCPDesktop = $settings->settings_sub->google_fcp_desktop;
        $googleFCPDesktopVal = $settings->settings_sub->google_fcp_desktop_val;
        $googleFCPMobile = $settings->settings_sub->google_fcp_mobile;
        $googleFCPMobileVal = $settings->settings_sub->google_fcp_mobile_val;

        $googleFIDDesktop = $settings->settings_sub->google_fid_desktop;
        $googleFIDDesktopVal = $settings->settings_sub->google_fid_desktop_val;
        $googleFIDMobile = $settings->settings_sub->google_fid_mobile;
        $googleFIDMobileVal = $settings->settings_sub->google_fid_mobile_val;

        $googleTBTDesktop = $settings->settings_sub->google_tbt_desktop;
        $googleTBTDesktopVal = $settings->settings_sub->google_tbt_desktop_val;
        $googleTBTMobile = $settings->settings_sub->google_tbt_mobile;
        $googleTBTMobileVal = $settings->settings_sub->google_tbt_mobile_val;

        $googleTTIDesktop = $settings->settings_sub->google_tti_desktop;
        $googleTTIDesktopVal = $settings->settings_sub->google_tti_desktop_val;
        $googleTTIMobile = $settings->settings_sub->google_tti_mobile;
        $googleTTIMobileVal = $settings->settings_sub->google_tti_mobile_val;

        $googleSIDesktop = $settings->settings_sub->google_speed_index_desktop;
        $googleSIDesktopVal = $settings->settings_sub->google_speed_index_desktop_val;
        $googleSIMobile = $settings->settings_sub->google_speed_index_mobile;
        $googleSIMobileVal = $settings->settings_sub->google_speed_index_mobile_val;

        $googleCoreCheckDesktop = $googleLCPDesktop || $googleCLSDesktop || $googleFCPDesktop || $googleFIDDesktop || $googleTBTDesktop || $googleTTIDesktop || $googleSIDesktop ? true : false;
        $googleCoreCheckMobile = $googleLCPMobile || $googleCLSMobile || $googleFCPMobile || $googleFIDMobile || $googleTBTMobile || $googleTTIMobile || $googleSIMobile ? true : false;
        $googleCoreCheckOverall = $googleCoreCheckDesktop || $googleCoreCheckMobile ? true : false;
 
        $title = "Core Web Vitals";
        $titleDesktop = "Core Web Vitals (Desktop)";
        $titleMobile = "Core Web Vitals (Mobile)";
        $description = "Core Web Vitals are a set of specific factors that Google considers important in a webpage's overall user experience. Core Web Vitals are made up of three specific page speed and user interaction measurements: largest contentful paint, first input delay, and cumulative layout shift.Core Web Vitals are a subset of factors that is part of Google's page experience score.<br><br>";
        
        $message = "Core web vitals check excluded";
        $messageDesktop = "Core web vitals for dekstop is meeting quality reqruirements.";
        $messageMobile = "Core web vitals for mobile is meeting quality reqruirements.";
        
        $dataDesktop = Session::get("google_page_speed_desktop");
        $dataMobile = Session::get("google_page_speed_mobile");
        
        if(!$dataDesktop || !$dataMobile){
            $dataDesktop = json_decode(file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$urlValue&strategy=desktop&category=performance&category=best-practices&category=accessibility&category=seo&key=$key"));
            $dataMobile = json_decode(file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$urlValue&strategy=mobile&category=performance&category=best-practices&category=accessibility&category=seo&key=$key"));

            Session::put('google_page_speed_desktop', json_encode($dataDesktop));
            Session::put('google_page_speed_mobile', json_encode($dataMobile));
        }else{
            $dataDesktop = json_decode($dataDesktop);
            $dataMobile = json_decode($dataMobile);
        }

        $clsDesktop = floatval($dataDesktop->lighthouseResult->audits->{"cumulative-layout-shift"}->numericValue);
        $clsMobile = floatval($dataMobile->lighthouseResult->audits->{"cumulative-layout-shift"}->numericValue);

        $lcpDesktop = floatval($dataDesktop->lighthouseResult->audits->{"largest-contentful-paint"}->numericValue / 1000);
        $lcpMobile = floatval($dataMobile->lighthouseResult->audits->{"largest-contentful-paint"}->numericValue / 1000);

        $fcpDesktop = floatval($dataDesktop->lighthouseResult->audits->{"first-contentful-paint"}->numericValue / 1000);
        $fcpMobile = floatval($dataMobile->lighthouseResult->audits->{"first-contentful-paint"}->numericValue / 1000);

        $fidDesktop = floatval($dataDesktop->lighthouseResult->audits->{"max-potential-fid"}->numericValue);
        $fidMobile = floatval($dataMobile->lighthouseResult->audits->{"max-potential-fid"}->numericValue);

        $ttiDesktop = floatval($dataDesktop->lighthouseResult->audits->{"interactive"}->numericValue / 1000);
        $ttiMobile = floatval($dataMobile->lighthouseResult->audits->{"interactive"}->numericValue / 1000);

        $tbtDesktop = floatval($dataDesktop->lighthouseResult->audits->{"total-blocking-time"}->numericValue);
        $tbtMobile = floatval($dataMobile->lighthouseResult->audits->{"total-blocking-time"}->numericValue);

        $siDesktop = floatval($dataDesktop->lighthouseResult->audits->{"speed-index"}->numericValue / 1000);
        $siMobile = floatval($dataMobile->lighthouseResult->audits->{"speed-index"}->numericValue / 1000);

        if($googleLCPDesktop){
            if($lcpDesktop > $googleLCPDesktopVal){
                $messageDesktop = "Core web vitals for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusLCPDesktop = false;
            }
        }

        if($googleLCPMobile){
            if($lcpMobile > $googleLCPMobileVal){
                $messageMobile = "Core web vitals for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusLCPMobile = false;
                $status = false;
            }
        }
      
        
        if($googleFCPDesktop){
            if($fcpDesktop > $googleFCPDesktopVal){
                $messageDesktop = "Core web vitals for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusFCPDesktop = false;
                $status = false;
            }
        }

        if($googleFCPDesktop){
            if($fcpMobile > $googleFCPMobileVal){
                $messageMobile = "Core web vitals for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusFCPMobile = false;
                $status = false;
            }
        }

        if($googleCLSDesktop){
            if($clsDesktop > $googleCLSDesktopVal){
                $messageDesktop = "Core web vitals for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusCLSDesktop = false;
                $status = false;
            }
        }

        if($googleCLSMobile){
            if($clsMobile > $googleCLSMobileVal){
                $messageMobile = "Core web vitals for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusCLSMobile = false;
                $status = false;
            }
        }


        if($googleTTIDesktop){
            if($ttiDesktop > $googleTTIDesktopVal){
                $messageDesktop = "Core web vitals for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusTTIDesktop = false;
                $status = false;
            }
        }

        if($googleTTIMobile){
            if($ttiMobile > $googleTTIMobileVal){
                $messageMobile = "Core web vitals for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusTTIMobile = false;
                $status = false;
            }
        }

        if($googleFIDDesktop){
            if($fidDesktop > $googleFIDDesktopVal){
                $messageDesktop = "Core web vitals for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusFIDDesktop = false;
                $status = false;
            }
        }

        if($googleFIDMobile){
            if($fidMobile > $googleFIDMobileVal){
                $messageMobile = "Core web vitals for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusFIDMobile = false;
                $status = false;
            }
        }

        if($googleTBTDesktop){
            if($tbtDesktop > $googleTBTDesktopVal){
                $messageDesktop = "Core web vitals for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusTBTDesktop = false;
                $status = false;
            }
        }

        if($googleTBTMobile){
            if($tbtMobile > $googleTBTMobileVal){
                $messageMobile = "Core web vitals for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusTBTMobile = false;
                $status = false;
            }
        }

        if($googleSIDesktop){
            if($siDesktop > $googleSIDesktopVal){
                $messageDesktop = "Core web vitals for dekstop does not meet quality requirements.";
                $statusDesktop = false;
                $statusSIDesktop = false;
                $status = false;
            }
        }

        if($googleSIMobile){
            if($siMobile > $googleSIMobileVal){
                $messageMobile = "Core web vitals for mobile does not meet quality requirements.";
                $statusMobile = false;
                $statusSIMobile = false;
                $status = false;
            }
        }

    

        
        $object = new \stdClass();
        $object->status = $status;
        $object->googleCoreCheckDesktop = $googleCoreCheckDesktop;
        $object->googleCoreCheckMobile = $googleCoreCheckMobile;
        $object->googleCoreCheckOverall = $googleCoreCheckOverall;
        $object->statusDesktop = $statusDesktop;
        $object->statusMobile = $statusMobile;
        $object->title = $title;
        $object->titleDesktop = $titleDesktop;
        $object->titleMobile = $titleMobile;
        $object->message = $message;
        $object->messageDesktop = $messageDesktop;
        $object->messageMobile = $messageMobile;
        $object->description = $description;


        $object->clsDesktop = round($clsDesktop, 2);
        $object->clsMobile = round($clsMobile, 2);
        $object->fcpDesktop = round($fcpDesktop, 2);
        $object->fcpMobile = round($fcpMobile, 2);
        $object->lcpDesktop = round($lcpDesktop, 2);
        $object->lcpMobile = round($lcpMobile, 2);
        $object->fidDesktop = round($fidDesktop, 2);
        $object->fidMobile = round($fidMobile, 2);
        $object->tbtDesktop = round($tbtDesktop, 2);
        $object->tbtMobile = round($tbtMobile, 2);
        $object->ttiDesktop = round($ttiDesktop, 2);
        $object->ttiMobile = round($ttiMobile, 2);
        $object->siDesktop = round($siDesktop, 2);
        $object->siMobile = round($siMobile, 2);


        $object->googleCLSDesktop = $googleCLSDesktop;
        $object->googleCLSMobile = $googleCLSMobile;
        $object->googleFCPDesktop = $googleFCPDesktop;
        $object->googleFCPMobile = $googleFCPMobile;
        $object->googleLCPDesktop = $googleLCPDesktop;
        $object->googleLCPMobile = $googleLCPMobile;
        $object->googleFIDDesktop = $googleFIDDesktop;
        $object->googleFIDMobile = $googleFIDMobile;
        $object->googleTBTDesktop = $googleTBTDesktop;
        $object->googleTBTMobile = $googleTBTMobile;
        $object->googleTTIDesktop = $googleTTIDesktop;
        $object->googleTTIMobile = $googleTTIMobile;
        $object->googleSIDesktop = $googleSIDesktop;
        $object->googleSIMobile = $googleSIMobile;



        $object->statusCLSDesktop = $statusCLSDesktop;
        $object->statusCLSMobile = $statusCLSMobile;
        $object->statusFCPDesktop = $statusFCPDesktop;
        $object->statusFCPMobile = $statusFCPMobile;
        $object->statusLCPDesktop = $statusLCPDesktop;
        $object->statusLCPMobile = $statusLCPMobile;
        $object->statusFIDDesktop = $statusFIDDesktop;
        $object->statusFIDMobile = $statusFIDMobile;
        $object->statusTTIDesktop = $statusTTIDesktop;
        $object->statusTTIMobile = $statusTTIMobile;
        $object->statusTBTDesktop = $statusTBTDesktop;
        $object->statusTBTMobile = $statusTBTMobile;
        $object->statusSIDesktop = $statusSIDesktop;
        $object->statusSIMobile = $statusSIMobile;

        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "core_web_vitals";
        $object->name = "google_check";
        $object->parentCard = "performance";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }


    public function mobileFriendly(Request $request)
    {
        $status = true;

        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $urlValue = $data["urlValue"];
        $key = "AIzaSyCKPTSNwVnuuHkMvKmzZO3UDUb6q79JxRY";

        $googleMobileFriendly = $settings->settings_sub->mobile_friendly;


 
        $title = "Google Mobile Friendly Test";
        $description = "Google PageSpeed Insights (PSI) reports on the performance of a page on both mobile and desktop devices, and provides suggestions on how that page may be improved in terms of performance, accessibility, speed and SEO.<br><br>";
        $message = "Google Mobile Friendly check excluded.";
        $message_secondary = "";

  
        $dataMobile = Session::get("google_page_speed_mobile");
        
        if(!$dataMobile){
            $dataMobile = json_decode(file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$urlValue&strategy=mobile&category=performance&category=best-practices&category=accessibility&category=seo&key=$key"));

            Session::put('google_page_speed_mobile', json_encode($dataMobile));
        }else{
            $dataMobile = json_decode($dataMobile);
        }
        $screenshotDataMobile = $dataMobile->lighthouseResult->audits->{'final-screenshot'}->details->data;
        $mobileAudits = ['viewport', 'font-size', 'tap-targets', 'content-width'];
        $failedReasons = [];

        if($googleMobileFriendly){

            foreach ($mobileAudits as $auditId) {
                if (isset($audits->{$auditId})) {
                    $audit = $audits->{$auditId};
                    if ($audit->score < 1) {
                        $reason = $audit['title'];
                        if (!empty($audit['displayValue'])) {
                            $reason .= ': ' . $audit['displayValue'];
                        } elseif (!empty($audit['description'])) {
                            $reason .= ': ' . $audit['description'];
                        }
                        $failedReasons[] = $reason;
                    }
                }
            }

            if(empty($failedReasons)){
                $message = "Page is usable on mobile.";
                $message_secondary = "This Page is easy to use on a mobile device.";
                $status = true;
            }else{
                $message = "ThisPage is not usable on mobile.";
                $message_secondary = "This Page is difficult to use on a mobile device.";
                $status = false;
            }
        }
        $audits = $dataMobile->lighthouseResult->audits;
      


   
        $object = new \stdClass();
        $object->status = $status;
        $object->screenshotDataMobile = $screenshotDataMobile;
        $object->googleMobileFriendly = $googleMobileFriendly;
        $object->problems = $failedReasons;
        $object->title = $title;
        $object->message = $message;
        $object->message_secondary = $message_secondary;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "mobile_friendliness";
        $object->name = "google_check";
        $object->parentCard = "performance";
        
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    } 

    public function checkSSLCertificate(Request $request)
    {

        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $internalResponse = session()->get('internal_response');
        $title = "SSL Cetificate enable";
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $websiteUrl = $data["urlValue"];
        $isSslCertificateEnable = $settings->settings_sub->ssl_certificate_enable;
        $message = '';

        if ($isSslCertificateEnable) {
          
        // Add a default scheme (e.g., "http") if the URL doesn't have one
        if (!parse_url($websiteUrl, PHP_URL_SCHEME)) {
            $websiteUrl = "http://" . $websiteUrl;
        }

        $websiteUrl = parse_url($websiteUrl, PHP_URL_HOST);
        set_error_handler([$this, 'customErrorHandler']);

        try {
            // Attempt to create the SSL connection
                $stream = $helpers->checkSSLCertificate($websiteUrl);

            if ($stream === false) {
                // Handle the case when stream_socket_client fails
                $status = false;
                $message = 'SSL Certificate not found or expired';
            } else {
                $status = true;
                $message = 'SSL Certificate enable on this page';
            }

            // Handle a successful connection here.
        } catch (Exception $e) {
            $status = false;
            $message = 'SSL Certificate not found or expired';
        } finally {
            // Restore the default error handler
            restore_error_handler();
        }
    }

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "SSL Certificate";
        $object->parentCard = "security";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);

    }

    public function customErrorHandler($errno, $errstr, $errfile, $errline)
    {
        if ($errno == 1) {
            // Handle SSL/TLS errors here
            report(new Exception("SSL/TLS Error: $errstr"));
            // You can log the error or perform other actions as needed
        }
        // Handle other errors here if necessary
    }

    public function directoryBrowsingEnable(Request $request)
    {

        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $title = "Directory Browsing";
        $description = "A viewport title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage";
        $url = $data["urlValue"];
        $message = '';
        $isFolderBrowsingEnable = $settings->settings_sub->folder_browsing_enable;
        if($isFolderBrowsingEnable) {
        
            // Check if the content contains typical directory listing keywords
            if (strpos($html, '<title>Index of /</title>') !== false) {
                // These are common keywords found in directory listing pages.
                $message = "Directory listing is likely enabled for $url";
                $status = false;
            } else {
                // The URL is accessible, but it does not appear to be a directory listing page.
                $message = "Directory listing is likely disabled for $url";
                $status = true;
            }
       
         }

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Directory Browsing";
        $object->parentCard = "security";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }

    public function badContentType(Request $request)
    {
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $contentSecurityVal = $internalResponse->getHeader('Content-Security-Policy');
        $title = "Bad content type";
        $description = "Bad content type";
        $url = $data["urlValue"];
        $message = '';
        
        $isBadContentType = $settings->settings_sub->bad_content_type;  
        if($isBadContentType) { 
       
        $contentTypeElement = $helpers->badContentTypeTest($html);
        if ($contentTypeElement->count() > 0) {
            // Extract the content attribute value from the meta tag
            $contentTypeHtml = $contentTypeElement->attr('content');
            $contentType = session()->get('contentType');
            
            if ($contentTypeHtml != $contentType) {
                $status = false;
                $message = 'Bad content type found';
            } else {
                $status = true;
                $message = 'Bad content type not found';
            }
            // return $contentType;
        } else {
            $status = true;
            $message = 'Content type not define';
            }
        }

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Bad content type";
        $object->parentCard = "security";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    }



    public function cssCachingEnable(Request $request)
    {
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $contentSecurityVal = $internalResponse->getHeader('Content-Security-Policy');
        $title = "CSS Caching";
        $description = "CSS Caching";
        $url = $data["urlValue"];
        $message = '';
        $content = '';
        $cssData = [];
        
        $iscssCachingEnable = $settings->settings_sub->css_caching_enable;  
        if($iscssCachingEnable) { 
            $cssData = $helpers->cssCachingEnable($url, $html);
            if(count($cssData) > 0) {
              $status = true;
              $message = 'CSS caching is enabled for this page';
  
            } else {
              $status = false;
              $message = 'CSS caching is disabled for this page';
            }
        }
        

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "CSS Caching Enable";
        $object->settings = $settings->settings_sub;
        $object->content = $content;
        $object->cssData = $cssData;
        echo json_encode($object);
    } 

    public function jsCachingEnable(Request $request)
    {
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $contentSecurityVal = $internalResponse->getHeader('Content-Security-Policy');
        $title = "JS Caching";
        $description = "JS Caching";
        $url = $data["urlValue"];
        $message = '';
        $content = '';
        $jsData = [];
        
        $isjsCachingEnable = $settings->settings_sub->js_caching_enable;  
        if($isjsCachingEnable) { 
            $jsData = $helpers->jsCachingEnable($url, $html);
            if(count($jsData) > 0) {
              $status = true;
              $message = 'JS caching is enabled for this page';
  
          }else{
              $status = false;
              $message = 'JS caching is disabled for this page';
        }

        }

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "JS Caching Enable";
        $object->settings = $settings->settings_sub;
        $object->content = $content;
        $object->jsData = $jsData;
        echo json_encode($object);
    } 




   public function safeBrowsing(Request $request)
    {
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $title = "Safe Browsing";
        $description = "Safe Browsing";
        $url = $data["urlValue"];
        $message = '';
        $content = '';
        
        $isSafeBrowsing = $settings->settings_sub->is_safe_browsing;  
        if($isSafeBrowsing) { 
          $isSafe = $helpers->isUrlSafe($url);
          if($isSafe) {
            $status = true;
            $message = 'URL is safe for browsing';
          } else {
            $status = false;
            $message = 'URL is not safe browsing';
          }
        }

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Safe Browsing";
        $object->settings = $settings->settings_sub;
        echo json_encode($object);
    } 
    
    public function crossOriginLinks(Request $request)
    {
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $contentSecurityVal = $internalResponse->getHeader('Content-Security-Policy');
        $title = "Unsafe Cross Origin Links";
        $description = "Unsafe Cross Origin Links";
        $url = $data["urlValue"];
        $message = '';
        $content = '';
        $crossOriginLinksData = [];
        
        $isCrossOriginLinks = $settings->settings_sub->cross_origin_links;  
        if($isCrossOriginLinks) { 
            $crossOriginLinksData = $helpers->crossOriginLinks($url, $html);
            if(count($crossOriginLinksData) > 0) {
                $status = false;
                $message = 'Cross Origin Links';

            } else {
                $status = true;
                $message = 'Cross origin links not found';
            }
        }

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Unsafe Cross Origin Links";
        $object->settings = $settings->settings_sub;
        $object->content = $content;
        $object->crossOriginLinksData = $crossOriginLinksData;
        echo json_encode($object);
    }
    
    public function protocolRelativeResource(Request $request)
    {
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $contentSecurityVal = $internalResponse->getHeader('Content-Security-Policy');
        $title = "Protocol Relative Resource Links";
        $description = "Protocol Relative Resource Links";
        $url = $data["urlValue"];
        $message = '';
        $content = '';
        $protocolRelativeResourceData = [];
        $protocolRelativeResourceDataCleanArray = [];
        $isProtocolRelativeResource = $settings->settings_sub->protocol_relative_resource;  
        if($isProtocolRelativeResource) { 
            $protocolRelativeResourceData = $helpers->protocolRelativeResource($url, $html);
          
          foreach($protocolRelativeResourceData as $key=>$data) {
             $protocolRelativeResourceDataCleanArray[] = preg_replace('/href=|"| /', '', $data);
          }
          if(count($protocolRelativeResourceData) > 0) {
            $status = false;
            $message = 'Protocol Relative Resource Links';

          } else {
            $status = true;
            $message = 'Protocol Relative Resource Links not found';
          }
        }

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Protocol Relative Resource Links";
        $object->settings = $settings->settings_sub;
        $object->content = $content;
        $object->protocolRelativeResourceData = $protocolRelativeResourceDataCleanArray;
        echo json_encode($object);
    }

    public function h1HeadindTag(Request $request)
    {
        $helpers = new Helper();
        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $contentSecurityVal = $internalResponse->getHeader('Content-Security-Policy');
        $title = "Headings";
        $description = "Headings";
        $url = $data["urlValue"];
        $message = '';
        $content = '';
        $hideDetails=true;
        $headingArray = $helpers->h1HeadindTag($url, $html);
        if (count($headingArray) > 0) {
            $h1HeadingTagSubSetting = $settings->settings_sub->h1_heading_tag_length;
            $h2HeadingTagSubSetting = $settings->settings_sub->h2_heading_tag_length;
            $h3HeadingTagSubSetting = $settings->settings_sub->h3_heading_tag_length;
            $h4HeadingTagSubSetting = $settings->settings_sub->h4_heading_tag_length;
            $h5HeadingTagSubSetting = $settings->settings_sub->h5_heading_tag_length;
            $h6HeadingTagSubSetting = $settings->settings_sub->h6_heading_tag_length;

            $h1HeadingTagSubValSetting = $settings->settings_sub->h1_heading_tag_length_val;
            $h2HeadingTagSubValSetting = $settings->settings_sub->h2_heading_tag_length_val;
            $h3HeadingTagSubValSetting = $settings->settings_sub->h3_heading_tag_length_val;
            $h4HeadingTagSubValSetting = $settings->settings_sub->h4_heading_tag_length_val;
            $h5HeadingTagSubValSetting = $settings->settings_sub->h5_heading_tag_length_val;
            $h6HeadingTagSubValSetting = $settings->settings_sub->h6_heading_tag_length_val;

            $h1HeadingTag = $settings->settings_sub->h1_heading_tag;
            
            if ($h1HeadingTag) {
                if (count($headingArray['h1']) == 0) {
                    $status = false;
                    
                }
            }
        

            if ($h1HeadingTagSubSetting) {
                if (count($headingArray['h1']) > $h1HeadingTagSubValSetting) {
                    $status = false;
                    // $message .= count($headingArray['h1']). ' H1 heading tag, ';
                }
            }

            if ($h2HeadingTagSubSetting) {
                if (count($headingArray['h2']) > $h2HeadingTagSubValSetting) {
                    $status = false;
                    // $message .= count($headingArray['h2']). ' H2 heading tag, ';
                }
            }

            if ($h3HeadingTagSubSetting) {
                if (count($headingArray['h3']) > $h3HeadingTagSubValSetting) {
                    $status = false;
                    // $message .= count($headingArray['h3']). ' H3 heading tag, ';
                }
            }


            if ($h4HeadingTagSubSetting) {
                if (count($headingArray['h4']) > $h4HeadingTagSubValSetting) {
                    $status = false;
                    // $message .= 'H4 tag found more than ' . $h4HeadingTagSubValSetting . "<br>";
                }
            }

            if ($h5HeadingTagSubSetting) {
                if (count($headingArray['h5']) > $h5HeadingTagSubValSetting) {
                    $status = false;
                    // $message .= 'H5 tag found more than ' . $h5HeadingTagSubValSetting . "<br>";
                }
            }
          
            if ($h6HeadingTagSubSetting) {
                if (count($headingArray['h6']) > $h6HeadingTagSubValSetting) {
                    $status = false;
                    // $message .= 'H6 tag found more than ' . $h6HeadingTagSubValSetting . "<br>";
                }
            }
    
        }

        $message = 'Your webpage is using';
        $message .= count($headingArray['h1']). ' H1 heading tag, ';
        $message .= count($headingArray['h2']). ' H2 heading tag, ';
        $message .= 'and '.(count($headingArray['h3']) + count($headingArray['h4']) + count($headingArray['h5']) + count($headingArray['h6'])). ' other types of heading tags.';

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Headings";
        $object->content = $content;
        $object->settings = $settings->settings_sub;
        $object->headingArray = $headingArray;
        $object->hideDetails = $hideDetails;
        echo json_encode($object);
    }    
    public function robotTextTtest(Request $request)
    {
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $contentSecurityVal = $internalResponse->getHeader('Content-Security-Policy');
        $title = "Robots.txt";
        $description = "Robots.txt";
        $url = $data["urlValue"];
        $message = '';
        $content = '';
        $robotTextTestBlockUrl = $settings->settings_sub->robot_text_test_block_url; 
        $robotTextResponseData = []; 
        $urlBlock = true;
        $parsed_url = parse_url($url);
        $base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        $robotsTxtUrl = $base_url . '/robots.txt';
        $secondaryBots = [];
        if($robotTextTestBlockUrl) { 
          $robotTextResponse = $helpers->robotTextTtest($url);
          if($robotTextResponse[1] == false) {
            if($robotTextResponse[2] == false) { 
                $status = true;
                $urlBlock = false;
                $message = 'We did not detect a Robots.txt file in the root directory of your website, so the current page is not blocked from crawling by any search engine.';
              } else {
            
            $status = false;
            $urlBlock = true;
            $robotTextResponseData = $robotTextResponse[0];
             $userAgent = implode(",",$robotTextResponse[3]);
            // $message = 'The current page is blocked by '.$userAgent.' in the '. '<a href='.$robotsTxtUrl.' target="_blank">Robots.txt file</a>' .' file';
            $message = 'The current page is blocked from being crawled by '. $userAgent .' in the '. '<a href='.$robotsTxtUrl.' target="_blank">Robots.txt file</a>' .' file of your website.';
            $secondaryBots = $robotTextResponse[4];
            if(count($robotTextResponse[4]) > 3) {
                
                $message = 'The current page is blocked from being crawled by Yandex and Bing in the '. '<a href='.$robotsTxtUrl.' target="_blank">Robots.txt file</a>' .' file of your website. The page is also blocked from crawling by '.count($robotTextResponse[4]).' secondary bots. <span data-bs-toggle="modal" data-bs-target="#secondaryBots" style="border-bottom: 1px solid #7f6e6e; cursor: pointer;">see the list of all secondary bots</span>';
            }
        }
            
        } else {
            $urlBlock = false;
            $status = true;
            // $message = 'URL is not block in Robots.txt file.';
            $userAgent = implode(",",$robotTextResponse[3]);
            $userAgentSecond = implode(",",$robotTextResponse[4]);
            $message = 'The current page is not blocked from being crawled by any search engines in the '. '<a href='.$robotsTxtUrl.' target="_blank">Robots.txt file</a>' .' file of your website.';
            if(count($robotTextResponse[4]) > 3) {
                $secondaryBots = $robotTextResponse[4];
                $message = 'The current page is not blocked from being crawled by any search engines in the '. '<a href='.$robotsTxtUrl.' target="_blank">Robots.txt file</a>' .' file of your website, but it is being blocked from Crawling by '.count($robotTextResponse[4]).' other secondary bots. <span data-bs-toggle="modal" data-bs-target="#secondaryBots" style="border-bottom: 1px solid #7f6e6e; cursor: pointer;">see the list of all secondary bots</span>';
            } else {
                 $message = 'The current page is not blocked from being crawled by any search engines in the '. '<a href='.$robotsTxtUrl.' target="_blank">Robots.txt file</a>' .' file of your website';
              if(count($robotTextResponse[4]) > 0) {
                $message .= ', but it is being blocked from Crawling by '.$userAgentSecond;
              } else{
                $message .= '.';
              }
            }
        }
          
        }

        $object = new \stdClass();
        $object->status = $status;
        $object->title = $title;
        $object->status = $status;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Robots.txt Test";
        $object->settings = $settings->settings_sub;
        $object->content = $content;
        $object->urlBlock = $urlBlock;
        $object->robotTextResponseData = $robotTextResponseData;
        $object->secondaryBots = $secondaryBots;
        echo json_encode($object);
    }



    public function brokenLinks(Request $request){
        $helpers = new Helper();

        $status = true;
        $problems = [];
        $data = $request->input('data');
        $project = json_decode(Session::get('project'));
        $settings = json_decode(Session::get('settings'));
        $html = session()->get('html_code');
        $internalResponse = session()->get('internal_response');
        $contentSecurityVal = $internalResponse->getHeader('Content-Security-Policy');
        $title = "Broken Links";
        $description = "Broken Links";
        $url = $data["urlValue"];
        $message = '';
        $content = '';
        $brokenLinks = $settings->settings_sub->broken_links;  
      

        $output = json_decode($helpers->brokenLinks($url));


        if($output->status){
            if($output->isBrokenLinkPresent){
                $message = "Your page has " . $output->totalBrokenLinks . " broken links, please see the list below.";
            }else{
                $message = "There were 0 broken links found in your web page.";
            }
        }else{
            $message = "The url ('" . $url . "') does not allow parsing, please try a different URL.";
        }

        $object = new \stdClass();
        if($output->status){
            $object->status = !$output->isBrokenLinkPresent;
        }else{
            $object->status = false;
        }
        $object->title = $title;
        $object->problems = $problems;
        $object->message = $message;
        $object->description = $description;
        $object->learnMoreURL = "https://setmore.com/";
        $object->tagName = "Broken Links";
        $object->settings = $settings->settings_sub;
        $object->content = $content;
        $object->status_url = $output->status;
        $object->totalBrokenLinks = $output->totalBrokenLinks;
        if($output->status){
            $object->allLinks = $output->results;
        }
        echo json_encode($object);
    }
}
