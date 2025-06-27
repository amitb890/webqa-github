<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects;
use App\Models\LighthouseTest;
use App\Models\UrlsList;
use App\Models\Alerts;
use App\Models\projectSettings;
use App\Models\TestLabel;
use App\Models\ProjectTestDetails;
use App\Models\DashboardTests;
use App\Models\SettingsSub;
use App\Rules\CustomURL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Helper;
use AllLabels;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables; // Import the DataTables class
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\File;


class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Projects::where("user_id", Auth::id())
                            ->select('id', 'favicon', 'name', 'homepage')->get()->sortByDesc("id");
        return view("user.projects.index", compact("projects"));
    }

    public function removeDashboardData($projectId){
        DashboardTests::where('project_id', $projectId)->delete();
        Projects::where('id', $projectId)->update(['dashboard_show_status'=>0]);
        return response()->json(['status' => 1, 'msg' => 'Success.']);
    }


    public function updateDashboardData($status, $url, $test_title, $label, $data, $projectId, $testType){
        $testDetails = new ProjectTestDetails();
        $testDetails->project_id = $projectId;
        $testDetails->user_id = Auth::id();
        $testDetails->data = $data;
        $testDetails->label = $label;
        $testDetails->test_title = $test_title;
        $testDetails->url = $url;
        $testDetails->status = $status;
        $testDetails->save();
        return response()->json(['status' => 1, 'msg' => 'Success.']);
    }

    public function updateAlertStatus(Request $request){
        $projectId = $request->input('project_id');
        Alerts::where('project_id', $projectId)->update(['status'=>0]);
        return response()->json(['status' => 1, 'msg' => 'Success.']);
    }

    public function getAlerts(Request $request){
        $page = $request->input('page');
        $projectId = $request->input('project_id');
        $alerts = Alerts::where('user_id', Auth::id())->where('project_id', $projectId)->where('page', $page)->where('status', 1)->get();
        return response()->json(['alerts'=>$alerts]);
    }

    public function saveDashboardData(Request $request){
        $data = $request->input('data');
        $testDetails = new ProjectTestDetails();
        $testDetails->project_id = $data["projectId"];
        $testDetails->data = $data["testDetails"];
        $testDetails->save();
        Projects::where('id', $data["projectId"])->update(['dashboard_show_status'=>1]);
        return response()->json(['status' => 1, 'msg' => 'Success.']);
    } 
    
    public function updateDashboardStatus($projectId){
        Projects::where('id', $projectId)->update(['dashboard_show_status'=>1]);
        return response()->json(['status' => 1, 'msg' => 'Success.']);
    }

    public function updateGoogleStatus($projectId){
        Projects::where('id', $projectId)->update(['google_show_status'=>1]);
        return response()->json(['status' => 1, 'msg' => 'Success.']);
    }

    public function updateTestingStatus($projectId){
        Projects::where('id', $projectId)->update(['dashboard_show_status'=>1]);
        return response()->json(['status' => 1, 'msg' => 'Success.']);
    }

    public function updateLabelStatus(Request $request){
        $status = $request->input('status');
        $test_title = $request->input('test_title');
        $projectId = $request->input('projectId');

        if($test_title === "security_labels" || $test_title === "cbp_labels"){
            TestLabel::where('project_id', $projectId)->where("dashboard_parent", $test_title)->update(['show_dashboard_status'=>$status]);
        }else{
            TestLabel::where('project_id', $projectId)->where("db_name", $test_title)->update(['show_dashboard_status'=>$status]);
        }

        return response()->json(['status' => 1, 'msg' => 'Success.']);
    }

    public function deleteUrl(Request $request){
        $projectId = $request->input('projectId');
        $url = $request->input('url');

        ProjectTestDetails::where('project_id', $projectId)->where('url', $url)->delete();
    }


    public function getLabels($project_id){
        $active_settings_labels = [];
        $active_settings_seo_labels = [];
        $active_settings_performance_labels = [];
        $active_settings_cbp_labels = [];
        $active_settings_security_labels = [];


        $all_labels = TestLabel::where("project_id", $project_id)->get();
        $seo_labels = TestLabel::where("project_id", $project_id)->where("parent", "seo")->get();
        $performance_labels = TestLabel::where("project_id", $project_id)->where("parent", "performance")->get();
        $cbp_labels = TestLabel::where("project_id", $project_id)->where("parent", "bestPractices")->get();
        $security_labels = TestLabel::where("project_id", $project_id)->where("parent", "security")->get();

        $settings_labels = projectSettings::where("projects_id", $project_id)->get()->first();
        foreach ($settings_labels->toArray() as $key => $value) {
            foreach($all_labels as $label){
                if($label->db_name === $key){
                    if($value === 1){
                        array_push($active_settings_labels, $label);
                    }
                }
            }
        }

        foreach ($settings_labels->toArray() as $key => $value) {
            foreach($seo_labels as $label){
                if($label->db_name === $key){
                    if($value === 1){
                        array_push($active_settings_seo_labels, $label);
                    }
                }
            }
        }

        foreach ($settings_labels->toArray() as $key => $value) {
            foreach($performance_labels as $label){
                if($label->db_name === $key){
                    if($value === 1){
                        array_push($active_settings_performance_labels, $label);
                    }
                }
            }
        }

        foreach ($settings_labels->toArray() as $key => $value) {
            foreach($cbp_labels as $label){
                if($label->db_name === $key){
                    if($value === 1){
                        array_push($active_settings_cbp_labels, $label);
                    }
                }
            }
        }

        foreach ($settings_labels->toArray() as $key => $value) {
            foreach($security_labels as $label){
                if($label->db_name === $key){
                    if($value === 1){
                        array_push($active_settings_security_labels, $label);
                    }
                }
            }
        }

        $all_labels = $active_settings_labels;
        $seo_labels = $active_settings_seo_labels;
        $performance_labels = $active_settings_performance_labels;
        $cbp_labels = $active_settings_cbp_labels;
        $security_labels = $active_settings_security_labels;

        return response()->json([
            'status' => 1, 
            'msg' => 'Success.', 
            'all_labels' => $all_labels,
            'seo_labels' => $seo_labels,
            'performance_labels' => $performance_labels,
            'cbp_labels' => $cbp_labels,
            'security_labels' => $security_labels,
        ]);
    }


    public function getTestData($id){
        $project = Projects::find($id);
        $details = DashboardTests::where("project_id", $id)->get()->first();
        $lighthouseTest = LighthouseTest::where('project_id', $id)->first();
        return response()->json(['status' => 1, 'msg' => 'Success.', 'test_details' => $details, 'project' => $project, 'lighthouse' => $lighthouseTest]);
    }

    public function getTestDataSingle($id, $label){
        $project = Projects::find($id);
        $security_labels = ["is_safe_browsing", "cross_origin_links", "protocol_relative_resource", "content_security_policy_header", "x_frame_options_header", "hsts_header", "bad_content_type", "ssl_certificate_enable", "folder_browsing_enable"];
        $cbp_labels = ["html_compression", "css_compression", "js_compression", "gzip_compression", "nested_tables", "frameset", "css_caching_enable", "js_caching_enable", "frameset"];

        if($label === "security_labels"){
            $details = ProjectTestDetails::where("project_id", $id)->whereIn("test_title", $security_labels)->get();
        }else if($label === "cbp_labels"){
            $details = ProjectTestDetails::where("project_id", $id)->whereIn("test_title", $cbp_labels)->get();
        }else{
            $details = ProjectTestDetails::where("project_id", $id)->where("test_title", $label)->get();
        }
        return response()->json(['status' => 1, 'msg' => 'Success.', 'test_details' => $details, 'project' => $project]);
    }


    

    public function getShowDashboardStatus($id){
        $project = Projects::find($id);
        $details = DashboardTests::where("project_id", $id)->get()->first();
        $detailsStatus = "";
        if($details){
            $detailsStatus = $details->status;
        }else{
            $detailsStatus = "pending";
        }
        $status = $project->dashboard_show_status && $detailsStatus === "completed";
        return response()->json(['status' => 1, 'msg' => 'Success.', 'dashboardStatus' => $status, 'details_progress' => $detailsStatus]);
    }


    public function getGoogleStatus($id){
        $project = Projects::find($id);
        return response()->json(['status' => 1, 'msg' => 'Success.', 'googleStatus' => $project->google_show_status]);
    }

    /**
     * Get project data for DataTables.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse JSON response for DataTables.
     */
    public function getProjectData(Request $request)
    {
        // Initialize a query builder for the 'Projects' table
        $projects = Projects::select();

        // Apply search if a search term is provided in the request
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');

            // Add a subquery for search conditions using 'orWhere' to match 'name' or 'homepage'
            $projects->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('homepage', 'like', "%$search%");
            });
        }

        // Use the DataTables library to format the query results for AJAX response
        return DataTables::of($projects)
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("user.projects.create");
    }

    /**
     * Display the project creation form.
     *
     * @return \Illuminate\View\View
     */
    public function projectCreate()
    {
        return view("user.projects.project_create");
    }

    /**
     * Display a list of projects belonging to the authenticated user.
     *
     * This function retrieves a list of projects associated with the currently
     * authenticated user, including their associated URLs. The projects are sorted
     * in descending order based on their IDs. The list is then passed to the view
     * for rendering.
     *
     * @return \Illuminate\View\View
     */
    public function projectsList()
    {
        $projects = Projects::where("user_id", Auth::id())->with("urls")->get()->sortByDesc("id");
        return view("user.projects.index", compact("projects"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
    }


    /**
     * Store a new project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createProject(Request $request)
    {
        $helpers = new Helper();

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'homepage' => ['required', new CustomURL],
        ], [
            'name.required' => 'Project name is required',
            'homepage.required' => 'Enter your website address',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'msg' => $validator->errors()->toArray()]);
        } else {

            $projectState = false;
            $project = new Projects();
            $project->user_id = Auth::id();
            $project->name = $request->input('name');

            // converting url to origin
            $rawInput = $request->input('homepage');

            // Step 1: Trim and remove invisible characters
            $rawInput = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', trim($rawInput));

            // Step 2: Add scheme if missing
            if (!preg_match('#^https?://#i', $rawInput)) {
                $rawInput = 'https://' . $rawInput;
            }

            // Step 3: Parse URL and safely rebuild
            $parsed = parse_url($rawInput);

            $scheme = isset($parsed['scheme']) ? $parsed['scheme'] : 'https';
            $host   = isset($parsed['host']) ? $parsed['host'] : '';

            $homepage = $scheme . '://' . $host;


            // get project favicon
            $favicon = $helpers->getFavicon($homepage);


            if($favicon === ""){
                $favicon_name = "default";
            }else{
                $favicon = $favicon != "" ? $helpers->normalizeFaviconUrl($favicon, $homepage) : "";
                $favicon = $favicon != "" ? $helpers->getAbsolutePath($favicon, $homepage) : "";

                $favicon_name = $favicon;
                $imageUrl = $favicon;
                $imageResponse = Http::get($favicon);
                $imageContent = $imageResponse->body();

                // Extract the filename from the URL
                $filename = uniqid() . basename($imageUrl);

                Storage::disk('project')->put('images/' . $filename, $imageContent);
                $favicon_name = Storage::disk('project')->url('images/' . $filename);
            }






            $project->homepage = $homepage;
            $project->favicon = $favicon_name;
            $project->landing_page_preview = "default";

            $urlsListState = true;
            $urlsList = null;
            $validatorN = null;

            if ($request->input('urlsList') != "") {
                $urlsList = explode("\n", $request->input('urlsList'));
                if (count($urlsList) > 0) {
                    $urlsListState = false;
                    foreach ($urlsList as $url) {
                        $validatorN = \Validator::make(['urlsList' => $url], [
                            'urlsList' => [new CustomURL],
                        ]);

                        if (!$validatorN->passes()) {
                            return response()->json(['status' => 0, 'msg' => $validatorN->errors()->toArray()]);
                        }
                    }
                }
            }


            $projectState = $project->save();

            foreach ($urlsList as $url) {
                $urlF = new UrlsList();
                $urlF->projects_id = $project->id;
                $urlF->url = $url;
                $urlsListState = $urlF->save();
            }

            // create test labels for project
            $allLabels = new AllLabels();
            $labels = $allLabels->getAllLabels($project->id, Auth::id());
            foreach($labels as $d){
                TestLabel::create([
                    'user_id' => $d['user_id'],
                    'project_id' => $d['project_id'],
                    'reportsUrl' => $d['reportsUrl'],
                    'urlDetails' => $d['urlDetails'],
                    'display_name' => $d['display_name'],
                    'name' => $d['name'],
                    'db_name' => $d['db_name'],
                    'url' => $d['url'],
                    'is_dashboard_status' => $d['is_dashboard_status'],
                    'analysis_status' => $d['analysis_status'],
                    'bulk_status' => $d['bulk_status'],
                    'show_dashboard_status' => $d['show_dashboard_status'],
                    'has_dashboard_parent' => $d['has_dashboard_parent'],
                    'dashboard_parent' => $d['dashboard_parent'],
                    'parent' => $d['parent'],
                ]);
            }

            $settings = new projectSettings();
            $settings->projects_id = $project->id;
            $settingsState = $settings->save();

            $settingsSub = new SettingsSub();
            $settingsSub->project_settings_id = $settings->id;
            $settingsSub->xml_sitemap_val = $request->input('xmlSitemap');
            $settingsSub->html_sitemap_val = $request->input('htmlSitemap');
            $settingsSubState = $settingsSub->save();
            if ($projectState && $urlsListState && $settingsState && $settingsSubState) {
                $successMessage = 'Project "' . $project->name . '" created successfully with default settings. You can override the settings of the project <a href="' . route('settings.edit', $project->id) . '">here</a>.';
                if ($request->input('route') != "projects.create") {
                    session()->flash('alert-class', 'alert-success alert-success-custom');
                    session()->flash('message', $successMessage);
                }
                return response()->json(['status' => 1, 'msg' => $successMessage, 'data' => $project]);
            } else {
                return response()->json(['status' => 3, 'msg' => 'There was an error while creating a new project, please try again later.']);
            }
        }
    }

    /**
     * Edit a project based on the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editProject(Request $request)
    {
        // Create an instance of the Helper class
        $helpers = new Helper();

        // Validate the incoming request data
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'homepage' => ['required', new CustomURL],
        ], [
            'name.required' => 'Project name is required',
            'homepage.required' => 'Enter your website address',
        ]);

        // If validation fails, return error response with validation errors
        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'msg' => $validator->errors()->toArray()]);
        } else {
            // Initialize variables and retrieve project by ID
            $projectState = false;
            $project = Projects::find($request->input('projectId'));
            $project->user_id = Auth::id();
            $project->name = $request->input('name');

            // Convert homepage URL to origin
            $homepageRequest = parse_url($request->input('homepage'));
            $homepage = $homepageRequest["scheme"] . "://" . $homepageRequest["host"];

            // Get project favicon
            $favicon = $helpers->getFavicon($homepage);
            $favicon = $favicon != "" ? $helpers->getAbsolutePath($favicon, $homepage) : "";
            $favicon_name = "";
            if (!$helpers->isValidUrl($favicon)) {
                $favicon_name = "default";
            } else {
                if ($project->homepage != $homepage) {
                    $favicon_name = $favicon;
                    $imageUrl = $favicon;
                    $imageResponse = Http::get($favicon);
                    $imageContent = $imageResponse->body();

                    // Extract the filename from the URL
                    $filename = basename($imageUrl);
                    Storage::disk('project')->put('images/' . $filename, $imageContent);
                    $favicon_name = Storage::disk('project')->url('images/' . $filename);

                    if ($project->favicon != 'default') {

                        $path = parse_url($project->favicon, PHP_URL_PATH);

                        // Get the absolute server path
                        $serverPath = public_path($path);

                        // Delete the file if it exists
                        if (file_exists($serverPath)) {
                            unlink($serverPath);
                        }
                    }
                } else {
                    $favicon_name = $project->favicon;
                }
            }

            // Update project properties
            $project->homepage = $homepage;
            $project->favicon = $favicon_name;
            $project->landing_page_preview = "default";

            // Handle URLs list validation and storage
            $urlsListState = true;
            $urlsList = null;
            $validatorN = null;
            UrlsList::where('projects_id', $project->id)->delete();
            if ($request->input('urlsList') != "") {
                $urlsList = explode("\n", $request->input('urlsList'));
                if (count($urlsList) > 0) {
                    $urlsListState = false;

                    foreach ($urlsList as $url) {
                        $validatorN = \Validator::make(['urlsList' => $url], [
                            'urlsList' => [new CustomURL],
                        ]);

                        // If URL validation fails, return error response
                        if (!$validatorN->passes()) {
                            return response()->json(['status' => 0, 'msg' => $validatorN->errors()->toArray()]);
                        }
                        $projectState = $project->save();

                        // Save URL to UrlsList model
                        $urlF = new UrlsList();
                        $urlF->projects_id = $project->id;
                        $urlF->url = $url;
                        $urlsListState = $urlF->save();
                    }
                }
            }

            // Finalize project and settings updates
            if ($urlsList) {
                if (count($urlsList) > 0) {
                    if (!$validatorN->passes()) {
                        $projectState = $project->save();
                    }
                }
            } else {
                $projectState = $project->save();
            }

            // Update sub-settings
            $settingsSub = SettingsSub::find($request->input('settingsSubId'));
            $settingsSub->xml_sitemap_val = $request->input('xmlSitemap');
            $settingsSub->html_sitemap_val = $request->input('htmlSitemap');
            $settingsSubState = $settingsSub->save();

            // Return success or error response based on the update results
            if ($projectState && $urlsListState && $settingsSubState) {
                $successMessage = 'Project "' . $project->name . '" updated successfully with default settings. You can override the settings of the project <a href="' . route('settings.edit', $project->id) . '">here</a>.';
                if ($request->input('route') != "projects.edit") {
                    session()->flash('alert-class', 'alert-success alert-success-custom');
                    session()->flash('message', $successMessage);
                }
                return response()->json(['status' => 1, 'msg' => $successMessage, 'data' => $project]);
            } else {
                return response()->json(['status' => 3, 'msg' => 'There was an error while updating the project, please try again later.']);
            }
        }
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
        $project = Projects::where('id', $id)->with('urls')->first();
        $projectSettings = projectSettings::where('projects_id', $project->id)->first();
        $settingsSubId = '';
        if ($projectSettings) {
            $settingsSub = SettingsSub::where('project_settings_id', $projectSettings->id)->first();
            $settingsSubId = $settingsSub->id;
            if ($settingsSub) {
                $htmlSitemap = explode(',', $settingsSub->html_sitemap_val);
                $xmlSitemap = explode(',', $settingsSub->xml_sitemap_val);
            }
        }
        return view('user.projects.edit', compact('project', 'htmlSitemap', 'xmlSitemap', 'settingsSubId', 'id'));
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
        //
    }

    /**
     * Delete a project and its associated settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id The ID of the project to be deleted
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            $isActive = false;

            $project = Projects::where("user_id", Auth::id())->get();
            if ($project->count() != 1) {
                // Delete the project with the given ID
                Projects::where('id', $id)->delete();
                UrlsList::where('projects_id', $id)->delete();
                $projectsCount = Projects::where("user_id", Auth::id())->count();

                // Find the project settings associated with the deleted project
                $projectSettings = projectSettings::where('projects_id', $id)->first();

                if ($projectSettings) {
                    // Delete any associated settings sub-entries linked to the project settings
                    SettingsSub::where('project_settings_id', $projectSettings->id)->delete();

                    // Delete the project settings themselves
                    $projectSettings->delete();
                    if (isset($_COOKIE["activeProject"])) {
                        $state = false;
                        $activeProjectId = explode('-', $_COOKIE["activeProject"]);
                        if (count($activeProjectId) > 1) {
                            $activeProject = $activeProjectId[1];
                        } else {
                            $activeProject = $_COOKIE["activeProject"];
                        }
                        if ($activeProject == $id) {
                            $project = Projects::latest()->first();
                            $isActive = true;
                            return response()->json(['status' => 3, 'data' => $project, 'projectsCount' => $projectsCount]);
                        }
                    }
                }
            } else {
                return response()->json(['status' => 2, 'projectsCount' => 1]);
            }

            // Return a JSON response indicating successful deletion
            return response()->json(['status' => 1, 'projectsCount' => $projectsCount]);
        } catch (\Exception $e) {
            // Handle and log any exceptions that occurred
            return response()->json(['status' => 0, 'error' => $e->getMessage()], 500);
        }
    }


    public function checkUniqueProjectName(Request $request)
    {
        $projectName = $request->input('project_name');
        if ($request->projectId != 0) {
            $existingProject = Projects::where('name', $projectName)->where("user_id", Auth::id())->where('id', '!=', $request->projectId)->first();
        } else {
            $existingProject = Projects::where('name', $projectName)->where("user_id", Auth::id())->first();
        }

        if ($existingProject) {
            return response()->json(['message' => 'Project name already exists.', 'uniqueError' => false]);
        }

        return response()->json(['message' => 'Project name is unique.', 'uniqueError' => true]);
    }

    public function checkValidUrl(Request $request)
    {
        
        $url = $request->input('url'); // Get the URL from the request
        // Initialize a Guzzle HTTP client
       
        try {
            $client = new Client([
                'allow_redirects' => [
                    'track_redirects' => true,
                ],
                'http_errors' => false,  // Prevent Guzzle from throwing exceptions for 4xx and 5xx status codes
                'timeout' => 8,   // Set the request timeout
            ]);
            // Send a GET request to the URL
            //  $response = Http::get($url);
             $response = Http::timeout(8)->get($url);
             $response = $client->get($url);

             // Get the redirected URL from the response headers
             $redirectHistory = $response->getHeader('X-Guzzle-Redirect-History');
             $redirectedUrl = end($redirectHistory) ?: $url; // Use the last URL in the history or the original URL
     
             // Get the response status code
             $statusCode = $response->getStatusCode();
             $firstXmlUrl = '';
            // Check if the response status code is 200
            if ($response->getStatusCode() === 200) {
                $sitemap = false;
                if ($request->has('sitemap') && $request->sitemap) {
                    $xmlContent = $response->getBody()->getContents(); // Retrieve the response body as a string
                    $xml = @simplexml_load_string($xmlContent); // Suppress errors and try to load as XML
    
                    // Check for <urlset> or <sitemapindex> tags
                    if ($xml && (isset($xml->url) || isset($xml->sitemap))) {
                        $sitemap = true;
                    }
                } else {
                    $firstXmlUrl = $this->getAllSitemaps($redirectedUrl);
                }
                
                
                return response()->json(['message' => 'URL is valid and available.', 'valid'=>true, 'redirectedUrl'=>$redirectedUrl, 'firstXmlUrl'=>$firstXmlUrl, 'sitemap'=>$sitemap]);
            } else {
                return response()->json(['message' => 'URL is valid but returned a non-200 status code.', 'valid'=>false]);
            }
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., connection error, invalid URL)
            return response()->json(['message' => 'URL is not valid or unavailable.', 'valid'=>false]);
        }
    }

   
    public function getAllSitemaps_1($url)
    {
            $client = new Client();
            $allSitemaps = [];

            // Fetch robots.txt
            try {
                $response = $client->get($url . '/robots.txt');
                $robotsContent = $response->getBody()->getContents();
            } catch (\Exception $e) {
                return ['error' => 'Could not fetch robots.txt'];
            }

            // Extract sitemap URLs from robots.txt
            preg_match_all('/https?:\/\/[^\s]+\.xml/', $robotsContent, $matches);
            $initialSitemaps = $matches[0] ?? [];

            foreach ($initialSitemaps as $sitemapUrl) {
                // Skip URLs with .gz extension
                if (str_ends_with($sitemapUrl, '.gz')) {
                    continue;
                }

                if (!in_array($sitemapUrl, $allSitemaps)) {
                    $allSitemaps[] = $sitemapUrl;

                    // Fetch and parse the sitemapindex
                    try {
                        $response = $client->get($sitemapUrl);
                        $content = $response->getBody()->getContents();
                        $xml = simplexml_load_string($content);

                        // If it's a sitemap index, extract all <loc> URLs
                        if (isset($xml->sitemap)) {
                            foreach ($xml->sitemap as $sitemap) {
                                $loc = (string)$sitemap->loc;

                                // Skip URLs with .gz extension
                                if (str_ends_with($loc, '.gz')) {
                                    continue;
                                }

                                if (!in_array($loc, $allSitemaps)) {
                                    $allSitemaps[] = $loc;
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        // Skip problematic sitemaps
                    }
                }
            }

            // Remove duplicates
            $allSitemaps = array_unique($allSitemaps);
            return $allSitemaps;
    }


    
    public function getAllSitemaps($url)
{
    $client = new Client();
    $allSitemaps = [];

    // Try to fetch robots.txt
    try {
        $response = $client->get($url . '/robots.txt');
        $robotsContent = $response->getBody()->getContents();

        // Extract sitemap URLs from robots.txt
        preg_match_all('/https?:\/\/[^\s]+\.xml/', $robotsContent, $matches);
        $initialSitemaps = $matches[0] ?? [];
    } catch (\Exception $e) {
        // If robots.txt is not found, use standard sitemap paths
        $initialSitemaps = [
            $url . '/sitemap.xml',
            $url . '/sitemap_index.xml',
            $url . '/sitemap/sitemap.xml',
            $url . '/sitemaps/sitemap.xml',
            $url . '/sitemap-index.xml',
            $url . '/sitemap1.xml',
            $url . '/sitemap-main.xml',
            $url . '/sitemap-list.xml',
            $url . '/sitemap_news.xml',
            $url . '/sitemap_images.xml',
            $url . '/sitemap_videos.xml',
            $url . '/sitemap_mobile.xml',
            $url . '/feed/sitemap.xml',
            $url . '/export/sitemap.xml',
            $url . '/google_sitemap.xml'
        ];
    }

    foreach ($initialSitemaps as $sitemapUrl) {
        // Skip URLs with .gz extension
        if (str_ends_with($sitemapUrl, '.gz')) {
            continue;
        }

        try {
            $response = $client->get($sitemapUrl);
            $content = $response->getBody()->getContents();
            $xml = simplexml_load_string($content);

            if ($xml === false) {
                continue; // Invalid XML, skip
            }

            if (!in_array($sitemapUrl, $allSitemaps)) {
                $allSitemaps[] = $sitemapUrl;
            }

            // If it's a sitemap index, extract all <loc> URLs
            if (isset($xml->sitemap)) {
                foreach ($xml->sitemap as $sitemap) {
                    $loc = (string)$sitemap->loc;

                    if (str_ends_with($loc, '.gz')) {
                        continue;
                    }

                    if (!in_array($loc, $allSitemaps)) {
                        $allSitemaps[] = $loc;
                    }
                }
            }
        } catch (\Exception $e) {
            // Skip unreachable sitemap URLs
        }
    }

    return array_unique($allSitemaps);
}
  

    public function checkValidUrl12(Request $request)
    {
        // Initialize a Guzzle HTTP client
        $client = new Client();

        try {
            // Send an HTTP GET request to the website
            $response = $client->get('https://www.codeghost.design/');
            // Check if the request was successful (HTTP status code 200)
            if ($response->getStatusCode() === 200) {
                // Get the HTML content of the page
                $htmlContent = $response->getBody()->getContents();
                // Use Symfony's DomCrawler to parse the HTML
                $crawler = new Crawler($htmlContent);

                // Find the sitemap URL in the HTML (assuming it's in a <link> tag with rel="sitemap")
                $sitemapUrl = $crawler->filter('link[rel="sitemap"]')->attr('href');

                // You now have the sitemap URL, e.g., "https://www.setmore.com/sitemap.xml"
                return response("Sitemap URL: " . $sitemapUrl);
            } else {
                // Handle the case where the request was not successful
                return response("Failed to retrieve the sitemap.", 500);
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors here
            return response("Error: " . $e->getMessage(), 500);
        }
    }

    public function checkValidUrl_bk2(Request $request)
    {
        // echo 1; exit;


        $url = 'https://www.codeghost.design/';
        $client = new Client();

        $response = $client->get($url . '/robots.txt');
        $content = $response->getBody()->getContents();

        $crawler = new Crawler($content);
        $sitemapUrl = $crawler->filter('sitemap')->first()->text();

        if (empty($sitemapUrl)) {
            $this->error('Sitemap URL not found in robots.txt');
        } else {
            $this->info('Sitemap URL: ' . $sitemapUrl);
        }

    }

    public function checkSitemapUrls(Request $request)
    {
        $urls = $request->input('urls', []);
        $results = [];

        foreach ($urls as $url) {
            $url = trim($url);
            if (empty($url)) {
                $results[] = ['url' => $url, 'valid' => false];
                continue;
            }

            try {
                $client = new Client([
                    'timeout' => 10,
                    'http_errors' => false,
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (compatible; WebQA/1.0)',
                        'Cache-Control' => 'no-cache'
                    ]
                ]);

                $response = $client->get($url);
                $statusCode = $response->getStatusCode();
                $contentType = $response->getHeaderLine('content-type');

                // Accept 200 and 304 as valid responses
                if ($statusCode !== 200 && $statusCode !== 304) {
                    $results[] = ['url' => $url, 'valid' => false];
                    continue;
                }

                // Check if content-type is XML
                if (empty($contentType) || !str_contains(strtolower($contentType), 'xml')) {
                    $results[] = ['url' => $url, 'valid' => false];
                    continue;
                }

                // For 304, assume valid if content-type is XML
                if ($statusCode === 304) {
                    $results[] = ['url' => $url, 'valid' => true];
                    continue;
                }

                // For 200, check the content
                $content = $response->getBody()->getContents();
                $isSitemap = str_contains($content, '<urlset') || str_contains($content, '<sitemapindex');
                
                $results[] = ['url' => $url, 'valid' => $isSitemap];

            } catch (\Exception $e) {
                $results[] = ['url' => $url, 'valid' => false];
            }
        }

        return response()->json($results);
    }

}