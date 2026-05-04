<?php

namespace App\Http\Controllers;

use App\Mail\DashboardSidebarIdeaMail;
use App\Mail\DashboardTileLeadMail;
use App\Models\FeaturesRequest;
use App\Rules\CustomURL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FeatureRequestController extends Controller
{
    public function store(Request $request)
    {
        if ($request->boolean('from_dashboard_tile')) {
            return $this->storeDashboardTile($request);
        }

        return $this->storeSidebarIdea($request);
    }

    /**
     * Last dashboard widget: email + message only.
     */
    private function storeDashboardTile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ideaMessage' => ['required', 'string', 'max:2000'],
        ], [
            'ideaMessage.required' => 'Message is required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'msg' => $validator->errors()->toArray()]);
        }

        $user = Auth::user();
        $email = $user->email;
        if ($email === null || $email === '') {
            return response()->json(['status' => 0, 'msg' => ['email' => ['Your account has no email on file.']]]);
        }

        $message = $request->input('ideaMessage');

        try {
            Mail::to(config('mail.contact_lead_to'))->send(new DashboardTileLeadMail($email, $message));
        } catch (\Throwable $e) {
            Log::warning('Dashboard tile lead email failed: '.$e->getMessage());

            return response()->json([
                'status' => 3,
                'msg' => 'Something went wrong sending your message. Please try again later.',
            ]);
        }

        try {
            $feature = new FeaturesRequest();
            $feature->user_id = Auth::id();
            $feature->name = Auth::user()->name ?? '';
            $feature->email = $email;
            $feature->url = null;
            $feature->message = $message;
            $feature->importance = 'NA';
            $feature->file = null;
            $feature->save();
        } catch (\Throwable $e) {
            Log::warning('Dashboard tile lead DB save failed: '.$e->getMessage());
        }

        return response()->json(['status' => 1, 'msg' => 'Thank you — your message was sent.']);
    }

    /**
     * Sidebar “Submit your idea” form with optional attachment.
     */
    private function storeSidebarIdea(Request $request)
    {
        $maxKb = (int) config('mail.dashboard_feature_attachment_max_kb', 5120);

        $data = $request->all();
        if (! isset($data['ideaName'])) {
            $data['ideaName'] = Auth::user()->name;
        }
        if (! isset($data['ideaEmail'])) {
            $data['ideaEmail'] = Auth::user()->email;
        }
        if (! isset($data['ideaImportance'])) {
            $data['ideaImportance'] = 'Important';
        }

        $rules = [
            'ideaName' => ['required', 'string', 'max:100'],
            'ideaEmail' => ['required', 'string', 'email', 'max:255'],
            'ideaMessage' => ['required', 'string', 'max:8000'],
            'ideaImportance' => ['required', 'string', 'max:50'],
            'ideaAttachment' => ['nullable', 'file', 'max:'.$maxKb],
        ];

        $validator = Validator::make($data, $rules, [
            'ideaName.required' => 'Name is required',
            'ideaEmail.required' => 'Email is required',
            'ideaMessage.required' => 'Issue description is required',
            'ideaAttachment.max' => 'Attachment must be '.$maxKb.' KB or smaller.',
        ]);

        $validator->sometimes('ideaUrl', [new CustomURL], function ($input) {
            return $input->ideaUrl != '';
        });

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'msg' => $validator->errors()->toArray()]);
        }

        $attachmentRelative = null;
        $attachmentAbsolutePath = null;
        $attachmentOriginalName = null;

        if ($request->hasFile('ideaAttachment')) {
            $file = $request->file('ideaAttachment');
            if ($file->isValid()) {
                $attachmentOriginalName = $file->getClientOriginalName();
                $safeBase = preg_replace('/[^\w\.\-\(\)\s]/', '_', basename($attachmentOriginalName));
                $storedName = uniqid('idea_', true).'_'.$safeBase;
                $attachmentRelative = $file->storeAs('uploads/feature-requests', $storedName, 'project');
                $attachmentAbsolutePath = Storage::disk('project')->path($attachmentRelative);
            }
        }

        $name = $request->input('ideaName');
        $email = $request->input('ideaEmail');
        $url = (string) $request->input('ideaUrl', '');
        $issueMessage = $request->input('ideaMessage');
        $severity = $request->input('ideaImportance');

        try {
            Mail::to(config('mail.contact_lead_to'))->send(new DashboardSidebarIdeaMail(
                $name,
                $email,
                $url === '' ? '—' : $url,
                $issueMessage,
                $severity,
                $attachmentAbsolutePath && is_readable($attachmentAbsolutePath) ? $attachmentAbsolutePath : null,
                $attachmentOriginalName
            ));
        } catch (\Throwable $e) {
            Log::warning('Sidebar idea email failed: '.$e->getMessage());

            return response()->json([
                'status' => 3,
                'msg' => 'Something went wrong sending your message. Please try again later.',
            ]);
        }

        $feature = new FeaturesRequest();
        $feature->user_id = Auth::id();
        $feature->name = $name;
        $feature->email = $email;
        $feature->url = $url === '' ? null : $url;
        $feature->message = $issueMessage;
        $feature->importance = $severity;
        $feature->file = $attachmentRelative ? Storage::disk('project')->path($attachmentRelative) : null;

        if (! $feature->save()) {
            return response()->json(['status' => 3, 'msg' => 'Something went wrong, Please try again later.']);
        }

        return response()->json(['status' => 1, 'msg' => 'Feature request sent successfully.']);
    }
}
