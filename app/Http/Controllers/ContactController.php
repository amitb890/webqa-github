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
        // About Us page. Name and subject are optional; email and message are required.
        if ($request->boolean('about_contact')) {
            $validator = \Validator::make($request->all(), [
                'name' => ['nullable', 'string', 'max:100', 'regex:/^[\p{L}][\p{L}\s.\'’-]{0,99}$/u'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'subject' => ['nullable', 'string', 'max:200'],
                'message' => ['required', 'string', 'min:10', 'max:5000'],
            ], [
                'email.required' => 'Email is required.',
                'email.email' => 'Enter a valid email address.',
                'name.max' => 'Name must be 100 characters or fewer.',
                'name.regex' => 'Use letters, spaces, apostrophes, or hyphens.',
                'subject.max' => 'Subject must be 200 characters or fewer.',
                'message.required' => 'Message is required.',
                'message.min' => 'Message should be at least 10 characters.',
                'message.max' => 'Message must be 5,000 characters or fewer.',
            ]);

            if ($validator->fails()) {
                return redirect()->to(url()->previous().'#contact')
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();

            $leadTo = config('mail.about_contact_to', 'contact@webqa.co');

            try {
                Mail::to($leadTo)->send(new AboutLeadMail(
                    trim((string) ($validated['name'] ?? '')),
                    $validated['email'],
                    trim((string) ($validated['subject'] ?? '')),
                    $validated['message']
                ));
            } catch (\Throwable $e) {
                Log::warning('About us lead email failed: '.$e->getMessage());

                return redirect()->to(url()->previous().'#contact')->withInput()->with(
                    'contact_error',
                    'We could not send your message. Please try again or email contact@webqa.co.'
                );
            }

            return redirect()->to(url()->previous().'#contact')->with('contact_success', true);
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
