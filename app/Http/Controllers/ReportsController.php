<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use DataTables;
use App\Models\Reports;
use PDF;
use App\Models\Projects;
use App\Http\Controllers\ProjectsController;
use Auth;

class ReportsController extends Controller
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
    public function getData(Request $request)
    {
        $search = $request->input('search');
        // Retrieve the data with pagination based on the requested number of records per page
        $perPage = $request->input('perPage', 10); // Default to 10 if not provided
        $query = Reports::query();

        // If search parameter is provided, apply search filter
        if ($search != "null") {
            $query->where('url', 'like', '%' . $search . '%');
        }
        $filterValue = explode(',', $request->filterValue);
        foreach ($filterValue as $key => $filterData) {

            if (
                $filterData && $filterData != 'null' &&

                ($filterData == 'equal_h1' ||  $filterData == 'duplicate')
            ) {
                $query->whereJsonContains("data->$filterData", true)->paginate($perPage);
            }

            if (
                $filterData && $filterData != 'null' &&

                ($filterData == 'Camel Case' ||  $filterData == 'Sentence Case' || $filterData == 'Neither')
            ) {
                $query->whereJsonContains("data->casing", $filterData)->paginate($perPage);
            }
        }
          $query->orderBy('data->length', $request->itemOrder);
          $data = $query->paginate($perPage);
        
        // Transform the data into the format expected by DataTables
        $formattedData = [];
        foreach ($data as $item) {
            // dd($item->data);
            $jsonFields = json_decode($item->data, true); // Assuming your JSON field is named 'json_field'

            $formattedData[] = [
                'id' => $item->id,
                'url' => $item->url,
                'type' => $item->type,
                'name' => ($jsonFields['name'] ?? null) . '  ' . $item->id, // Extract 'name' field from JSON
                'content' => $jsonFields['content'] ?? null, // Extract 'content' field from JSON
                'casing' => $jsonFields['casing'] ?? null, // Extract 'casing' field from JSON
                'duplicate' => ($jsonFields['duplicate'] === true) ? "Yes" : "No", // Extract 'duplicate' field from JSON, handle if it doesn't exist
                'equal_h1' => ($jsonFields['equal_h1'] === true) ? "Yes" : "No",
                'length' =>  $jsonFields['length'] ?? 1,
            ];
        }
        
        // Return the formatted data along with the total number of records
        return DataTables::of($formattedData)
            ->setTotalRecords($data->total()) // Set the total number of records
            ->make(true);
    }

    public function downloadPdfReport(Request $request)
    { 
        // Get the data from the DataTable
        $data = $request->input('data'); // Assuming 'data' is the parameter containing DataTable data
        $pdfArray = [];
        foreach(json_decode($data) as $key=>$data1) {
            $pdfArray[$key]['URL'] = $data1->url;
            $pdfArray[$key]['Meta Title Content'] = $data1->content;
            $pdfArray[$key]['Length'] = $data1->length;
            $pdfArray[$key]['Casing'] = $data1->casing;
            $pdfArray[$key]['Is it Duplicate?'] = $data1->duplicate;
            $pdfArray[$key]['Is it Equal to H1?'] = $data1->equal_h1;
        }
        $activeProject = $this->getActiveProjects();
        // Convert data to PDF
        $pdf = PDF::loadView('reports.reports_pdf', ['data' => $pdfArray, 'activeProject' => $activeProject]);
        // Download the PDF
        return $pdf->download('Meta Title Report - ' .$activeProject->name.'.pdf');
    }
    public function show($slug)
    {
        $activeProject = $this->getActiveProjects();
        $projectId = $activeProject ? $activeProject->id : 1;
        $projectsController = new ProjectsController();
        $labels = json_decode(json_encode($projectsController->getLabels($projectId)))->original->all_labels;

        $helpers = new Helper();
        $data = $helpers->getAllTests();
        $newSlug = "/reports/" . $slug;

        foreach ($labels as $label) {
            if ($newSlug === $label->reportsUrl) {
                return view("reports.show", compact("label",  "slug"));
            }
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reports $report)
    {
        if ($report->delete()) {
            return response()->json(['success' => true, 'message' => 'Report deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to delete report.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getActiveProjects(){
        $activeProject = "";
        if(isset($_COOKIE["activeProject"])) {
            $activeProject = $_COOKIE["activeProject"];
            $activeProjectExplode = explode('-', $activeProject);
            $activeProjectId = $activeProjectExplode[1];
            $activeProject = Projects::all()->where("id", $activeProjectId)->first();
        } else {
            $project = Projects::all()->where("user_id", Auth::id())->sortByDesc("id")->first();
            $activeProject = $project;
        }
        return $activeProject;
        
    }
}
