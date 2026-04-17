<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Page;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

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
        return view('pages.careers');
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

        JobApplication::create([
            'full_name'   => $validated['full_name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'position'    => $validated['position'],
            'resume_path' => $path,
        ]);

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

        ServiceRequest::create($validated);

        return back()->with('success', 'Your service request has been submitted! Our team will contact you shortly.');
    }
}
