<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::latest();

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        $applications = $query->paginate(25)->withQueryString();
        return view('admin.job-applications.index', compact('applications'));
    }

    public function destroy(JobApplication $jobApplication)
    {
        // Delete resume file if exists
        if ($jobApplication->resume_path) {
            \Storage::disk('public')->delete($jobApplication->resume_path);
        }

        $jobApplication->delete();
        return redirect()->route('admin.job-applications.index')->with('success', 'Application deleted.');
    }
}
