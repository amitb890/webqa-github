<?php

use Illuminate\Support\Facades\Route;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login/google', [App\Http\Controllers\LoginController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [App\Http\Controllers\LoginController::class, 'handleGoogleCallback']);

Route::get('/', [App\Http\Controllers\PagesController::class, 'index'])->name('index');
Route::resource('blog', App\Http\Controllers\BlogsController::class);
Route::resource('support', App\Http\Controllers\SupportController::class);
Route::get('/analysis-report/w/{id}', [App\Http\Controllers\PagesController::class, 'analysis'])->name('analysis');
Route::get('/tools', [App\Http\Controllers\BulkToolsController::class, 'index'])->name('tools-landing');
Route::get('/tool/{slug}', [App\Http\Controllers\BulkToolsController::class, 'show'])->name('tool');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');


Route::get('privacy-policy', [App\Http\Controllers\PagesController::class, 'privacy'])->name('privacy');
Route::get('terms-of-service', [App\Http\Controllers\PagesController::class, 'terms'])->name('terms');
Route::get('test1', [App\Http\Controllers\PagesController::class, 'test']);
Route::get('test2', [App\Http\Controllers\Test\TestController2::class, 'collectDashboard']);
Route::get('test12', [App\Http\Controllers\Test\TestController::class, 'brokenLinks']);

// Onboarding API routes
Route::post('/onboarding/detect-sitemaps', [App\Http\Controllers\OnboardingController::class, 'detectSitemaps']);
Route::post('/onboarding/fetch-urls', [App\Http\Controllers\OnboardingController::class, 'fetchUrls']);


Route::get('get-all-labels/{id}', [App\Http\Controllers\ProjectsController::class, 'getLabels']);



Route::get('/test', function(){
    list($width, $height) = getimagesize("https://assets.setmore.com/website/next/images/favicon/favicon-32x32.png"); 
    $arr = array('h' => $height, 'w' => $width );
    print_r($arr);

    $val = "http://hellosells.commailto:help@hellosells.com";
    $key = "AIzaSyCKPTSNwVnuuHkMvKmzZO3UDUb6q79JxRY";





    // echo substr($str, -2);
    // print_r(parse_url("https://setmore.com/"));

    // // $domain = "https://setmore.com";
    // // $file = "/partners";
    // // $xmldata = simplexml_load_file($file, $domain);
    // // print_r($xmldata);
    // // print_r($_SERVER["HTTP_USER_AGENT"]);

    // // $file = "https://www.twitch.tv/sitemap.xml";
    // // $element = @simplexml_load_file($file);
    // // if ($element === false) {
    // //     echo 1;
    // // }

    // if(str_contains($val, "mailto")){
    //     echo 1;
    //     $val = substr($val, 0, strpos($val, "mailto"));
    // }
    // // if(str_contains("#", $val)){
    // //     $val = substr($val, 0, strpos($val, "#"));
    // // }

    // echo $val;
    
    // $contents = $this->file_get_contents_curl($val);
    // print_r($contents);

    // // Call Google PageSpeed Insights API 
    // $googlePagespeedData = file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$val&screenshot=true&key=$key"); 
    
    // // Decode json data 
    // $googlePagespeedData = json_decode($googlePagespeedData, true); 
    
    // // Retrieve screenshot image data 
    // $screenshot_data = $googlePagespeedData['lighthouseResult']['audits']['final-screenshot']['details']['data']; 
    // echo $screenshot_data;

    https://www.vmware.com/in.html

    \Artisan::call('migrate:fresh');
    // $url = "https://www.setmore.com/free-plan";
    // $content = substr($url, strrpos($url, '/') + 1);;
    // echo $content;

    // $content = "";
    // print_r(getimagesize($content));

});


Route::get('/test-archive', [App\Http\Controllers\PagesController::class, 'testResults'])->name('testResults');
Route::get('/webtests', [App\Http\Controllers\PagesController::class, 'getResults'])->name('get.results');





Route::prefix('api')->group(function () {
    Route::get('/cached-test', [App\Http\Controllers\Api\CachedTestController::class, 'show']);
    Route::post('/cached-test', [App\Http\Controllers\Api\CachedTestController::class, 'store']);
});
Route::middleware('auth')->group(function () {
    Route::middleware('onboarding')->group(function () {
      Route::get('/test-archive-web-app', [App\Http\Controllers\PagesController::class, 'testResults'])->name('testResults');
       Route::get('website-tracker', [App\Http\Controllers\TrackerController::class, 'index'])->name('tracker');
        Route::get('website-tracker-test', [App\Http\Controllers\TrackerController::class, 'indexTest'])->name('trackerTest');
        Route::get('dashboard', [App\Http\Controllers\PagesController::class, 'dashboard'])->name('dashboard');
        Route::get('/analysis-report/{ref_id?}', [App\Http\Controllers\PagesController::class, 'appAnalysis'])
        ->name('app-analysis');
        Route::resource('profile', App\Http\Controllers\ProfileController::class);
        Route::resource('settings', App\Http\Controllers\SettingsController::class);
        Route::put('settings/save-sitemap/{id}', [App\Http\Controllers\SettingsController::class, 'saveSitemap'])->name('saveSitemap');
        Route::put('settings/save-broken-links-excluded/{id}', [App\Http\Controllers\SettingsController::class, 'saveBrokenLinksExcluded'])->name('saveBrokenLinksExcluded'); 
        Route::get('report-settings', [App\Http\Controllers\ReportSettingsController::class, 'edit'])->name('report-settings.edit');
        Route::put('report-settings', [App\Http\Controllers\ReportSettingsController::class, 'update'])->name('report-settings.update');
        Route::resource('reports', App\Http\Controllers\ReportsController::class);
        Route::post('set-active-project', [App\Http\Controllers\ReportsController::class, 'setActiveProject'])->name('setActiveProject');

        Route::resource('projects', App\Http\Controllers\ProjectsController::class);
        Route::post('delete-url', [App\Http\Controllers\ProjectsController::class, 'deleteUrl'])->name('delete-url');
        Route::post('update-label-status', [App\Http\Controllers\ProjectsController::class, 'updateLabelStatus'])->name('update-label-status');
        Route::post('update-dashboard-data', [App\Http\Controllers\ProjectsController::class, 'updateDashboardData'])->name('update-dashboard-data');
        Route::post('save-dashboard-data', [App\Http\Controllers\ProjectsController::class, 'saveDashboardData'])->name('saveDashboardData');
        Route::post('update-dashboard-status', [App\Http\Controllers\ProjectsController::class, 'updateDashboardStatus'])->name('updateDashboardStatus');
        Route::post('update-google-status', [App\Http\Controllers\ProjectsController::class, 'updateGoogleStatus'])->name('updateGoogleStatus');
        Route::post('reset-google-status/{id}', [App\Http\Controllers\ProjectsController::class, 'resetGoogleStatus'])->name('resetGoogleStatus');
        Route::get('get-test-data/{id}', [App\Http\Controllers\ProjectsController::class, 'getTestData'])->name('getTestData');
        Route::get('get-test-data-single/{id}/{label}', [App\Http\Controllers\ProjectsController::class, 'getTestDataSingle'])->name('getTestDataSingle');
        Route::post('editProject', [App\Http\Controllers\ProjectsController::class, 'editProject'])->name('editProject');
        Route::post('check-unique-project-name', [App\Http\Controllers\ProjectsController::class, 'checkUniqueProjectName'])->name('checkUniqueProjectName');
        Route::post('check-unique-project-homepage', [App\Http\Controllers\ProjectsController::class, 'checkUniqueProjectHomepage'])->name('checkUniqueProjectHomepage');
        Route::post('editProject', [App\Http\Controllers\ProjectsController::class, 'editProject'])->name('editProject');
        Route::get('get-projects-data', [App\Http\Controllers\ProjectsController::class, 'getProjectData'])->name('getProjectData');
        Route::get('get-show-dashboard-status/{id}', [App\Http\Controllers\ProjectsController::class, 'getShowDashboardStatus'])->name('getShowDashboardStatus');
        Route::get('get-google-status/{id}', [App\Http\Controllers\ProjectsController::class, 'getGoogleStatus'])->name('getGoogleStatus');
        Route::get('get-urls/{id}', [App\Http\Controllers\DashboardController::class, 'getUrlsList'])->name('getUrlsList'); 
        Route::post('get-alerts', [App\Http\Controllers\ProjectsController::class, 'getAlerts'])->name('get-alerts'); 
        Route::post('update-alert-status', [App\Http\Controllers\ProjectsController::class, 'updateAlertStatus'])->name('update-alert-status'); 

    });
    Route::post('check-valid-url', [App\Http\Controllers\ProjectsController::class, 'checkValidUrl'])->name('checkValidUrl');
    Route::post('check-sitemap-urls', [App\Http\Controllers\ProjectsController::class, 'checkSitemapUrls'])->name('checkSitemapUrls');
       
    Route::post('createProject', [App\Http\Controllers\ProjectsController::class, 'createProject'])->name('createProject');
    Route::post('create-feature-request', [App\Http\Controllers\FeatureRequestController::class, 'store'])->name('createFeatureRequest');
    Route::middleware('onboardingexists')->group(function () {
        Route::get('onboarding', [App\Http\Controllers\PagesController::class, 'onboarding'])->name('onboarding');
    });


    Route::prefix('data')->group(function(){
        Route::get('/get-settings/{id}', [App\Http\Controllers\DataController::class, 'getSettings'])->name('test.get-settings');
    });
});

Route::namespace("TestDetails")->prefix('test-details')->group(function(){
    Route::post('/title', [App\Http\Controllers\TestDetailsController::class, 'title'])->name('test.title');
    Route::post('/description', [App\Http\Controllers\TestDetailsController::class, 'description'])->name('test.description');
    Route::post('/robots-meta', [App\Http\Controllers\TestDetailsController::class, 'robots'])->name('test.robots-meta');
    Route::post('/url-slug', [App\Http\Controllers\TestDetailsController::class, 'urlSlug'])->name('test.url-slug');
    Route::post('/canonical-url', [App\Http\Controllers\TestDetailsController::class, 'canonical'])->name('test.canonical-url');
    Route::post('/og-tags', [App\Http\Controllers\TestDetailsController::class, 'ogTags'])->name('test.og-tags');
    Route::post('/twitter-tags', [App\Http\Controllers\TestDetailsController::class, 'twitterTags'])->name('test.twitter-tags');
    Route::post('/http-status-code', [App\Http\Controllers\TestDetailsController::class, 'httpStatusCode'])->name('test.http-status-code');
    Route::post('/broken-links', [App\Http\Controllers\TestDetailsController::class, 'brokenLinks'])->name('test.broken-links');
    Route::post('/security-headers', [App\Http\Controllers\TestDetailsController::class, 'securityHeaders'])->name('test.security-headers');
    Route::post('/coding-best-practices', [App\Http\Controllers\TestDetailsController::class, 'codingBestPractices'])->name('test.coding-best-practices');
    Route::post('/page-size', [App\Http\Controllers\TestDetailsController::class, 'pageSize'])->name('test.page-size');
    Route::post('/mobile-friendly', [App\Http\Controllers\TestDetailsController::class, 'mobileFriendly'])->name('test.mobile-friendly');
    Route::post('/google-page-speed-insights', [App\Http\Controllers\TestDetailsController::class, 'googleInsights'])->name('test.google-page-speed-insights');
    Route::post('/google-page-speed-lighthouse', [App\Http\Controllers\TestDetailsController::class, 'googleLighthouse'])->name('test.google-page-speed-lighthouse');
    Route::post('/google-page-speed-core-web-vitals', [App\Http\Controllers\TestDetailsController::class, 'googleCoreWebVitals'])->name('test.google-page-speed-core-web-vitals');
    Route::post('/xml-sitemap', [App\Http\Controllers\TestDetailsController::class, 'xmlSitemap'])->name('test.xml-sitemap');
    Route::post('/html-sitemap', [App\Http\Controllers\TestDetailsController::class, 'htmlSitemap'])->name('test.html-sitemap');
    Route::post('/images', [App\Http\Controllers\TestDetailsController::class, 'images'])->name('test.images');
});




Route::post('/test/start-dashboard-test', [App\Http\Controllers\Test\TestController2::class, 'startTests']);
Route::post('/test/update-single-dashboard-test', [App\Http\Controllers\Test\TestController2::class, 'updateSingleTest']);
Route::get('/api/check-status-dashboard/{testId}', [App\Http\Controllers\Test\TestController2::class, 'checkStatus']);

Route::post('/api/start-tests', [App\Http\Controllers\LighthouseController::class, 'startTests']);
Route::get('/api/check-status/{testId}', [App\Http\Controllers\LighthouseController::class, 'checkStatus']);
Route::post('/api/update-google-recheck-active-urls', [App\Http\Controllers\LighthouseController::class, 'updateGoogleRecheckActiveUrls']);


Route::namespace("Test")->prefix('test')->group(function(){
    Route::post('/get-analysis', [App\Http\Controllers\Test\TestController::class, 'getAnalysis'])->name('test.get-analysis');
    Route::post('/collect', [App\Http\Controllers\Test\TestController::class, 'collect'])->name('test.collect');
    Route::post('/projectUrl', [App\Http\Controllers\Test\TestController::class, 'projectUrl'])->name('test.projectUrl');
    Route::post('/collect2', [App\Http\Controllers\Test\TestController2::class, 'collectDashboard'])->name('test.collect2');
    Route::post('/email-report', [App\Http\Controllers\Test\TestController::class, 'emailReport'])->name('test.email-report');
    Route::post('/meta-viewport', [App\Http\Controllers\Test\TestController::class, 'metaViewport'])->name('test.meta-viewport');
    Route::post('/frameset', [App\Http\Controllers\Test\TestController::class, 'frameset'])->name('test.frameset');
    Route::post('/doctype', [App\Http\Controllers\Test\TestController::class, 'doctype'])->name('test.doctype');
    Route::post('/http-status-code', [App\Http\Controllers\Test\TestController::class, 'httpStatusCode'])->name('test.http-status-code');
    Route::post('/page-size', [App\Http\Controllers\Test\TestController::class, 'pageSize'])->name('test.page-size');
    Route::post('/hsts-header', [App\Http\Controllers\Test\TestController::class, 'hstsHeader'])->name('test.nested-tables');
    Route::post('/nested-tables', [App\Http\Controllers\Test\TestController::class, 'nestedTables'])->name('test.hsts-header');
    Route::post('/x-frame-options-header', [App\Http\Controllers\Test\TestController::class, 'XFrameOptions'])->name('test.x-frame-options-header');
    Route::post('/content-security-policy-header', [App\Http\Controllers\Test\TestController::class, 'contentSecurity'])->name('test.content-security-policy-header');
    Route::post('/bad-content', [App\Http\Controllers\Test\TestController::class, 'badContentType'])->name('test.bad-content');
    Route::post('/ssl-certificate', [App\Http\Controllers\Test\TestController::class, 'checkSSLCertificate'])->name('test.ssl-certificate');
    Route::post('/directory-browsing', [App\Http\Controllers\Test\TestController::class, 'directoryBrowsingEnable'])->name('test.directory-browsing');
    Route::post('/css-caching-enable', [App\Http\Controllers\Test\TestController::class, 'cssCachingEnable'])->name('test.css-caching-enable');
    Route::post('/js-caching-enable', [App\Http\Controllers\Test\TestController::class, 'jsCachingEnable'])->name('test.js-caching-enable');
    Route::post('/mobile-friendly', [App\Http\Controllers\Test\TestController::class, 'mobileFriendly'])->name('test.mobile-friendly');

    Route::post('/safe-browsing', [App\Http\Controllers\Test\TestController::class, 'safeBrowsing'])->name('test.safe-browsing');
    Route::post('/cross-origin-links', [App\Http\Controllers\Test\TestController::class, 'crossOriginLinks'])->name('test.cross-origin-links');
    Route::post('/protocol-relative-resource', [App\Http\Controllers\Test\TestController::class, 'protocolRelativeResource'])->name('test.protocol-relative-resource');
    Route::post('/h1-heading-tag', [App\Http\Controllers\Test\TestController::class, 'h1HeadindTag'])->name('test.h1-heading-tag');
    Route::post('/robot-text-test', [App\Http\Controllers\Test\TestController::class, 'robotTextTtest'])->name('test.robot-text-test');    
    Route::post('/broken-links', [App\Http\Controllers\Test\TestController::class, 'brokenLinks'])->name('test.broken-links');
    
    Route::post('/title', [App\Http\Controllers\Test\TestController::class, 'title'])->name('test.title');
    Route::post('/description', [App\Http\Controllers\Test\TestController::class, 'description'])->name('test.description');
    Route::post('/robots-meta', [App\Http\Controllers\Test\TestController::class, 'robots'])->name('test.robots-meta');
    Route::post('/url-slug', [App\Http\Controllers\Test\TestController::class, 'urlSlug'])->name('test.url-slug');
    Route::post('/canonical-url', [App\Http\Controllers\Test\TestController::class, 'canonical'])->name('test.canonical-url');
    Route::post('/og-tags', [App\Http\Controllers\Test\TestController::class, 'ogTags'])->name('test.og-tags');
    Route::post('/twitter-tags', [App\Http\Controllers\Test\TestController::class, 'twitterTags'])->name('test.twitter-tags');
    Route::post('/favicon', [App\Http\Controllers\Test\TestController::class, 'favicon'])->name('test.favicon');
    Route::post('/xml-sitemap', [App\Http\Controllers\Test\TestController::class, 'xmlSitemap'])->name('test.xml-sitemap');
    Route::post('/xml-sitemap-multiple', [App\Http\Controllers\Test\TestController::class, 'xmlSitemapMultiple'])->name('test.xml-sitemap-multiple');
    Route::post('/html-sitemap', [App\Http\Controllers\Test\TestController::class, 'htmlSitemap'])->name('test.html-sitemap');
    Route::post('/images', [App\Http\Controllers\Test\TestController::class, 'images'])->name('test.images');
    Route::post('/html-compression', [App\Http\Controllers\Test\TestController::class, 'htmlCompression'])->name('test.html-compression');
    Route::post('/css-compression', [App\Http\Controllers\Test\TestController::class, 'cssCompression'])->name('test.css-compression');
    Route::post('/js-compression', [App\Http\Controllers\Test\TestController::class, 'jsCompression'])->name('test.js-compression');
    Route::post('/gzip-compression', [App\Http\Controllers\Test\TestController::class, 'gzipCompression'])->name('test.gzip-compression');
    Route::post('/google-page-speed-insights', [App\Http\Controllers\Test\TestController::class, 'googleInsights'])->name('test.google-page-speed-insights');
    Route::post('/google-page-speed-lighthouse', [App\Http\Controllers\Test\TestController::class, 'googleLighthouse'])->name('test.google-page-speed-lighthouse');
    Route::post('/google-page-speed-core-web-vitals', [App\Http\Controllers\Test\TestController::class, 'googleCoreWebVitals'])->name('test.google-page-speed-core-web-vitals');
});



// admin
Route::namespace("Admin")->prefix('control')->group(function(){
    Route::namespace('Auth')->prefix('admin')->group(function(){
        Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'create'])->name('admin.login');
        Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'store'])->name('admin.store');
        Route::post('logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'destroy'])->name('admin.logout');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/admin', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');

        Route::namespace("Users")->prefix('admin/users')->group(function(){
            Route::get('/', [App\Http\Controllers\Admin\Users\UsersController::class, 'view'])->name('admin.users.view');
            Route::post('/search', [App\Http\Controllers\Admin\Users\UsersController::class, 'search'])->name('admin.users.search');
            Route::delete('/delete/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'delete'])->name('admin.user.destroy');
            Route::put('/activate/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'activate'])->name('admin.user.activate');
        });
    });
});


Route::get('/services', function () {
    return view('services');
});

Route::get('/services/website-improvement', function () {
    return view('website-improvement');
});

Route::get('/services/website-audit', function () {
    return view('website-audit');
});

Route::get('/services/page-speed-optimization', function () {
    return view('page-speed-optimization');
});


Route::get('/about', function () {
    return view('aboutus');
});
Route::get('/features', function () {
    return view('feature-root-page');
});
Route::get('/features/website-tracker', function () {
    return view('feature-childpage-webtracker');
});
Route::get('/features/settings', function () {
    return view('feature-childpage-settings');
});
Route::get('/features/reports', function () {
    return view('feature-childpage-reports');
});
Route::get('/features/webpage-audit', function () {
    return view('feature-childpage-audtest');
});

require __DIR__.'/auth.php';
