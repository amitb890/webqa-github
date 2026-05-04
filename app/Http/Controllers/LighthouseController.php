<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProjectsController;
use App\Jobs\RunLighthouseTest;
use App\Models\LighthouseResult;
use App\Models\LighthouseTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LighthouseController extends Controller
{
    public function startTests(Request $request)
    {
        if (! Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $projectsController = new ProjectsController();
        $urls = $request->input('urls');
        $project_id = $request->input('project_id');
        $userId = (int) Auth::id();
        $lighthouseQueues = ['lighthouse_1','lighthouse_2','lighthouse_3','lighthouse_4','lighthouse_5'];

        if (empty($urls) || ! is_array($urls)) {
            return response()->json(['error' => 'Please provide a valid list of URLs.'], 400);
        }

        // updating google tests status
        $projectsController->updateGoogleStatus($project_id);

        $testId = Str::uuid();

        $sendCompletionEmail = $request->boolean('send_completion_notification', true);

        $test = LighthouseTest::create([
            'test_id' => $testId,
            'project_id' => $request->project_id,
            'user_id' => $userId,
            'urls' => json_encode($request->urls),
            'status' => 'in_progress',
            'send_completion_email' => $sendCompletionEmail,
        ]);

        $index = ($userId - 1) % count($lighthouseQueues);
        $userQueue = $lighthouseQueues[$index];

        dispatch(new RunLighthouseTest($test->id, Auth::id()))->onQueue($userQueue);

        $urlCount = count($request->urls);

        return response()->json([
            'message' => 'Test started successfully',
            'test_id' => $test->id,
            'url_count' => $urlCount,
        ]);





    }


    public function updateGoogleRecheckActiveUrls(Request $request)
    {
        $urlsCount = $request->input('urls_count');
        $projectId = $request->input('project_id');
       

        $project = Projects::find($projectId)->first();
        $project->update(['google_urls_checked_active' => $urlsCount]);

    }

    public function checkStatus($projectId)
    {
        $projectId = (int) $projectId;

        // Always use the latest Lighthouse test for this project
        $lighthouseTest = LighthouseTest::where('project_id', $projectId)->latest()->first();

        if (!$lighthouseTest) {
            return response()->json(['error' => 'Test ID not found.'], 404);
        }

        // Get URL-level results
        $detailsTotal = LighthouseResult::where('test_id', $lighthouseTest->id)
            ->get();

        $details = LighthouseResult::where('test_id', $lighthouseTest->id)
            ->whereIn('status', ['completed', 'failed'])
            ->get();

        
        $completedCount = 0;

        foreach ($details as $detail) {
            if (in_array($detail->status, ['completed', 'failed'])) {
                $completedCount++;
            }
        }
    
        // Determine main dashboard test status
        $status = 'in_progress';
        if ($details->count() > 0 && $completedCount === $detailsTotal->count()) {
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
