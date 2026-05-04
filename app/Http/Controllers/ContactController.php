<?php

namespace App\Http\Controllers;

use App\Mail\AboutLeadMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * About Us page contact form (flat fields) or legacy JSON payloads from tools.
     */
    public function store(Request $request)
    {
        // About Us page: name, email, subject, message
        if ($request->has('message') && $request->has('name')) {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'subject' => ['nullable', 'string', 'max:200'],
                'message' => ['required', 'string', 'max:5000'],
            ]);

            $leadTo = config('mail.contact_lead_to');

            try {
                Mail::to($leadTo)->send(new AboutLeadMail(
                    $validated['name'],
                    $validated['email'],
                    trim((string) ($validated['subject'] ?? '')),
                    $validated['message']
                ));
            } catch (\Throwable $e) {
                Log::warning('About us lead email failed: '.$e->getMessage());

                return redirect()->back()->withInput()->with(
                    'contact_error',
                    'We could not send your message. Please try again or email support@webqa.co.'
                );
            }

            return redirect()->back()->with('contact_success', true);
        }

        // Legacy: nested "data" payload (e.g. tools) — keep prior behaviour
        $data = $request->input('data');
        if (! is_array($data)) {
            return response()->json(['status' => 0, 'msg' => ['form' => ['Invalid request']]], 422);
        }

        $validator = \Validator::make($data, [
            'nameContact' => ['required', 'string', 'max:50'],
            'emailContact' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9@]+/u'],
            'websiteAddress' => ['required', new \App\Rules\CustomURL],
        ], [
            'nameContact.required' => 'Name is required',
            'emailContact.required' => 'Email is required',
            'websiteAddress.required' => 'Enter your website address',
        ]);

        if (! $validator->passes()) {
            return response()->json(['status' => 0, 'msg' => $validator->errors()->toArray()]);
        }

        $payload = [
            'name' => $data['nameContact'],
            'email' => $data['emailContact'],
            'website' => $data['websiteAddress'],
        ];

        try {
            Mail::to(config('mail.contact_lead_to'))->send(new \App\Mail\ContactMail($payload));
        } catch (\Throwable $e) {
            Log::warning('ContactMail failed: '.$e->getMessage());
        }

        return response()->json(['status' => 1]);
    }
}
