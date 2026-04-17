<?php

namespace App\Http\Controllers;

use App\Mail\NewContactMessage;
use App\Mail\NewJobApplication;
use App\Mail\NewServiceRequest;
use App\Models\ContactMessage;
use App\Models\JobApplication;
use App\Models\JobOpening;
use App\Models\Page;
use App\Models\ServiceRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('pages.show', compact('page'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function careers()
    {
        $jobOpenings = JobOpening::active()->orderBy('sort_order')->get();
        return view('pages.careers', compact('jobOpenings'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        $this->sendNotificationEmail(new NewContactMessage(
            $validated['name'],
            $validated['email'],
            $validated['phone'] ?? null,
            $validated['message'],
        ));

        return back()->with('success', 'Thank you! Your message has been sent. We\'ll get back to you within 24 hours.');
    }

    public function applyJob(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'required|string|max:50',
            'position'  => 'required|string|max:255',
            'resume'    => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $path = $request->file('resume')->store('resumes', 'public');

        $application = JobApplication::create([
            'full_name'   => $validated['full_name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'position'    => $validated['position'],
            'resume_path' => $path,
        ]);

        $this->sendNotificationEmail(new NewJobApplication($application));

        return back()->with('success', 'Your application has been submitted successfully! We will review it and get back to you.');
    }

    public function requestService(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:50',
            'company'      => 'nullable|string|max:255',
            'service_type' => 'required|in:installation,refilling,maintenance',
            'message'      => 'nullable|string|max:2000',
        ]);

        $serviceRequest = ServiceRequest::create($validated);

        $this->sendNotificationEmail(new NewServiceRequest($serviceRequest));

        return back()->with('success', 'Your service request has been submitted! Our team will contact you shortly.');
    }

    /**
     * Send notification email to the site's configured email address.
     */
    private function sendNotificationEmail($mailable): void
    {
        try {
            $to = Setting::get('email', config('mail.from.address'));
            if ($to && $to !== 'hello@example.com') {
                Mail::to($to)->send($mailable);
            }
        } catch (\Throwable $e) {
            \Log::warning('Failed to send notification email: ' . $e->getMessage());
        }
    }
}
