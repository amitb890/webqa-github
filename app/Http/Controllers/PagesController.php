<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects;
use App\Models\projectSettings;
use App\Models\SettingsSub;
use App\Models\TestResults;
use Helper;
use AllLabels;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
$FastImageSize = new \FastImageSize\FastImageSize();


ini_set('max_execution_time', 180000);

class PagesController extends Controller
{

    public $all_urls = [];
    public $test_urls = [];
    public $tested_urls = [];
    public $sitemapCheckStatus = true;
    


    public function test(){
        $helpers = new Helper();

        $url = "https://d1r7943vfkqpts.cloudfront.net/7867e472-3f72-47b8-a8af-4d4fb9d24e2a.png";
        print_r(1);
        list($width, $height) = getimagesize($url); 
        $dimensions = array('h' => $height, 'w' => $width );

        // $dimensions = $FastImageSize->getImageSize($url);

        print_r($dimensions);
        // // $urlParse = parse_url($url);
        // // $domain = $urlParse["scheme"] . "://" . $urlParse["host"];
        // // $host = $urlParse["host"];


        // // array_push($this->tested_urls, $url);
        // // $this->getURLS($url, $domain, $host);
        // // print_r($this->tested_urls);

        
        // $str = "test";
        // $htmlNew = $helpers->onlyHyphen($url);

        // print_r($htmlNew);
        // $htmlNew = $helpers->delete_all_between('/*', '*/', $htmlNew);
        // // $htmlNew = $helpers->delete_all_between('//', '', $htmlNew);
        // // print_r($htmlNew);

        // $goutteClient = new Client(HttpClient::create([
        //     'timeout' => 60,
        // ]));
        // $crawler = $goutteClient->request('GET', $url);
        // $statusCode = $goutteClient->getResponse()->getStatusCode();

        // $html = $crawler->html();

        // $data = $statusCode = $goutteClient->getInternalResponse()->getHeader('X-Frame-Options');
        // // $data = $statusCode = $goutteClient->getInternalResponse()->getHeader('Strict-Transport-Security');

        // print_r($data);
    }



    public function getURLS($url, $domain, $host){
        $helpers = new Helper();
        $sitemapStatus = false;
        $xmlSitemapStatus = false;
        $sitemapVal = $url . "/sitemap";
        $sitemapValXml = $url . "/sitemap.xml";

        if(true){
        // if(count($this->tested_urls) < 5){
            if($this->sitemapCheckStatus){
                if($helpers->isValidUrl($sitemapVal)){
                    $goutteClient = new Client(HttpClient::create(['timeout' => 60]));
                    $crawler = $goutteClient->request('GET', $sitemapVal);
                    $links = $crawler->filter("a")->each(function($node){
                        return $node->extract(array('href'))[0];
                    });



                    if(count($links) > 0){
                        for($i=0;$i<count($links);$i++){
                            $content = $links[$i];
                            $val = $helpers->getAbsolutePath($content, $domain);
                            if($helpers->isUrl($val)){
                                $val = $this->returnURLUpdated($val);
                                if($val){
                                    if(str_contains($val, "?")){
                                        $val = substr($val, 0, strrpos( $val, '?'));
                                    }
                
                                    if(str_contains($val, $host)){
                                        if(!in_array($val, $this->tested_urls)){
                                            array_push($this->tested_urls, $val);
                                        }
                                    }
                                }
                            }
                        }

                        $sitemapStatus = true;
                    }
                }



                if($helpers->isValidUrl($sitemapValXml)){
                    $xmldata = @simplexml_load_file($sitemapValXml);
                    if($xmldata){
                        if(count($xmldata) > 0){
                            foreach($xmldata as $data){
                                $content = $data->loc;
                                $val = $helpers->getAbsolutePath($content, $domain);
                                if($helpers->isUrl($val)){
                                    $val = $this->returnURLUpdated($val);
                                    if($val){
                                        if(str_contains($val, "?")){
                                            $val = substr($val, 0, strrpos( $val, '?'));
                                        }

                                        if(str_contains($val, $host)){
                                            if(!in_array($val, $this->tested_urls)){
                                                array_push($this->tested_urls, $val);
                                            }
                                        }
                                    }
                                }
                            }

                            $xmlSitemapStatus = true;
                        }
                    }
                }

                $this->sitemapCheckStatus = false;
            }



            if(!$xmlSitemapStatus && !$sitemapStatus){



                $goutteClient = new Client(HttpClient::create(['timeout' => 60]));
                $crawler = $goutteClient->request('GET', $url);
                $meta = $crawler->filter("a")->each(function($node) {
                    if($node->extract(array('href'))){
                        $content = $node->extract(array('href'))[0];
                        return [
                            $content,
                        ];
                    }
                });



                if(count($meta) > 0){
                    for($i = 0;$i < count($meta);$i++){
                        $val = $helpers->getAbsolutePath($meta[$i][0], $domain);
                        if($helpers->isUrl($val)){
                            $val = $this->returnURLUpdated($val);
                
                            // if($helpers->isValidUrl($val)){
                            if(true){
                                if($val){
                                    if(str_contains($val, "?")){
                                        $val = substr($val, 0, strrpos( $val, '?'));
                                    }

                                    if(str_contains($val, $host)){
                                        if(!in_array($val, $this->tested_urls)){
                                            array_push($this->tested_urls, $val);
                                            $this->getURLS($val, $domain, $host);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }


            }
        }
    }



    public function returnURLUpdated($val){
        $val = rtrim(str_replace("www.", "", $val), "/");
        if(substr($val, -2) === "jp" || substr($val, -2) === "en"){
            $val = substr($val, 0, -2);
        }
        $val = rtrim(str_replace("www.", "", $val), "/");
        if(str_contains($val, "mailto")){
            $val = substr($val, 0, strpos($val, "mailto"));
        }
        if(str_contains($val, "#")){
            $val = substr($val, 0, strpos($val, "#"));
        }

        return $val;
    }


    public function index(){
        return view("index");
    }

    public function analysis($id){
        $data = TestResults::where("ref_id", $id)->get()->first();
        if($data){
            return view("analysis", compact("id"));
        }else{
            return view("index");

        }
    }

    public function tools(){
        return view("tools");
    }

    
    public function dashboard(){
        return view("dashboard");
    }

    public function appAnalysis(Request $request){
        if ($request->hasCookie('analysis_id')) {
            $id = Cookie::get('analysis_id');
            $data = TestResults::where("ref_id", $id)->get()->first();
            if(!$data){
              abort(404);
            }
            return view("user.analysis.index", compact("data"));
        } else {
            abort(404);
        }
    }
    
    public function urlDiscovery(){
        return view("url-discovery");
    }

    public function privacy(){
        return view("privacy");
    }

    public function terms(){
        return view("terms");
    }

    public function onboarding(){
        $user = Auth::user();
        return view("user.onboarding.index", compact("user"));
    }
}
