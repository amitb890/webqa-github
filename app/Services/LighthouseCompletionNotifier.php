<?php

namespace App\Services;

use App\Mail\PageSpeedCompletedMail;
use App\Models\LighthouseTest;
use App\Models\Projects;
use App\Models\User;
use App\Support\LighthouseUrlParser;
use App\Support\UserDisplayName;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class LighthouseCompletionNotifier
{
    /**
     * Send the page-speed completion email once all URL/strategy results are finished.
     */
    public static function maybeSend(int $testId): void
    {
        $test = LighthouseTest::find($testId);
        if (! $test) {
            return;
        }

        $total = $test->results()->count();
        if ($total === 0) {
            return;
        }

        $completed = $test->results()->where('status', 'completed')->count();
        $failed = $test->results()->where('status', 'failed')->count();

        if ($completed + $failed !== $total) {
            return;
        }

        DB::transaction(function () use ($testId) {
            $test = LighthouseTest::lockForUpdate()->find($testId);
            if (! $test || $test->completion_email_sent_at) {
                return;
            }
            if (! $test->send_completion_email) {
                $test->update(['completion_email_sent_at' => now()]);

                return;
            }

            $user = User::find($test->user_id);
            if (! $user) {
                $test->update(['completion_email_sent_at' => now()]);

                return;
            }

            $project = Projects::find($test->project_id);
            $projectName = $project ? $project->name : 'your project';

            $urlCount = count(LighthouseUrlParser::fromStoredJson($test->urls));

            $reportUrl = URL::to('/reports/google-page-speed-insights');
            if ($project) {
                $reportUrl .= '?project_id='.$project->id;
            }

            try {
                Mail::to($user->email)->send(new PageSpeedCompletedMail(
                    UserDisplayName::firstName($user->name),
                    $projectName,
                    $urlCount,
                    $reportUrl
                ));
            } catch (\Throwable $e) {
                Log::warning('Page speed completion email failed: '.$e->getMessage(), [
                    'lighthouse_test_id' => $test->id,
                    'user_id' => $user->id,
                ]);

                return;
            }

            $test->update(['completion_email_sent_at' => now()]);
        });
    }
}
