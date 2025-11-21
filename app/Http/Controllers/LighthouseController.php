<?php

namespace App\Http\Controllers;

use App\Jobs\RunLighthouseTest;
use App\Models\LighthouseTest;
use App\Models\LighthouseResult;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\ProjectsController;

use Illuminate\Support\Facades\Auth;

class LighthouseController extends Controller
{
    public function startTests(Request $request)
    {
        $projectsController = new ProjectsController();
        $urls = $request->input('urls');
        $project_id = $request->input('project_id');

        if (empty($urls) || !is_array($urls)) {
            return response()->json(['error' => 'Please provide a valid list of URLs.'], 400);
        }

        // updating google tests status
        $projectsController->updateGoogleStatus($project_id);


        $testId = Str::uuid();



        $test = LighthouseTest::create([
            'test_id' => $testId,
            'project_id' => $request->project_id,
            'user_id' => 8,
            'urls' => json_encode($request->urls),
            'status' => 'in_progress',
        ]);
    
        dispatch(new RunLighthouseTest($test->id))->onQueue('lighthouse');
    
        return response()->json([
            'message' => 'Test started successfully',
            'test_id' => $test->id,
        ]);





    }

    public function checkStatus($projectId)
    {


        $lighthouseTest = LighthouseTest::where('project_id', $projectId)->first();

        if (!$lighthouseTest) {
            return response()->json(['error' => 'Test ID not found.'], 404);
        }

        // Get URL-level results
        $details = LighthouseResult::where('test_id', $lighthouseTest->id)->get();


        
        $completedCount = 0;

        foreach ($details as $detail) {
            if (in_array($detail->status, ['completed', 'failed'])) {
                $completedCount++;
            }
        }
    
        // Determine main dashboard test status
        $status = 'in_progress';
        if ($details->count() > 0 && $completedCount === $details->count()) {
            $status = 'completed';
        }
    
        // Optionally update the main DashboardTests status in DB
        $lighthouseTest->update(['status' => $status]);
    
        return response()->json([
            'status' => $status,
            'results' => $details
        ]);
    }
}
